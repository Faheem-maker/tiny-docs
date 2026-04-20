# Release Notes

[[toc]]

## Release Cycle
Tiny PHP is built with several differnet packages, each of which might have a different version. With each release, you can find the latest versions available at that time.

Tiny PHP follows a weekly release cycle, with major releases being published around once a month.

## Recent Relases
::: info
Later items appear on top
:::

### v1.0.3 (2026-04-20)

[Read the Release Notes](/blog/v1.0.3-release.md)

<details>
<summary>Internal Versions</summary>

| Package                   | Version |
| ------------------------- | ------- |
| `tinyframework\contracts` | 1.0.2.1 |
| `tinyframework\core`      | 1.1.1.6 |
| `tinyframework\web`       | 1.0.1.5 |
| `tinyframework\console`   | 1.0.1.3 |
| `tinyframework\tiny`      | 1.1.2.2 |

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
| `tinyframework\contracts` | 1.0.2.1 |
| `tinyframework\core`      | 1.1.1.5 |
| `tinyframework\web`       | 1.0.1.4 |
| `tinyframework\console`   | 1.0.1.2 |
| `tinyframework\tiny`      | 1.1.2.2 |

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
| `tinyframework\contracts` | 1.0.2.1 |
| `tinyframework\core`      | 1.1.1.4 |
| `tinyframework\web`       | 1.0.1.1 |
| `tinyframework\console`   | 1.0.0.0 |
| `tinyframework\tiny`      | 1.1.1.0 |

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
| `tinyframework\contracts` | 1.0.2.0 |
| `tinyframework\core`      | 1.1.1.3 |
| `tinyframework\web`       | 1.0.1.0 |
| `tinyframework\console`   | 1.0.0.0 |
| `tinyframework\tiny`      | 1.1.0.0 |

</details>

#### Notes
This release marks the first official release available on composer. The release is not ready for production and should only be used for toy projects.