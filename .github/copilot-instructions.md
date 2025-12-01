# Copilot Instructions - Toto Portfolio WordPress Theme

## Project Overview
This is a WordPress theme based on **Underscores (_s)** starter theme for a portfolio website. The codebase follows WordPress coding standards with a modern Sass-based workflow.

## Architecture & Key Patterns

### Theme Structure
- **Main PHP files**: Standard WordPress template hierarchy (`index.php`, `single.php`, `page.php`, `archive.php`)
- **Functions**: Core theme setup in `functions.php` with modular includes from `/inc/`
- **Templates**: Reusable parts in `/template-parts/` (content.php, content-page.php, etc.)
- **Styles**: Sass-compiled CSS with modular structure in `/sass/`

### Naming Convention
All functions, handles, and text domains use the prefix `toto_portfolio_` (underscore format):
- Functions: `toto_portfolio_setup()`, `toto_portfolio_scripts()`
- Text domain: `'toto-portfolio'` (hyphenated for WordPress standards)
- Script/style handles: `'toto-portfolio-style'`, `'toto-portfolio-navigation'`

### Critical Files & Their Roles
- `functions.php`: Theme setup, asset enqueuing, widget registration
- `inc/template-tags.php`: Custom template functions for post meta, pagination, etc.
- `inc/template-functions.php`: WordPress hooks and filters
- `inc/customizer.php`: WordPress Customizer integration
- `js/navigation.js`: Mobile menu toggle and accessibility features

## Development Workflow

### Build Commands (via package.json)
```bash
npm run watch          # Watch Sass files for changes
npm run compile:css    # Compile Sass to CSS with linting
npm run compile:rtl    # Generate RTL stylesheet
npm run lint:scss      # Lint Sass files
npm run lint:js        # Lint JavaScript files
npm run bundle         # Create distribution zip
```

### PHP Commands (via composer.json)
```bash
composer lint:wpcs     # Check PHP against WordPress Coding Standards
composer lint:php      # Check PHP syntax
composer make-pot      # Generate translation file
```

## Sass Architecture
Follows ITCSS methodology:
- `abstracts/`: Variables, mixins (colors, typography, structure)
- `base/`: Typography, elements, normalize
- `components/`: Navigation, posts, comments, widgets, media
- `layouts/`: Grid-based sidebar layouts (commented out by default)
- `utilities/`: Accessibility, alignments

### Layout System
- Uses CSS Grid for optional sidebar layouts
- Layouts are disabled by default - uncomment imports in `sass/style.scss`
- No sidebar (`.no-sidebar`) styles load automatically

## WordPress Integration

### Theme Features
- Custom logo support (250x250px, flexible)
- Post thumbnails enabled
- HTML5 markup for forms and galleries
- Custom background support
- Navigation menu (`'menu-1'` location)
- Widget area (`'sidebar-1'`)

### Template Tags
Custom functions in `inc/template-tags.php`:
- `toto_portfolio_posted_on()`: Post date with microdata
- `toto_portfolio_posted_by()`: Author byline
- `toto_portfolio_entry_footer()`: Post meta (categories, tags, edit link)

### Asset Loading
Assets are enqueued with `_S_VERSION` constant for cache busting. RTL support is automatic via `wp_style_add_data()`.

## Development Guidelines

### When Adding New Features
1. Follow the `toto_portfolio_` naming convention
2. Use WordPress coding standards (WPCS)
3. Add Sass partials to appropriate folders and import in main files
4. Test responsive navigation functionality
5. Ensure RTL compatibility

### Common Patterns
- Template parts use `get_template_part()` for modularity
- All output is escaped (`esc_html()`, `esc_url()`, etc.)
- Conditional loading: Jetpack integration only loads if plugin active
- Mobile-first responsive approach in Sass

### Key Dependencies
- **WordPress**: 5.4+ tested
- **PHP**: 5.6+ required
- **Node.js**: For Sass compilation and linting
- **Composer**: For PHP linting and WordPress standards

## Quick Start for New Developers
1. Run `composer install && npm install` to set up dependencies
2. Use `npm run watch` during development for live Sass compilation
3. Check `functions.php` for theme capabilities and customization hooks
4. Modify Sass files in `/sass/` - never edit compiled `style.css` directly