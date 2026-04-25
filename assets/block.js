(function (blocks, element, blockEditor, components) {
    console.log('[Calendeo] block.js loaded, v2');
    var el = element.createElement;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var RangeControl = components.RangeControl;

    var data = window.calendeoEmbedData || {};
    var baseUrl = data.baseUrl || 'https://calendeo.pl/embed/';
    var defaultHeight = data.defaultHeight || 700;

    blocks.registerBlockType('calendeo/embed', {
        title: 'Calendeo Calendar',
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
                            label: 'Wysokość2 (px)',
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
            return null; // rendered server-side via render_callback
        },
    });

}(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components));
