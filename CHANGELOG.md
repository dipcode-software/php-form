# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [1.1.0] - XXXX-XX-XX
### Added
 - Renderers to facilitate integrations of template-engines:
    - Added integration to `twig/twig` through `TwigRenderer` class renderer (defined as default);
 - Template packs to facilitate customization and extensibility of templates:
    - Added template pack `default` and `bootstrap4`.
 - Support to configure default renderer and default template pack through `Config` singleton class;

### Changed
 - Class name `PHPFormConfig` to `Config` and moved to `src/` directory;
 - `BoundField` attribute name `choices` changed to `options`;
 - `BoundField` attribute `options` now return an array instead of formated string;
 - `Widgets`, `labelTag` and `ErrorList` now render through default renderer instead of formatter `fleshgrinder/format`;
 - `CheckboxSelectMultiple` and `RadioSelect` widget wrapped in an unordered list tag instead of previous `div`;
 - Method name `getSubWidgets` to `getOptions` in `Widgets` class;

### Removed:
 - Method `asUL` from `ErrorList` class;
 - `config.php` and `templates.php` files;
 - Static method `flatatt` from `Attributes` class;

## [1.0.1] - 2017-12-07
### Added
 - Added CHANGELOG.md file.

### Fixed
 - Fix formatValue method on ChoiceWidget when value is empty or null;
 - Fix validate on ChoiceField when value if empty and not required.

## [1.0.0] - 2017-12-07
 - First release;
