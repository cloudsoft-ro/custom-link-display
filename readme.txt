=== Custom Link Display ===
Contributors: constantinonu
Tags: html injector, url parameters, tracking code, header footer, conditional content
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 1.4.1
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

== Screenshots ==

1. The main rule manager dashboard showing multiple conditional rules with Custom HTML mode active.
2. The Link Configurator mode — a visual no-code interface for building SEO-friendly anchor links.

== Installation ==

= Option 1: WordPress Dashboard =
1. Go to **Plugins > Add New** in your WordPress admin dashboard.
2. Click **Upload Plugin** at the top of the screen.
3. Choose the `custom-link-display.zip` file and click **Install Now**.
4. Click **Activate Plugin** once the installation is complete.

= Option 2: Manual FTP Upload =
1. Download and extract the `custom-link-display.zip` archive.
2. Upload the unzipped `custom-link-display` folder to your website's `/wp-content/plugins/` directory.
3. Log into your WordPress dashboard, navigate to the **Plugins** screen, and click **Activate** under "Custom Link Display".

== Usage Guide ==

Once activated, you will find a new menu item called **URL Content** in your WordPress admin sidebar. 

= Creating a New Rule =
1. Click the **"Add New Rule"** button. This will append a new configuration block.
2. Toggle the **Status** to activate the rule.
3. Fill in the **Target URL / Path**. You can use a full URL or just a local path like `/contact-us/`.
4. Choose the **Match Type** (Exact Match, Contains, Regex Match).
5. Select a **Placement** (Header, Footer, Before Content, After Content, or Shortcode Only).
6. Pick an **Expiry Date** if the content is time-sensitive (optional).

= Content Types =
By clicking the **Edit Content** button (the pencil icon) in the Actions column, you can define exactly what gets injected. You can toggle between two modes using the radio buttons above the text area:
*   **Custom HTML:** Provides a raw text area where you can inject fully formatted `<script>`, `<style>`, `<div>`, or pixel codes perfectly tailored to this condition.
*   **Link Configurator:** Gives you visual inputs for **Anchor Text, URL, Title, Target, and Rel arguments**. The plugin will automatically compile a clean, SEO-friendly HTML link and output it.

= Shortcode Integration =
Every rule automatically generates a unique tracking shortcode. 
1. To manually output the content with page builders, set the rule's placement to **Shortcode Only**.
2. Click the shortcode string in the dashboard (e.g. `[cld_content id="cld_12345"]`) — it will auto-copy to your clipboard.
3. Paste the shortcode anywhere on your site.

== Frequently Asked Questions ==

= Can it match query parameters? =
Yes! Just paste the full URL or the part of the URL containing the parameters into the Rule's URL field and set the Match Type to "Contains".

= Does it support Regex? =
Yes! We support Exact Match, "Contains" logic, and **Full Perl-Compatible Regular Expressions (PCRE)**.

== Changelog ==

= 1.4.1 =
* Added dashboard screenshots to documentation and readme.

= 1.4.0 =
* Feature: Consolidated the Custom HTML and Link configuration interfaces into a mutually exclusive "Content Type" selector, simplifying rule creation.

= 1.2.0 =
* Major Refactor: Renamed all internal namespaces, constants, and classes to CLD (Custom Link Display) for better consistency and conflict prevention.
* Standardized text domains for full translation support.
* Modernized the Admin UI styles with refined design tokens.
* Added support for `[cld_content]` shortcode (retaining `[ucc_content]` for backward compatibility).

= 1.1.0 =
* Renamed plugin to Custom Link Display.
* Added Regex matching support.
* Added [ucc_content] shortcode system.
* Added Drag & Drop rule reordering for priority control.
* Fixed fatal error on activation.
* Added one-click copy to clipboard for shortcodes.
* Enhanced admin UI and updated plugin headers.

= 1.0.0 =
* Initial release.
