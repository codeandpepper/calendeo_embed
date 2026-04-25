# WordPress.org Plugin Assets

This directory contains assets for the WordPress.org plugin submission by Calendeo.

## Current Status

- ✅ banner-1544x500.svg — Placeholder (convert to PNG for production)
- ✅ icon-256x256.svg — Placeholder (convert to PNG for production)
- ✅ screenshot-1.svg — Placeholder (convert to PNG for production)

## Required Conversions

Before final submission to WordPress.org, convert the SVG files to PNG:

### Banner
- File: `banner-1544x500.svg`
- Dimensions: 1544×500 pixels
- Format: PNG recommended (or JPG)
- Recommended tool: Inkscape, ImageMagick, or online converter

### Icon
- File: `icon-256x256.svg`
- Dimensions: 256×256 pixels
- Format: PNG (can also be JPG or SVG)
- Recommended tool: Same as banner

### Screenshots
- File: `screenshot-1.svg` (and more as needed)
- Dimensions: 880×660 pixels (4:3 aspect ratio)
- Create additional screenshots if needed: screenshot-2.svg, screenshot-3.svg, etc.
- Maximum 4 screenshots per plugin

## Conversion Commands

### Using ImageMagick:
```bash
# Banner
convert -density 150 banner-1544x500.svg -background white -alpha off banner-1544x500.png

# Icon
convert -density 150 icon-256x256.svg -background white -alpha off icon-256x256.png

# Screenshots
convert -density 150 screenshot-1.svg -background white -alpha off screenshot-1.png
```

### Using Inkscape (CLI):
```bash
# Banner
inkscape --export-type=png --export-filename=banner-1544x500.png banner-1544x500.svg

# Icon
inkscape --export-type=png --export-filename=icon-256x256.png icon-256x256.svg

# Screenshot
inkscape --export-type=png --export-filename=screenshot-1.png screenshot-1.svg
```

## Recommended Improvements

1. **Banner** — Add plugin name, icon, or feature highlights visually
2. **Icon** — Create a more distinctive icon (calendar-themed)
3. **Screenshots** — Create real screenshots showing actual plugin functionality:
   - Settings page in use
   - Shortcode editor example
   - Gutenberg block editor
   - Frontend calendar rendering
   - Mobile responsiveness

## Notes

- All images must be .png, .jpg/.jpeg, or .gif format (SVG only acceptable for icon in some cases)
- Banner should have minimal text, be visually appealing
- Icon should be recognizable at small sizes (64×64, 32×32)
- Screenshots should highlight key features and be clear/readable
- WordPress.org prefers PNG for best compatibility
