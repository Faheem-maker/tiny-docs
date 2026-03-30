<?php

$packages = [
    'tinyframework/core' => 'core'
];

$workingDir = __DIR__ . '/../temp';
$docsDir = __DIR__ . '/../docs/api-reference';

foreach ($packages as $packageName => $folderName) {
    echo "Processing $packageName...\n";

    $packagePath = "$workingDir/$folderName";

    // 2. Load autoloader
    $autoloader = "$packagePath/vendor/autoload.php";
    if (!file_exists($autoloader)) {
        echo "Error: Autoloader not found for $packageName\n";
        continue;
    }
    require_once $autoloader;

    $srcPath = "$packagePath/src";
    if (!is_dir($srcPath)) {
        // Try 'lib' if 'src' doesn't exist
        $srcPath = "$packagePath/lib";
    }

    if (!is_dir($srcPath)) {
        echo "Error: Source directory not found for $packageName\n";
        continue;
    }

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($srcPath));
    $phpFiles = new RegexIterator($files, '/\.php$/');

    $packageDocsDir = "$docsDir/$folderName";
    if (!is_dir($packageDocsDir)) {
        mkdir($packageDocsDir, 0777, true);
    }

    $classList = [];

    foreach ($phpFiles as $file) {
        $filePath = $file->getRealPath();
        $className = getClassNameFromFile($filePath);

        if ($className && class_exists($className)) {
            echo "Documenting $className...\n";
            $md = generateClassMarkdown($className);
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
            
            // Extract group name from path (e.g. "framework/db/QueryBuilder" -> "db")
            $parts = explode('/', $cleanPath);
            $groupName = count($parts) > 1 ? ucfirst($parts[count($parts) - 2]) : 'General';
            
            // Special mapping for common groups
            if ($groupName === 'framework') $groupName = 'Core';
            
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
            'collapsed' => false,
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
function generateClassMarkdown($className)
{
    $reflection = new ReflectionClass($className);

    $type = "Class";
    if ($reflection->isInterface())
        $type = "Interface";
    if ($reflection->isTrait())
        $type = "Trait";

    $md = "# $type: $className\n\n";

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

/**
 * Clean doc comments (minimal)
 */
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
