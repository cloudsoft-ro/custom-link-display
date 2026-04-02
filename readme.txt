=== URL Conditional Content ===
Contributors: constantinonu
Tags: html injector, url parameters, tracking code, header footer, conditional content
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display custom HTML snippets conditionally based on specific URLs and query parameters.

== Description ==

**URL Conditional Content** is a powerful yet simple tool for WordPress site owners who need to display specific HTML snippets only on certain pages based on their URL structure.

Whether you need to add a specific tracking pixel to a thank-you page with query params, show a custom banner for users from a specific city (via URL param), or inject scripts for specific campaigns, this plugin makes it easy.

= Features =
*   **Target specific URLs**: Match exact URLs, paths containing specific strings, or use powerful **RegEx Patterns**.
*   **Query Parameter Support**: Easily target dynamic URLs like `example.com/page?oras=Zalau`.
*   **Flexible Injection Points**: Choose to inject your HTML in the Header, Footer, before Content, after Content, or via **Shortcodes**.
*   **Drag & Drop Reordering**: Reorder rules to control matching priority with a modern, visual interface.
*   **Shortcode System**: Use `[ucc_content id="..."]` to manually place your content anywhere.
*   **Premium Admin UI**: A beautiful, clean interface powered by the latest WordPress standards.
*   **Lightweight & Fast**: No bloat, optimized for maximum performance.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the **URL Content** menu in the admin dashboard to start creating rules.

== Screenshots ==

1. The main dashboard showing the rule manager.
2. Adding a new rule with custom HTML.

== Frequently Asked Questions ==

= Can it match query parameters? =
Yes! Just paste the full URL or the part of the URL containing the parameters into the Rule's URL field and set the Match Type to "Contains".

= Does it support Regex? =
Yes! We support Exact Match, "Contains" logic, and **Full Perl-Compatible Regular Expressions (PCRE)**.

== Changelog ==

= 1.0.0 =
* Initial release as URL Conditional Content.
