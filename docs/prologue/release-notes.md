# Release Notes

[[toc]]

## Release Cycle
Bolt PHP is built with several differnet packages, each of which might have a different version. With each release, you can find the latest versions available at that time.

Bolt PHP follows a weekly release cycle, with major releases being published around once a month.

## Recent Relases
::: info
Later items appear on top
:::

### v1.0.5 (2026-05-15)

[Read the Release Notes](/blog/v1.0.5-release.md)

<details>
<summary>Internal Versions</summary>

| Package                   | Version |
| ------------------------- | ------- |
| `bolt-php\contracts` | 1.0.2   |
| `bolt-php\core`      | 1.1.3   |
| `bolt-php\web`       | 1.0.4   |
| `bolt-php\console`   | 1.0.2   |
| `bolt-php\bolt`      | 1.1.3   |

::: info
From this release, the rename is officially adapted and older packages are abandoned.
:::

</details>

### Fixes

* Fixed a bug with duplicate slash due to leading route slash
* Fixed directory casing for widgets on UNIX

### Changes

* Improved coverage for `web` package
* Renamed the framework to `bolt-php`

### v1.0.4 (2026-05-02)

[Read the Release Notes](/blog/v1.0.4-release.md)

<details>
<summary>Internal Versions</summary>

| Package                   | Version |
| ------------------------- | ------- |
| `bolt-php\contracts` | 1.0.2   |
| `bolt-php\core`      | 1.1.3   |
| `bolt-php\web`       | 1.0.3   |
| `bolt-php\console`   | 1.0.2   |
| `bolt-php\bolt`      | 1.1.3   |

::: info
From this release, the versions will use 3 version numbers instead of 4
:::

</details>

### Fixes

* Fixed table existence check for SQLite driver
* Fixed duplicate component initialization bug
* Fixed ORM issue where data couldn’t be selected
* Fixed incorrect return type (array instead of object)
* Fixed path resolution issues on Linux
* Fixed nested parenthesis handling in `@if` directive
* Fixed handling of empty values in widget parameters
* Fixed route naming outside of groups

### Additions

* Added `Response::file()` for correct MIME type file responses
* Added `migration:rollback` command to revert migrations

### Changes

* Improved test coverage
* Modified `Model::fill` to ignore empty values
* Changed `serve` to start in the `public` directory

### v1.0.3 (2026-04-20)

[Read the Release Notes](/blog/v1.0.3-release.md)

<details>
<summary>Internal Versions</summary>

| Package                   | Version |
| ------------------------- | ------- |
| `bolt-php\contracts` | 1.0.2.1 |
| `bolt-php\core`      | 1.1.1.6 |
| `bolt-php\web`       | 1.0.1.5 |
| `bolt-php\console`   | 1.0.1.3 |
| `bolt-php\bolt`      | 1.1.2.2 |

</details>

### Fixes
- Fixed a bug where unnamed routes weren't being created

### Additions
- Added support for migrations
- Added `Image`, `Size` and `Extension` validators
- Added `transaction` and `orderBy` methods to database

### v1.0.2 (2026-04-05)

[Read the Release Notes](/blog/v1.0.2-release.md)

<details>
<summary>Internal Versions</summary>

| Package                   | Version |
| ------------------------- | ------- |
| `bolt-php\contracts` | 1.0.2.1 |
| `bolt-php\core`      | 1.1.1.5 |
| `bolt-php\web`       | 1.0.1.4 |
| `bolt-php\console`   | 1.0.1.2 |
| `bolt-php\bolt`      | 1.1.2.2 |

</details>

### Changes
- You can now pass multiple parameters to `ActiveModel::from`
- DateTime handling for database now uses transformers
- `UrlManager::named` now returns a full URL
- `.env` will now be auto-copied instead of requiring manual intervention.

### Fixes
- Fixed a bug that prevented us from setting values on ActiveModel
- Fixed namespace in table & form widgets

### Additions
- Added transformers for extending `ActiveModel` with custom types
- Added `--rest` flag for REST controller generation
- Added `params` to `named` & `to` methods for URL generation with auto-parameterization

### v1.0.1 (2026-04-05)

<details>
<summary>Internal Versions</summary>

| Package                   | Version |
| ------------------------- | ------- |
| `bolt-php\contracts` | 1.0.2.1 |
| `bolt-php\core`      | 1.1.1.4 |
| `bolt-php\web`       | 1.0.1.1 |
| `bolt-php\console`   | 1.0.0.0 |
| `bolt-php\bolt`      | 1.1.1.0 |

</details>

#### Changes
- Made `\framework\components\Logger::$logger` public to allow changing the logger driver
- Improved developer experience by type-hinting components in `Application` and `WebApplication`
- Simplified dependencies by removing unused and redundant libraries (e.g., child packages now handled by parent packages)

#### Fixes
- Corrected `@root` path resolution in `PathManager` so directives like `@root` work as expected
- Fixed request handling in `\framework\web\request\Request` where GET incorrectly took precedence over POST
- Resolved namespace issues in `WidgetManager` and related components

#### Additions
- Added `\framework\components\FileSystem` component
- Introduced test coverage for all core components

#### Notes
The release fixes most of the prevelant issues. However, a few versions can be expected before the framework is considered stable.

### v1.0.0 (2026-03-29)

<details>
<summary>Internal Versions</summary>

| Package                   | Version |
| ------------------------- | ------- |
| `bolt-php\contracts` | 1.0.2.0 |
| `bolt-php\core`      | 1.1.1.3 |
| `bolt-php\web`       | 1.0.1.0 |
| `bolt-php\console`   | 1.0.0.0 |
| `bolt-php\bolt`      | 1.1.0.0 |

</details>

#### Notes
This release marks the first official release available on composer. The release is not ready for production and should only be used for toy projects.