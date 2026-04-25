<?php
defined('ABSPATH') || exit;

$src = calendeo_embed_resolve_src($attributes['url'] ?? '', $attributes['slug'] ?? '');
if (!$src) {
    return '';
}

$height = absint($attributes['height'] ?? 700);
$width = absint($attributes['width'] ?? 100);

echo wp_kses_post(
    calendeo_embed_iframe_html($src, $height, $width)
);
return;
