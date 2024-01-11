import {isSmall} from "../../main/js/fp.breakpoint";

export const run = (definitions) => {

    import (/* webpackChunkName: "slick-sliders" */ '../../../tools/node_modules/slick-carousel/slick/slick.scss');
    import (/* webpackChunkName: "slick-sliders" */'../../../tools/node_modules/slick-carousel/slick/slick-theme.scss');
    import (/* webpackChunkName: "slick-sliders" */'../../../tools/node_modules/slick-carousel')
        .then(_ => new FpSlickSlidersCore(definitions));
    import(/* webpackChunkName: "slick-sliders" */ './slick-sliders.scss');

}

function FpSlickSlidersCore(configs) {

    this.sliders = [];
    this.configs = configs;

    this.initializeSlider = function(config){
        var self = this;

        if($(config.selector).length > 0){

            $(config.selector).on('init', function () {
                $(config.configs.exclude).each(function ($key, $element) {
                    const $jQueryElement = $($($element).closest('[data-slick-index]'));
                    $jQueryElement.addClass('hidden');
                });
            });
            $(config.selector).on('reInit', function () {
                $(config.configs.exclude).each(function ($key, $element) {
                    const $jQueryElement = $($($element).closest('[data-slick-index]'));
                    $jQueryElement.addClass('hidden');
                });
            });
            
            $(config.selector).each(function(index, element){
                if(!$(element).hasClass('slick-initialized') && $(element).is(':visible')){
                    $(element).slick(config.configs);
                }else{
                    $(element)[0].slick.refresh();
                }
            });
        }
    }

    this.initializeAll = function(){
        for(var i=0; i < this.configs.length; i++){
            this.initializeSlider(this.configs[i]);
        }
    }

    this.bind = function () {
        var self = this;

        $(window).on('resize', function() {
            self.initializeAll();
        });

    }

    this.init = function () {
        this.bind();
        this.initializeAll();

        $('.slider-holder').removeClass('loading');

    }

    this.init();
}