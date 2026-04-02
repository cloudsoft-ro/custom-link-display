# Changelog

All notable changes to this project will be documented in this file.

## [1.1.0] - 2026-04-02
### Added
- **Regex Match**: Added "Regex Match" option for URL patterns.
- **Shortcode System**: New `[ucc_content id="..."]` shortcode for manual content placement.
- **Drag & Drop**: Added jQuery UI Sortable for rule reordering and matching priority.
- **Premium UI**: Enhanced admin interface with a new "Shortcode" column and improved styling.
- **Copy-to-Clipboard**: Added one-click copy functionality for rule shortcodes.

### Fixed
- **Fatal Error**: Fixed PHP fatal error caused by premature plugin initialization during activation.
- **Admin JS**: Fixed missing variable declarations in `admin-script.js`.
- **Plugin Headers**: Added missing standard WordPress plugin headers (`Requires at least`, `Tested up to`, `Requires PHP`).
- **URL Normalization**: Fixed a bug where regex patterns were incorrectly parsed like standard URLs during save.

### Changed
- **Branding**: Renamed the plugin to **Custom Link Display** and updated the text domain to `custom-link-display`.
- **File Structure**: Renamed the main plugin file to `custom-link-display.php` for consistency.

## [1.0.0] - 2026-03-31
- Initial release as URL Conditional Content.
