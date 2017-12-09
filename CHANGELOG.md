# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [1.1.0] - XXXX-XX-XX
### Added
 - Renderers to facilitate integrations of template-engines:
    - Added `Renderer` interface;
    - Added `TwigRenderer` that integrates `twig/twig`;
    - Added fallback template loading support.
 - Template packs to facilitate customization and extensibility of templates:
    - Added template pack `default` and defined as fallback;
    - Added template pack `bootstrap4` that integrates custom elements of Bootstrap v4.0.0-beta.2.
 - Added extra arg `label` on method `getContext` of `Widget` class;
 - Support to configure renderer and template pack through `Config` singleton class;

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
