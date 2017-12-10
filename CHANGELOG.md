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
    - Added abstract class `TemplatePack`;
    - Added template pack `DefaultTemplatePack`. Defined as default template pack;
    - Added template pack `Bootstrap4TemplatePack` that integrates Bootstrap v4.0.0-beta.2.
 - `Config` singleton class allowing:
    - Configure custom template packs class;
    - Configure custom messages class;
    - Configure custom renderers class.
 - Added extra arg `label` to method `getContext` of `Widget` class.

### Changed
 - `BoundField` attribute name `choices` changed to `options`;
 - `BoundField` attribute `options` now return an array instead of formated string;
 - `Widgets`, `labelTag` and `ErrorList` now render through default renderer instead of formatter `fleshgrinder/format`;
 - `CheckboxSelectMultiple` and `RadioSelect` widget wrapped in an unordered list tag instead of previous `div`;
 - Method name `getSubWidgets` to `getOptions` in `Widgets` class and now returns an array instead of formated string;
 - `messages.php` to class based definition.

### Removed:
 - `PHPFormConfig` class. Use new `Config` class instead to configure `PHPForm`;
 - `Attribute` class. All static methods, except `flatattr` which is no longer used, where migrated to `helpers.php`;
 - Method `asUL` from `ErrorList` class.

## [1.0.1] - 2017-12-07
### Added
 - Added CHANGELOG.md file.

### Fixed
 - Fix formatValue method on ChoiceWidget when value is empty or null;
 - Fix validate on ChoiceField when value if empty and not required.

## [1.0.0] - 2017-12-07
 - First release;
