# WordPress.org Plugin Submission Checklist

## ✅ Completed

### Required Files
- [x] **README.txt** — Full WordPress.org format with description, installation, FAQ, changelog
- [x] **LICENSE.txt** — GPLv2 full license text
- [x] **Plugin header** — All required fields in calendeo-embed.php

### Security & Code Quality
- [x] **Capability checks** — Added `current_user_can('manage_options')` in settings page
- [x] **Input sanitization** — Using `esc_url_raw`, `sanitize_text_field`, `absint`
- [x] **Output escaping** — Using `esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`
- [x] **Proper nonce usage** — `settings_fields()` handles CSRF protection

### Modern WordPress Standards
- [x] **block.json** — Modern block definition format
- [x] **render.php** — Server-side rendering callback
- [x] **Gutenberg support** — Full block editor integration
- [x] **Admin page** — Settings page for configuration
- [x] **PHP 7.4+ compatibility** — No PHP 8.0+ specific features (works with PHP 7.4.33+)

### Internationalization (i18n)
- [x] **Text Domain** — `calendeo-embed` properly set
- [x] **Translation files** — calendeo-embed.pot template
- [x] **Polish translation** — calendeo-embed-pl_PL.po included
- [x] **load_textdomain()** — Proper i18n loading

### Assets & Documentation
- [x] **.wordpress-org folder** — Created with assets
- [x] **Plugin icon** — icon-256x256.svg (placeholder)
- [x] **Banner** — banner-1544x500.svg (placeholder)
- [x] **Screenshot** — screenshot-1.svg (placeholder)
- [x] **CONTRIBUTING.md** — Contributing guidelines
- [x] **.gitignore** — Proper git ignore rules

## ⚠️ Next Steps (Before Submission)

### Critical - Must Complete
1. **Convert SVG to PNG**
   - Convert banner-1544x500.svg → banner-1544x500.png
   - Convert icon-256x256.svg → icon-256x256.png
   - Convert screenshot-1.svg → screenshot-1.png
   - Use: ImageMagick, Inkscape, or online converter
   - See: `.wordpress-org/README.md` for commands

2. **Enhance Screenshots**
   - Create real screenshots showing actual functionality
   - 4:3 aspect ratio (880×660 recommended)
   - Examples needed:
     - Settings page in admin
     - Shortcode usage in editor
     - Gutenberg block in action
     - Calendar rendered on frontend

3. **Test on WordPress.org Test Site**
   - Upload plugin to test WordPress installation
   - Test shortcode: `[calendeo slug="test"]`
   - Test Gutenberg block
   - Test settings page
   - Verify i18n works

### Recommended - Improve Quality
1. **Create proper icon design**
   - Calendar-themed icon
   - Distinctive at 128×128 and 256×256
   - Professional appearance

2. **Create attractive banner**
   - Brand colors
   - Clear messaging
   - Professional design

3. **Test translations**
   - Verify Polish translation displays correctly
   - Add more languages if desired

4. **Code review**
   - Run WPCS: `phpcs --standard=WordPress calendeo-embed.php`
   - Check for any warnings/errors
   - Verify no deprecated functions used

5. **Document more thoroughly**
   - Add video tutorial link
   - Add FAQ section to README.txt
   - Document API (if applicable)

## File Structure (Final)

```
calendeo-embed/
├── .wordpress-org/
│   ├── README.md                    ← Conversion guide
│   ├── banner-1544x500.svg         ← Convert to PNG
│   ├── banner-1544x500.png         ← NEEDED
│   ├── icon-256x256.svg            ← Can stay as SVG or PNG
│   ├── icon-256x256.png            ← NEEDED
│   ├── screenshot-1.svg            ← Convert to PNG
│   └── screenshot-1.png            ← NEEDED (+ screenshot-2, 3, 4)
├── languages/
│   ├── calendeo-embed.pot          ✅
│   └── calendeo-embed-pl_PL.po     ✅
├── assets/
│   └── block.js                    ✅
├── .gitignore                      ✅
├── block.json                      ✅
├── CONTRIBUTING.md                 ✅
├── LICENSE.txt                     ✅
├── README.txt                      ✅
├── calendeo-embed.php              ✅ (updated with security checks)
├── render.php                      ✅
└── WORDPRESS-ORG-CHECKLIST.md      ✅
```

## WordPress.org Submission URL

Once ready: https://wordpress.org/plugins/submit/

**Plugin Author:** Calendeo  
**Support Email:** kontakt@calendeo.pl  
**Website:** https://calendeo.pl

## Support

For questions about WordPress.org submission guidelines:
- https://developer.wordpress.org/plugins/
- https://developer.wordpress.org/plugins/wordpress-org/how-your-plugin-gets-in-the-directory/
