<?php

$packages = [
    'tinyframework/core' => 'core'
];

$github = $github ?? [
    'tinyframework/core' => 'https://github.com/Faheem-maker/tiny-php-core'
];

$allClassesInfo = [];
$subclassesMap = [];

$workingDir = __DIR__ . '/../temp';
$docsDir = __DIR__ . '/../docs/api-reference';

// 1. Scan all packages for classes
foreach ($packages as $packageName => $folderName) {
    echo "Scanning $packageName...\n";
    $packagePath = "$workingDir/$folderName";
    $autoloader = "$packagePath/vendor/autoload.php";
    if (file_exists($autoloader)) {
        require_once $autoloader;
    }

    $srcPath = is_dir("$packagePath/src") ? "$packagePath/src" : (is_dir("$packagePath/lib") ? "$packagePath/lib" : null);
    if (!$srcPath)
        continue;

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($srcPath));
    $phpFiles = new RegexIterator($files, '/\.php$/');

    foreach ($phpFiles as $file) {
        $className = getClassNameFromFile($file->getRealPath());
        if ($className && (class_exists($className) || interface_exists($className) || trait_exists($className))) {
            $allClassesInfo[$className] = [
                'packageName' => $packageName,
                'folderName' => $folderName,
                'filePath' => $file->getRealPath(),
                'packageRoot' => realpath($packagePath)
            ];
        }
    }
}

// 2. Build hierarchy
foreach ($allClassesInfo as $className => $info) {
    try {
        $reflection = new ReflectionClass($className);
        $parent = $reflection->getParentClass();
        if ($parent) {
            $subclassesMap[$parent->getName()][] = $className;
        }
        foreach ($reflection->getInterfaceNames() as $interface) {
            $subclassesMap[$interface][] = $className;
        }
    } catch (Throwable $e) {
    }
}

// 3. Generate Docs
foreach ($packages as $packageName => $folderName) {
    echo "Processing $packageName...\n";
    $packageDocsDir = "$docsDir/$folderName";
    if (!is_dir($packageDocsDir)) {
        mkdir($packageDocsDir, 0777, true);
    }

    $classList = [];

    foreach ($allClassesInfo as $className => $info) {
        if ($info['packageName'] !== $packageName)
            continue;

        echo "Documenting $className...\n";
        $md = generateClassMarkdown($className, $subclassesMap, $allClassesInfo, $github);
        $relativeName = str_replace('\\', '/', $className);
        $targetPath = "$packageDocsDir/$relativeName.md";
        $targetDir = dirname($targetPath);
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        file_put_contents($targetPath, $md);
        $classList[] = [
            'name' => $className,
            'link' => "/docs/api-reference/$folderName/$relativeName"
        ];
    }

    // Generate index for this package
    $packageIndex = "# API Reference: $packageName\n\n";
    foreach ($classList as $class) {
        $packageIndex .= "- [{$class['name']}]({$class['link']})\n";
    }
    file_put_contents("$packageDocsDir/index.md", $packageIndex);
}

// Generate the sidebar automatically
echo "Generating sidebar...\n";
$sidebarData = [
    [
        'text' => 'API Reference',
        'items' => [
            ['text' => 'Overview', 'link' => '/docs/api-reference/index']
        ]
    ]
];

foreach ($packages as $packageName => $folderName) {
    // Collect all classes for this package
    $packagePath = __DIR__ . "/../docs/api-reference/$folderName";
    $groups = [];

    // Add package index
    $sidebarData[0]['items'][] = ['text' => $packageName, 'link' => "/docs/api-reference/$folderName/index"];

    // Recursively find all .md files (except index.md)
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($packagePath));
    foreach ($files as $file) {
        if ($file->getExtension() === 'md' && $file->getFilename() !== 'index.md') {
            $relativePath = str_replace(realpath($packagePath) . DIRECTORY_SEPARATOR, '', $file->getRealPath());
            $relativePath = str_replace('\\', '/', $relativePath);
            $cleanPath = str_replace('.md', '', $relativePath);

            // Extract group name from path (e.g. "framework/db/QueryBuilder" -> "framework/db")
            $parts = explode('/', $cleanPath);
            if (count($parts) > 1) {
                $groupName = implode('\\', array_slice($parts, 0, -1));
            } else {
                $groupName = 'General';
            }

            $groups[$groupName][] = [
                'text' => basename($cleanPath),
                'link' => "/docs/api-reference/$folderName/$cleanPath"
            ];
        }
    }

    foreach ($groups as $groupName => $items) {
        sort($items);
        $sidebarData[] = [
            'text' => $groupName,
            'collapsed' => true,
            'items' => $items
        ];
    }
}

