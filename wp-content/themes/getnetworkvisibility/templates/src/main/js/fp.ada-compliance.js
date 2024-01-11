$(document).ready(function(){

    // Work detail slider
    $('.work.slick-slider').find('.slick-slide').each( function ( index, element ) {
        var $slide = $(this);    
        if ( $slide.attr('aria-describedby') != undefined) { // ignore extra/cloned slides
            // $(this).attr('id', $slide.attr('aria-describedby'));
            $('ul.work-detail-nav li a').eq( index ).attr('id', $slide.attr('aria-describedby'));
        }
    });
    // Bad value for attribute 'action'.
    //$('#form-search-perspectives').attr('action', '');
    $('form.js-form-remove-action').attr('action', '');

});




