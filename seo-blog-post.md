---
seo_title: "How to Conditionally Display Content Based on URLs in WordPress"
meta_description: "Learn how to inject custom HTML, scripts, and conditional links based on specific URLs or query parameters in WordPress without coding."
primary_keyword: "conditional content WordPress"
secondary_keywords: "WordPress custom HTML injection, URL parameter content, query parameter WordPress, conditional shortcode, URL matching plugin"
category: "WordPress Plugins / Tutorials"
tags: ["WordPress", "Conditional Content", "Custom HTML", "URL Parameters", "Web Development", "Shortcodes"]
---

# How to Conditionally Display Content in WordPress Based on URL Rules (The Easy Way)

Have you ever needed to display a specific banner *only* when a user clicks an ad campaign link? Or perhaps you wanted to inject a tracking pixel exclusively on a "Thank You" page that contains a unique URL query parameter?

Historically, doing this in WordPress required writing custom PHP logic in your `functions.php` file or relying on clunky page builders. But what if you could manage this with a clean, centralized rule engine?

I’m excited to introduce **Custom Link Display**, a powerful and lightweight WordPress plugin we’ve built entirely to solve this exact problem. In this guide, I’ll show you how to use it to inject conditional content like a pro.

## The Problem: Dynamic Content for Dynamic Users

Standard WordPress pages are static in their layout. If you need to output HTML based on how the user arrived (e.g., `yoursite.com/checkout?campaign=blackfriday`), you usually hit a wall. 

Common use cases include:
*   **Marketing & SEO:** Showing a special discount code banner only to users from a specific ad campaign.
*   **Tracking:** Firing a JavaScript conversion pixel only on very specific, nested, or query-generated URLs.
*   **UX Localization:** Giving localized welcome messages if the URL path matches a region keyword (e.g., `/uk/` vs `/us/`).
*   **Affiliate Links:** Dynamically replacing standard links with affiliate links depending on dynamic URL strings via shortcodes.

## The Solution: Custom Link Display Plugin

**Custom Link Display** steps in to give you absolute control over what gets displayed and exactly *where* and *when* it gets displayed. 

Instead of writing code, you get a beautiful, native WordPress dashboard to set up conditional visibility rules. 

### Core Features

*   🎯 **Smart Target Matching:** Match URLs by an Exact string, use "Contains" to catch query parameters (like `?source=newsletter`), or use full Perl-Compatible Regular Expressions (Regex) for ultimate precision.
*   🛠️ **Mutually Exclusive Content Modes:**
    *   **Custom HTML:** A raw sandbox for you to paste `<script>`, `<style>`, `<div>`, or pixel tags perfectly tailored to the condition.
    *   **Visual Link Configurator:** A no-code visual builder that instantly constructs clean, SEO-friendly HTML anchor links. Perfect for updating call-to-actions dynamically.
*   📍 **Flexible Placements:** Automatically inject your rules straight into the `Header`, `Footer`, `Before Content`, or `After Content`.
*   🧩 **Shortcode Flexibility:** Put your rule on 'Shortcode Only' placement, copy the generated `[cld_content id="..."]` tag, and drop it anywhere in Elementor, Divi, or the Gutenberg block editor. The shortcode will evaluate the URL and only render if it's a match!
*   ⏳ **Auto-Expiry:** Running a weekend promotion? Set an expiry date on your rule, and it will automatically stop displaying when the timeline ends.

---

## How to Set Up Your First Conditional Rule

Getting started is blazing fast. 

1. **Install and Activate:** Download the plugin and upload it to your WordPress dashboard via `Plugins > Add New`.
2. **Access the Dashboard:** Click the new **URL Content** menu item on your admin sidebar.
3. **Create the Rule:** Click the **Add New Rule** button. 
4. **Configure the Match:** Under *Target URL / Path*, enter your conditional string (e.g., `?promo=20`). Change the *Match Type* to **Contains**.
5. **Decide Placement:** Select where you want this to show up. For a global banner, *Before Content* is a great default.
6. **Add the Content:** Click the pencil icon to toggle the content editor. Here, select **Custom HTML** and paste your banner code or tracking pixel.
7. **Save:** Hit **Save All Rules** and you're done!

That’s it. Next time a user visits a URL containing `?promo=20`, your HTML will inject instantly. The next user who visits the identical page *without* the query string will see nothing.

## Conclusion

Customizing your visitor’s experience based on how they browse your website shouldn't require hiring a developer. Whether you're tracking complex funnels, managing dynamic affiliate links, or crafting personalized user experiences, **Custom Link Display** brings enterprise-level routing logic directly to your WordPress dashboard.

👉 **Download Custom Link Display on GitHub** *(or the WP repository)*

Let us know in the comments how you're using conditional content on your own WordPress site!
