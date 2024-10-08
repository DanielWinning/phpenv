# PHPEnv | Changelog

## [1.4.1] - 2024-08-21
### Added
- N/A

### Changed
- Remove `lower_case_table_names` restriction on MySQL container

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- N/A

### Security
- N/A

---

## [1.4.0] - 2024-03-24
### Added
- Additional PHP extensions included by default: `bcmath, exif`

### Changed
- Reduced range of dynamic port generation to avoid conflicts and avoid assigning a "well-known" port
- More robust port checking to prevent ports being assigned that Docker can't access

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- Fixed typo in `Dockerfile` that was creating extra unneeded directories in the container
- Fixes [#12](https://github.com/DanielWinning/phpenv/issues/12) - sets dynamic client port for PHP container

### Security
- N/A

---

## [1.3.0] - 2024-03-23
### Added
- Added `nvm`, `node`, `npm` and `npx` to the PHP container [#5](https://github.com/DanielWinning/phpenv/issues/5)

### Changed
- Upgraded from PHP `8.2` > `8.3` [#8](https://github.com/DanielWinning/phpenv/issues/8)

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- Fixes issue [#6](https://github.com/DanielWinning/phpenv/issues/6)

### Security
- N/A

---

## [1.2.0] - 2024-03-23
### Added
- Added `CHANGELOG.md`

### Changed
- Added `coverage` to `xdebug.mode`
- Added `xdebug.idekey` set to `PHPENV`
- Attach command now enters into the project root (`/var/www/html`)

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- N/A

### Security
- N/A