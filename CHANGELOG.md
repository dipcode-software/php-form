# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [3.0.0] - 2022-11-23
### Added
 - Added support for php8 removing package `fleshgrinder/format` from project. This package is no longer needed, its functionality has been replaced by native php code.
### Fixed
 - Fixed Twig class paths

## [2.1.5] - 2019-10-04
### Fixed
 - Moved validation of invalid file to validate function to avoid wrong behavior.

## [2.1.4] - 2019-05-10
### Added
 - Added missing varible (attributes) to `BoundWidget` class

## [2.1.3] - 2019-01-18
### Fixed
 - Validate choice field if is not empty and if is not a valid choice

## [2.1.2] - 2018-04-21
### Fixed
 - Validation of dates

## [2.1.1] - 2018-04-20
### Fixed
 - Forced choice value to be string when marking selected

## [2.0.4] - 2018-03-XX
### Fixed
 - `data` and `files` were wrongly exposed on `Form` class. Changed visibility to private and added `getData` and `getFiles` methods.
 - Allow non-required file fields
 - Fixed choice field values check
 - Added retrocompability between Twig v1 and v2
 - Fixed Widget format value

## [2.0.3] - 2017-12-13
### Added
 - `setRequired` to `Field` class;
 - Twig Filter `merge_str` to merge value into as array value through implode.

### Fixed
 - Form field error class being ignored in `Bootstrap4TemplatePack`.

## [2.0.2] - 2017-12-12
### Changed
 - `Twig` minimal version supported setted to `>=1.35`.

## [2.0.1] - 2017-12-11
### Changed
 - Loading `Twig` classes with psr-4 mode;
 - Select `option` tag don't render `value` if it is empty.

## [2.0.0] - 2017-12-11
### Added
 - Documentation of package;
 - Renderers to facilitate integrations of template-engines:
    - Added `Renderer` interface;
    - Added `TwigRenderer` that integrates `twig/twig`;
    - Added fallback template loading support.
 - Template packs to facilitate customization and extensibility of templates:
    - Added abstract class `TemplatePack`;
    - Added template pack `DefaultTemplatePack`. Defined as default template pack;
    - Added template pack `Bootstrap4TemplatePack` that integrates Bootstrap v4.0.0-beta.2.
 - `Config` singleton class allowing:
    - Configure custom template packs;
    - Configure custom messages;
    - Configure custom renderers.
 - Added extra arg `label` to method `getContext` of `Widget` class;
 - `BoundWidget` class to represent the choices of a `ChoiceWidget` in `BoundField`, allowing individual render or data access to each option.

### Changed
 - `BoundField` moved from `Fields` to new namespace `Bounds`;
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
