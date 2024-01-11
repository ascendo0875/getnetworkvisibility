wp.domReady(function () {
    wp.blocks.unregisterBlockStyle('core/button', 'default');
    wp.blocks.unregisterBlockStyle( 'core/button', 'outline' );
    wp.blocks.unregisterBlockStyle('core/button', 'fill');
});

function addAttributes(settings, name) {

    switch (name) {
        case 'core/heading' :
            settings.attributes.headingStyle = {
                type: 'string',
                default: ''
            };
            break;

        default :
    }

    return settings;
}

wp.hooks.addFilter(
    'blocks.registerBlockType',
    'theme/edit-blocks',
    addAttributes
);

//for editor
var el = wp.element.createElement;
var withInspectorControls = wp.compose.createHigherOrderComponent(function (BlockEdit) {
    return function (props) {

        switch (props.name) {
            case 'core/heading':
                let customControls = [];
                customControls.push(el(wp.components.SelectControl, {
                    label: 'Style as',
                    value: props.attributes.headingStyle,
                    options: [
                        {label: 'H1', value: 'heading-1'},
                        {label: 'H2', value: 'heading-2'},
                        {label: 'H3', value: 'heading-3'},
                        {label: 'H4', value: 'heading-4'},
                        {label: 'H5', value: 'heading-5'},
                        {label: 'None', value: ''}
                    ],
                    onChange: function (styleAs) {
                        props.setAttributes({headingStyle: styleAs})
                    }
                }));

                return el(wp.element.Fragment, {},
                    el(BlockEdit, props),
                    el(
                        wp.blockEditor.InspectorControls,
                        {},
                        el(
                            wp.components.PanelBody, {
                                title: 'Custom Settings',
                                initialOpen: true
                            },
                            customControls
                        )
                    )
                );
                break;

            default:
                return el(BlockEdit, props);
        }
    };
}, 'withInspectorControls');

wp.hooks.addFilter(
    'editor.BlockEdit',
    'theme/edit-blocks',
    withInspectorControls
);

//for save
function getSaveElement(element, blockType, attributes) {

    switch (blockType.name) {

        case 'core/heading':
            let props = jQuery.extend({}, element.props);

            if (typeof props.className == 'undefined')
                props.className = '';

            props.className = props.className + (
                typeof attributes.headingStyle != 'undefined' && attributes.headingStyle !== ''
                    ? ' ' + attributes.headingStyle : ''
            );
            props.className = props.className.trim();

            return wp.element.cloneElement(element, props);

            break;

        default:
            return element;
    }
}

wp.hooks.addFilter(
    'blocks.getSaveElement',
    'theme/edit-blocks',
    getSaveElement
);


//for editor
var rowClasses = wp.compose.createHigherOrderComponent(function (BlockListBlock) {

    return function (props) {

        switch (props.name) {
            case 'core/heading':
                if (typeof props.className == 'undefined')
                    props.className = '';

                props.className = props.className + (
                    typeof props.attributes.headingStyle != 'undefined' && props.attributes.headingStyle !== ''
                        ? ' ' + props.attributes.headingStyle : ''
                );
                props.className = props.className.trim();
                break;

            default:

        }

        return el(BlockListBlock, props);
    };
});

wp.hooks.addFilter(
    'editor.BlockListBlock',
    'theme/edit-blocks',
    rowClasses
);
