/*************************
 *
 *  Alter Path for chunks
 *
 *********************** */


const url = new URL(document.currentScript.src);
const widgetLink = url.href.substring(0, url.href.lastIndexOf('/') - 2);
__webpack_public_path__ = widgetLink;


/*************************
 *
 *  Compatibility
 *
 *********************** */


import '../tools/node_modules/url-polyfill';
import '../tools/node_modules/current-script-polyfill';


/********************************
*
*  Global Externals > SCSS / CSS
*
********************************* */


/********************************
 *
 *  Global Externals > JS
 *
 ********************************* */

import '../tools/node_modules/lazysizes/lazysizes.min';

require('jquery');
//
if (typeof jQuery !== 'undefined') {

    window.$ = window.jQuery = $ = jQuery.noConflict();

}




/*******************************
 *
 *  Project's code - SCSS / CSS
 *
 ******************************** */

import './main/scss/site.scss';

if($('editor-styles-wrapper').length > 0){
    import(/* webpackChunkName: "wp-editor" */'./main/scss/wp-editor.scss');
}


/*******************************
 *
 *  Project's code - JS
 *
 ******************************* */

import { requireAll } from "./main/js/fp.utils";

// Loading Global JS code
requireAll(require.context('./main/js/', true, /\.js$/));

requireAll(require.context('./modules/', true, /(.*)\.loader\.js$/));




/*******************************
 *
 *  CSS Blocks
 *
 ******************************* */


var blocks = [
        {
            name        : 'list',
            selectors   : [
                '.list-module',
                '.other-list-module'
            ]
        },
    ].
    filter((e) =>{
        return e.selectors.filter((selector) => $(selector).length > 0).length > 0;
    }).
    forEach((e) => import(/* webpackChunkName: "[request]" */'./main/scss/blocks/' + e.name + '.scss'))
    ;


