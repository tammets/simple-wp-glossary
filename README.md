# Simple WP Glossary

A simplified WordPress plugin for creating and displaying glossary terms. This plugin allows you to create glossary terms as custom post types and insert them into posts or pages with shortcodes. It also provides a hover link feature to display glossary term descriptions in popups.

## Features

- **Custom Post Type**: Glossary terms with a title and description.
- **Shortcodes**:
  - `[glossary_terms]`: Displays a list of all glossary terms.
  - `[glossary_hover id="123"]Your text here[/glossary_hover]`: Adds a hover link for a glossary term with the specified ID.
- **TinyMCE Integration**: Adds a "Glossary" button in the WordPress post editor to easily insert glossary term shortcodes.
- **Hover Popups**: Display glossary term descriptions as popups on hover.
- **AJAX-Powered Dropdown**: Dynamically fetch glossary terms for the TinyMCE dropdown.

## Installation

1. Download or clone this repository into your `wp-content/plugins` directory.
   ```
   git clone https://github.com/yourusername/simple-wp-glossary.git
   ```
2.	Activate the plugin through the **Plugins** menu in WordPress.
3.	Start creating glossary terms under the **Glossary** menu in the WordPress admin panel.

## Usage

### Display All Glossary Terms

Use the [glossary_terms] shortcode in any post or page to display a list of all glossary terms. Example:

`[glossary_terms]`

### Add a Hover Link for a Specific Glossary Term

Use the [glossary_hover] shortcode to add a hover link for a glossary term. Replace 123 with the term ID. Example:

[glossary_hover id="123"]Click here[/glossary_hover]

### Insert Shortcodes via the WordPress Editor

- Click the **Glossary** button in the editor toolbar.
- Select a glossary term from the dropdown.
- The appropriate shortcode will be automatically inserted.

## Development

### Enqueueing Assets

The plugin uses the following assets:
- **CSS**: assets/css/swpgl-style.css for frontend styling.
- **JavaScript**: assets/js/swpgl-script.js for hover popups and interactivity.

### AJAX

An AJAX handler dynamically fetches glossary terms for the TinyMCE dropdown.

### TinyMCE Integration

The plugin integrates with TinyMCE, adding a custom button to the WordPress editor.

### File Structure
```
simple-wp-glossary/
├── assets/
│   ├── css/
│   │   └── swpgl-style.css
│   ├── js/
│       ├── swpgl-script.js
│       └── swpgl-editor.js
├── simple-wp-glossary.php
└── README.md
```
## Roadmap

- Add a Gutenberg block for glossary term insertion.
- Improve popup styling and animation.
- Add support for glossary term categories.
