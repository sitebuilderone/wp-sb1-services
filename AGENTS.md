# AGENTS.md

This file provides guidance to Codex (Codex.ai/code) when working with code in this repository.

## Plugin Overview

`wp-sb1-services` is a standalone WordPress plugin. It has **no external dependencies** — no ACF, no Composer packages, no npm build step. All files are plain PHP, CSS, and HTML.

## Architecture

All WordPress hooks are registered in `wp-sb1-services.php`. Each concern lives in its own stateless class under `includes/`, wired up via `add_action` calls at the bottom of the main file.

| File | Class | Responsibility |
|---|---|---|
| `includes/class-cpt.php` | `SB1_Services_CPT` | Registers the `service` CPT |
| `includes/class-taxonomy.php` | `SB1_Services_Taxonomy` | Registers the `service_tag` flat taxonomy |
| `includes/class-meta-boxes.php` | `SB1_Services_Meta_Boxes` | Admin meta box render + save + style enqueue |
| `includes/class-rest-fields.php` | `SB1_Services_Rest_Fields` | Registers meta keys for REST API exposure |
| `includes/class-shortcode.php` | `SB1_Services_Shortcode` | `[sb1_services]` shortcode |
| `templates/services-grid.php` | — | Default shortcode HTML output |
| `assets/css/admin.css` | — | Meta box styles (loaded only on `service` edit screens) |

## Key Conventions

- **Constants:** `SB1_SERVICES_DIR` (absolute path, trailing slash) and `SB1_SERVICES_URL` are defined in the main file and used throughout.
- **Meta keys:** All three custom fields are prefixed `_sb1_` and treated as protected (leading underscore hides them from the default Custom Fields UI). Keys: `_sb1_short_description`, `_sb1_icon`, `_sb1_cta_url`.
- **Hook registration:** All `add_action` / `add_shortcode` calls are in `wp-sb1-services.php`. Classes contain no self-registering constructors.
- **Template override:** Themes can override the shortcode template by placing a file at `{theme}/sb1-services/services-grid.php`. The fallback lookup is in `SB1_Services_Shortcode::locate_template()`.

## Shortcode Reference

```
[sb1_services count="-1" columns="3" tag="" orderby="menu_order" order="ASC"]
```

- `tag` filters by `service_tag` slug
- `columns` controls the CSS class `sb1-services-columns-{n}` (layout is left to theme CSS)

## REST API

Services are exposed at `/wp-json/wp/v2/services`. The three meta fields appear in the `meta` object of each response because they are registered via `register_post_meta` with `show_in_rest: true` in `class-rest-fields.php`.

## Versioning

Update `SB1_SERVICES_VERSION` in `wp-sb1-services.php` when making releases. This value is used as the cache-buster for `admin.css`.
