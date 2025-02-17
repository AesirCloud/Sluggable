# Change Log
All notable changes to `sluggable` will be documented in this file.

## 1.1.2 - 2025-02-17
- **Feature:** Added configuration-driven slug generation. Users can now control slug source, column name, max length, and update behavior via `config/sluggable.php`.
- **Enhancement:** Unified slug creation and update logic into a single `generateSlug()` method, reducing duplication and making updates more maintainable.
- **Enhancement:** Added optional scope-based uniqueness by defining scope fields in the config file.
- **Enhancement:** Added optional truncation for slug generation to respect a maximum length (default set to 255 in the config).
- **Enhancement:** Allow skipping slug updates if `update` is set to `false` in `config/sluggable.php` or if `$slugUpdatable = false` in the model.
- **Enhancement:** Support a customizable slug column via `$slugColumn` in the model or `sluggable.column` in the config.
- **Doc:** Updated README with new usage examples and instructions for overriding default config values.


## 1.0.5 - 2024-07-11
- Fixed issue where the slug was changing on all updates. Now only changes if the source field changes.

## 1.0.4 - 2024-07-08
- Fixed where I completely f'd the service provider in the last update.

## 1.0.3 - 2024-07-08
- Fixed issue where slug was not always booting correctly.

## 1.0.2 - 2024-06-28
- Add tests

## 1.0.1 - 2024-06-27
- Update README.md

## 1.0.0 - 2024-06-27
- Initial release