// Write to .vitepress/api-sidebar.mts
$sidebarFile = __DIR__ . '/../.vitepress/api-sidebar.mts';
$sidebarTs = "export default " . json_encode($sidebarData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . ";\n";
file_put_contents($sidebarFile, $sidebarTs);

echo "Done!\n";

/**
 * Extract class name from file using regex (simple/minimal)
 */
function getClassNameFromFile($path)
{
    $content = file_get_contents($path);
    $namespace = '';
    if (preg_match('/namespace\s+([^;]+);/', $content, $matches)) {
        $namespace = trim($matches[1]);
    }

    if (preg_match('/(?:class|interface|trait)\s+([a-zA-Z0-9_]+)/', $content, $matches)) {
        return $namespace ? $namespace . '\\' . $matches[1] : $matches[1];
    }
    return null;
}

/**
 * Generate Markdown for a class using Reflection
 */
function generateClassMarkdown($className, $subclassesMap = [], $allClassesInfo = [], $githubMap = [])
{
    $reflection = new ReflectionClass($className);
    $info = $allClassesInfo[$className] ?? null;

    $type = "Class";
    if ($reflection->isInterface())
        $type = "Interface";
    if ($reflection->isTrait())
        $type = "Trait";

    $md = "# $type: $className\n\n";

    // Table of relationships
    $tableRows = [];

    // Inheritance
    $parent = $reflection->getParentClass();
    if ($parent) {
        $parentName = $parent->getName();
        $link = getClassLink($parentName, $allClassesInfo);
        $tableRows[] = "| **Inheritance** | $link |";
    }

    // Implements
    $interfaces = $reflection->getInterfaceNames();
    if (!empty($interfaces)) {
        $links = array_map(fn($i) => getClassLink($i, $allClassesInfo), $interfaces);
        $tableRows[] = "| **Implements** | " . implode(', ', $links) . " |";
    }

    // Subclasses
    if (isset($subclassesMap[$className])) {
        $links = array_map(fn($c) => getClassLink($c, $allClassesInfo), $subclassesMap[$className]);
        $tableRows[] = "| **Subclasses** | " . implode(', ', $links) . " |";
    }

    // Source Code
    if ($info && isset($githubMap[$info['packageName']])) {
        $baseUrl = rtrim($githubMap[$info['packageName']], '/');
        $relativeFile = str_replace($info['packageRoot'], '', $info['filePath']);
        $relativeFile = str_replace('\\', '/', $relativeFile);
        $relativeFile = ltrim($relativeFile, '/');
        $sourceUrl = "$baseUrl/blob/main/$relativeFile";
        $tableRows[] = "| **Source Code** | [$sourceUrl]($sourceUrl) |";
    }

    if (!empty($tableRows)) {
        $md .= "| Property | Value |\n";
        $md .= "| --- | --- |\n";
        $md .= implode("\n", $tableRows) . "\n\n";
    }

    // Description (simple docblock parse)
    $doc = $reflection->getDocComment();
    if ($doc) {
        $md .= cleanDocComment($doc) . "\n\n";
    }

    // Public Properties
    $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
    if (!empty($properties)) {
        $md .= "## Properties\n\n";
        foreach ($properties as $prop) {
            $md .= "### \${$prop->getName()}\n\n";
            $doc = $prop->getDocComment();
            if ($doc) {
                $md .= cleanDocComment($doc) . "\n\n";
            }
        }
    }

    // Public Methods
    $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
    if (!empty($methods)) {
        $md .= "## Methods\n\n";
        foreach ($methods as $method) {
            // Skip magic methods for now if desired, but user said "all public"
            $md .= "### {$method->getName()}()\n\n";
            $doc = $method->getDocComment();
            if ($doc) {
                $md .= cleanDocComment($doc) . "\n\n";
            }

            // Parameters (minimal)
            $params = $method->getParameters();
            if (!empty($params)) {
                $md .= "**Parameters:**\n\n";
                foreach ($params as $param) {
                    $ptype = $param->hasType() ? (string) $param->getType() . ' ' : '';
                    $md .= "- `{$ptype}\${$param->getName()}`\n";
                }
                $md .= "\n";
            }
        }
    }

    return $md;
}

function cleanDocComment($doc)
{
    $lines = explode("\n", $doc);
    $cleaned = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '/**' || $line === '*/' || $line === '*')
            continue;
        $line = preg_replace('/^\*\s?/', '', $line);
        if (strpos($line, '@') === 0)
            continue; // Skip tags for now
        $cleaned[] = $line;
    }
    return trim(implode("\n", $cleaned));
}

/**
 * Helper to get a markdown link for a class
 */
function getClassLink($name, $allClassesInfo)
{
    if (isset($allClassesInfo[$name])) {
        $info = $allClassesInfo[$name];
        $relativeName = str_replace('\\', '/', $name);
        return "[$name](/docs/api-reference/{$info['folderName']}/$relativeName)";
    }
    return "`$name`";
}
