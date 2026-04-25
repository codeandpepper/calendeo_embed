<?php
/**
 * Plugin Name: Calendeo Embed
 * Description: Embed your Calendeo booking calendar on any page using a shortcode or Gutenberg block. Requires a Calendeo account.
 * Version:     1.0.0
 * Author:      Calendeo
 * Author URI:  https://calendeo.pl
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: calendeo-embed
 * Domain Path: /languages
 * Requires at least: 6.0
 * Tested up to:      6.7
 * Requires PHP:      7.4
 */

defined('ABSPATH') || exit;

define('CALENDEO_EMBED_VERSION', '1.0.0');
define('CALENDEO_EMBED_URL', plugin_dir_url(__FILE__));

register_activation_hook(__FILE__, 'calendeo_embed_activate');
register_deactivation_hook(__FILE__, 'calendeo_embed_deactivate');

function calendeo_embed_activate(): void {
    add_option('calendeo_embed_base_url', 'https://calendeo.pl/embed/');
    add_option('calendeo_embed_default_height', 700);
}

function calendeo_embed_deactivate(): void {
    // intentionally empty — options preserved for re-activation
}

add_action('plugins_loaded', 'calendeo_embed_load_textdomain');

function calendeo_embed_load_textdomain(): void {
    load_plugin_textdomain('calendeo-embed', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

// --- Settings ---

add_action('admin_menu', 'calendeo_embed_admin_menu');
add_action('admin_init', 'calendeo_embed_register_settings');

function calendeo_embed_admin_menu(): void {
    add_options_page(
        'Calendeo Embed',
        'Calendeo Embed',
        'manage_options',
        'calendeo-embed',
        'calendeo_embed_settings_page'
    );
}

function calendeo_embed_register_settings(): void {
    register_setting('calendeo_embed_options', 'calendeo_embed_base_url', [
        'sanitize_callback' => 'esc_url_raw',
        'default'           => 'https://calendeo.pl/embed/',
    ]);
    register_setting('calendeo_embed_options', 'calendeo_embed_default_height', [
        'sanitize_callback' => 'absint',
        'default'           => 700,
    ]);
}

function calendeo_embed_settings_page(): void {
    if (!current_user_can('manage_options')) {
        wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'calendeo-embed'));
    }
    ?>
    <div class="wrap">
        <h1>Calendeo Embed — Ustawienia</h1>
        <form method="post" action="options.php">
            <?php settings_fields('calendeo_embed_options'); ?>
            <table class="form-table">
                <tr>
                    <th><label for="calendeo_base_url">Base URL</label></th>
                    <td>
                        <input type="url" id="calendeo_base_url" name="calendeo_embed_base_url"
                               value="<?php echo esc_attr(get_option('calendeo_embed_base_url', 'https://calendeo.pl/embed/')); ?>"
                               class="regular-text" />
                        <p class="description">np. https://calendeo.pl/embed/</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="calendeo_default_height">Domyślna wysokość (px)</label></th>
                    <td>
                        <input type="number" id="calendeo_default_height" name="calendeo_embed_default_height"
                               value="<?php echo esc_attr(get_option('calendeo_embed_default_height', 700)); ?>"
                               min="200" max="2000" />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// --- Shortcode ---

add_shortcode('calendeo', 'calendeo_embed_shortcode');

function calendeo_embed_shortcode(array $atts): string {
    $atts = shortcode_atts([
        'slug'   => '',
        'url'    => '',
        'height' => get_option('calendeo_embed_default_height', 700),
        'width'  => 100,
    ], $atts, 'calendeo');

    $src = calendeo_embed_resolve_src((string) $atts['url'], (string) $atts['slug']);
    if (!$src) {
        return '<!-- Calendeo: brak slug lub url -->';
    }

    return calendeo_embed_iframe_html($src, absint($atts['height']), absint($atts['width']));
}

// --- Gutenberg block ---

add_action('init', 'calendeo_embed_register_block');
add_action('enqueue_block_editor_assets', 'calendeo_embed_enqueue_editor_assets');

function calendeo_embed_register_block(): void {
    if (!function_exists('register_block_type')) {
        return;
    }

    register_block_type('calendeo/embed', [
        'render_callback' => 'calendeo_embed_block_render',
        'attributes'      => [
            'slug'   => ['type' => 'string', 'default' => ''],
            'url'    => ['type' => 'string', 'default' => ''],
            'height' => ['type' => 'number', 'default' => 700],
            'width'  => ['type' => 'number', 'default' => 100],
        ],
    ]);
}

function calendeo_embed_enqueue_editor_assets(): void {
    $base_url       = get_option('calendeo_embed_base_url', 'https://calendeo.pl/embed/');
    $default_height = (int) get_option('calendeo_embed_default_height', 700);

    wp_register_script(
        'calendeo-embed-block',
        false,
        ['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components'],
        null,
        true
    );
    wp_enqueue_script('calendeo-embed-block');

    wp_add_inline_script('calendeo-embed-block', sprintf(
        'window.calendeoEmbedData = %s;',
        wp_json_encode([
            'baseUrl'       => $base_url,
            'defaultHeight' => $default_height,
            'i18n'          => [
                'slug'        => __('Slug', 'calendeo-embed'),
                'slugHelp'    => __('e.g. calendeo-form-123', 'calendeo-embed'),
                'fullUrl'     => __('Or full URL (overrides slug)', 'calendeo-embed'),
                'width'       => __('Width (%)', 'calendeo-embed'),
                'height'      => __('Height (px)', 'calendeo-embed'),
                'placeholder' => __('Calendeo — enter a slug or URL in the sidebar →', 'calendeo-embed'),
                'panelTitle'  => __('Calendeo', 'calendeo-embed'),
                'blockTitle'  => __('Calendeo Calendar', 'calendeo-embed'),
            ],
        ])
    ), 'before');

    wp_add_inline_script('calendeo-embed-block', calendeo_embed_block_js());
}

function calendeo_embed_block_js(): string {
    return <<<'JS'
(function (blocks, element, blockEditor, components) {
    var el = element.createElement;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var RangeControl = components.RangeControl;

    var data = window.calendeoEmbedData || {};
    var baseUrl = data.baseUrl || 'https://calendeo.pl/embed/';
    var defaultHeight = data.defaultHeight || 700;
    var i18n = data.i18n || {};

    blocks.registerBlockType('calendeo/embed', {
        title: i18n.blockTitle || 'Calendeo Calendar',
        icon: 'calendar-alt',
        category: 'embed',
        attributes: {
            slug:   { type: 'string', default: '' },
            url:    { type: 'string', default: '' },
            height: { type: 'number', default: defaultHeight },
            width:  { type: 'number', default: 100 },
        },

        edit: function (props) {
            var attrs = props.attributes;
            var setAttr = props.setAttributes;
            var src = attrs.url || (attrs.slug ? baseUrl + attrs.slug : '');
            var width = attrs.width || 100;

            var wrapperStyle = {
                width: width + '%',
                margin: '0 auto',
                overflow: 'hidden',
            };

            return [
                el(InspectorControls, { key: 'controls' },
                    el(PanelBody, { title: 'Calendeo', initialOpen: true },
                        el(TextControl, {
                            label: 'Slug',
                            help: 'np. calendeo-form-123',
                            value: attrs.slug,
                            onChange: function (val) { setAttr({ slug: val, url: '' }); },
                        }),
                        el(TextControl, {
                            label: 'Lub pełny URL (nadpisuje slug)',
                            value: attrs.url,
                            onChange: function (val) { setAttr({ url: val, slug: '' }); },
                        }),
                        el(RangeControl, {
                            label: 'Szerokość (%)',
                            value: width,
                            min: 20,
                            max: 100,
                            onChange: function (val) { setAttr({ width: val }); },
                        }),
                        el(RangeControl, {
                            label: 'Wysokość (px)',
                            value: attrs.height,
                            min: 200,
                            max: 1500,
                            onChange: function (val) { setAttr({ height: val }); },
                        })
                    )
                ),
                src
                    ? el('div', { key: 'preview', style: wrapperStyle },
                        el('div', {
                            style: {
                                position: 'relative',
                                height: attrs.height + 'px',
                                border: '2px dashed #007cba',
                                borderRadius: '2px',
                            }
                        },
                            el('iframe', {
                                src: src,
                                width: '100%',
                                height: '100%',
                                style: { border: 'none', display: 'block' },
                                title: 'Calendeo Calendar',
                            }),
                            el('div', {
                                style: {
                                    position: 'absolute',
                                    top: 0, left: 0,
                                    width: '100%', height: '100%',
                                }
                            })
                        )
                      )
                    : el('div', {
                        key: 'placeholder',
                        style: {
                            background: '#f0f0f0',
                            padding: '40px',
                            textAlign: 'center',
                            color: '#666',
                            borderRadius: '4px',
                        }
                      }, 'Calendeo — wpisz slug lub URL w panelu bocznym →')
            ];
        },

        save: function () {
            return null;
        },
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components));
JS;
}

function calendeo_embed_block_render(array $attributes): string {
    $src = calendeo_embed_resolve_src($attributes['url'] ?? '', $attributes['slug'] ?? '');
    if (!$src) {
        return '';
    }
    return calendeo_embed_iframe_html($src, absint($attributes['height'] ?? 700), absint($attributes['width'] ?? 100));
}

// --- Helpers ---

function calendeo_embed_resolve_src(string $url, string $slug): string {
    if ($url) {
        return esc_url($url);
    }
    if ($slug) {
        $base = trailingslashit(get_option('calendeo_embed_base_url', 'https://calendeo.pl/embed/'));
        return esc_url($base . sanitize_text_field($slug));
    }
    return '';
}

function calendeo_embed_iframe_html(string $src, int $height, int $width = 100): string {
    return sprintf(
        '<div class="calendeo-embed-wrapper" style="width:%d%%;margin:0 auto;overflow:hidden;">'
        . '<iframe src="%s" width="100%%" height="%dpx" frameborder="0" '
        . 'style="border:0;display:block;" loading="lazy" '
        . 'title="Calendeo Calendar" allowfullscreen></iframe>'
        . '</div>',
        $width,
        $src,
        $height
    );
}
