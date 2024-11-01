# Kirby Menu

## 1.0.1

- **BREAKING:** Replaced wrong usage of ARIA-Attributes with CSS-Classes.
  *Requires reconfiguration and adjustments in your CSS-Rules.*
  - Added option `activeDescPageCssClass` (default: `active-desc`), field and HTML-Output
  - Added option `activePageCssClass` (default: `active`), field and HTML-Output
  - Removed option `activeDescPageAttr` (defaulted to ARIA-Attribute `aria-activedescendant`), field and HTML-Output
  - Removed option `activePageAttr` (defaulted to ARIA-Attribute `aria-current`), field and HTML-Output
- Fixed: Empty field- & option-values of `listEntryTag` default to `li` now
- Updated README

## 1.0.0

- Initial release