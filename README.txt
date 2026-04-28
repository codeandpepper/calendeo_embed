=== Calendeo Embed ===
Contributors: calendeo
Tags: calendar, booking, appointments, scheduling, shortcode, gutenberg
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Embed your Calendeo booking calendar on any page using a shortcode or Gutenberg block. Requires a Calendeo account.

== Description ==

Calendeo Embed is a simple and powerful WordPress plugin that allows you to embed your Calendeo booking calendar directly into any page or post.

**Features:**

- 📅 Embed Calendeo calendars using a shortcode or Gutenberg block
- ⚙️ Configure default calendar height and base URL
- 🎨 Responsive iframe design
- 🌐 Full internationalization (i18n) support
- ♿ Accessibility-friendly
- 🔒 Security-focused (proper sanitization & escaping)

**How to Use:**

**Shortcode:**
```
[calendeo slug="your-calendar-slug"]
```

Or with full URL:
```
[calendeo url="https://calendeo.pl/embed/your-slug"]
```

**Gutenberg Block:**
Search for "Calendeo Calendar" in the block editor and add it. Configure the slug or URL in the sidebar panel.

**Required Parameters:**
- `slug` — Your Calendeo calendar slug (e.g., `my-calendar`)
- `url` — Alternatively, provide a full URL to your Calendeo embed

**Optional Parameters:**
- `height` — Height in pixels (default: 700)
- `width` — Width in percent (default: 100)

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/calendeo-embed/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to Settings → Calendeo Embed to configure your base URL and default height.
4. Use the shortcode `[calendeo slug="your-slug"]` on any page or post, or search for the Calendeo Calendar block in the block editor.

== System Requirements ==

- **WordPress:** 6.0 or higher
- **PHP:** 7.4 or higher (works fine with PHP 7.4.33+, no PHP 8.0+ features used)
- **Modern browser** for Gutenberg block editor support

== Frequently Asked Questions ==

= What is Calendeo? =
Calendeo is a booking and calendar management platform. Visit https://calendeo.pl for more information.

= Do I need a Calendeo account? =
Yes, you need an active Calendeo account and a valid calendar slug to use this plugin.

= How do I get my calendar slug? =
Your Calendeo calendar slug is provided in your Calendeo dashboard. It typically looks like `my-calendar-123` or similar.

= Can I use multiple calendars on the same page? =
Yes, you can add multiple Calendeo shortcodes or blocks, each with a different slug or URL.

= How do I customize the calendar styling? =
The calendar styling is controlled by your Calendeo embed settings. You can customize width and height per shortcode/block.

= Is the plugin translatable? =
Yes, the plugin is fully internationalized. Translations are welcome!

= What if the calendar doesn't load? =
Check that:
1. Your calendar slug is correct
2. The base URL setting is configured properly
3. The calendar is published in your Calendeo account
4. Check browser console for any CORS or loading errors

= Is this plugin secure? =
Yes, we follow WordPress security best practices including proper input sanitization, output escaping, and capability checks.

== Screenshots ==

1. Calendeo Embed settings page
2. Shortcode example in editor
3. Gutenberg block panel configuration
4. Embedded calendar on frontend

== Changelog ==

= 1.0.1 =
* Maintenance release

= 1.0.0 =
* Initial release
* Shortcode support: [calendeo slug="..."]
* Gutenberg block support
* Settings page for base URL and default height
* Full i18n support
* Security hardening (nonce, sanitization, escaping)

== Upgrade Notice ==

= 1.0.1 =
Maintenance release. Recommended update.

= 1.0.0 =
Initial release. No upgrades needed yet.

== License ==

This plugin is licensed under the GPLv2 or later. See LICENSE.txt for more details.
