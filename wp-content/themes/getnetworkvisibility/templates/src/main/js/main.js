import {calcHeaderHeight, isSmall} from "./fp.breakpoint";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (!isSmall()) {

    $(document).ready(function () {
        triggerUserInteraction();
    });

}


var interactionStarted = null;
$(window).scroll(function () {

    triggerUserInteraction();

});

$(window).on('mousemove', function () {

    triggerUserInteraction();

});

function triggerUserInteraction() {

    if (!window.interactionStarted) {
        window.interactionStarted = true;

        const event = new Event('userIsInteracting');

        document.dispatchEvent(event);

    }

}

/*

document.addEventListener('userIsInteracting', function (e) {
}, false);

 */

////////////////////////////////////////////////////////////////////////////////////////////////////////////////


export const SiteEvents = {
    NewElementsAddedToThePage: 'NewElementsAddedToThePage'
}

document.addEventListener('userIsInteracting', function (e) {

    $('.back-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 800);

        return false;
    });

    if ($('.js-basic-single').length) {
        $('.js-basic-single').select2({
            minimumResultsForSearch: Infinity
        });
    }

    $('a').click(function () {
        var href = $(this).attr('href');
        if (href.indexOf('#') == 0 && href != '#') {
            var obj = null;
            if ($(href).length > 0) {
                obj = $(href);
            }
            if ($('[name="' + href.substring(1) + '"]').length > 0) {
                obj = $('[name="' + href.substring(1) + '"]');
            }

            if (!obj && $('#' + href.substring(1)).length > 0) {
                obj = $('#' + href.substring(1));
            }

            if (obj) {
                if ($('.mobile-nav > a').hasClass('open')) {
                    $('.mobile-nav > a').click();
                }

                $('html, body').animate({scrollTop: $(obj).offset().top - calcHeaderHeight()}, 500);
                return false;
            }

        }
    });

    $('.values-list > .values-item').on({
        mouseenter: function ($event) {
            //stuff to do on mouse enter
            $event.preventDefault();
            const $element = $($event.target.closest('.values-item'));
            const $elementExpend = $element.children('.expend');
            const $list = [];

            $element.closest('.values-list').find('.values-item .expend').each(function () {
                $list.push($(this));
            });

            $($list).not($elementExpend).stop().slideUp().removeClass('in');
            $elementExpend.slideDown().addClass('in');
        },
        mouseleave: function ($event) {
            //stuff to do on mouse leave
            $event.preventDefault();
            const $element = $($event.target.closest('.values-item'));
            $element.children('.expend').slideUp().removeClass('in');
        }
    });

    $(document).on('click', '.read-more[data-role=read-more] a.more[aria-controls]', function ($event) {
        $event.preventDefault();
        const $element = $($event.target);
        const $parent = $element.closest("[data-role=read-more]");

        if ($element.hasClass('read-more')) {
            $parent.find('.read-more-content').slideDown();
            $element.addClass('hidden');
            $parent.find('.read-less').removeClass('hidden');
        } else {
            $parent.find('.read-more-content').slideUp();
            $element.addClass('hidden');
            $parent.find('.read-more').removeClass('hidden');
        }
    });

}, false);

//add simple support for background images:
document.addEventListener('lazybeforeunveil', function (e) {
    var bg = e.target.getAttribute('data-bg');
    if (bg) {
        e.target.style.backgroundImage = 'url(' + bg + ')';
    }
});

// Search
$('.site-header .search a').on('click', function () {
    let customEvent = new Event('fp.mainSearch.open');

    document.dispatchEvent(customEvent);

    $('body').toggleClass('search-open');
    $(this).parents('.search').toggleClass('open');
    $(this).next('form').find('input[name="s"]').focus();

    return false;
});

// Close Search on MobileMenu open
document.addEventListener('fp.mobileMenu.open', function (e) {
    let mainSearch = $('.site-header .search');

    if (mainSearch.hasClass('open')) {
        mainSearch.find('a').trigger('click');
        mainSearch.find('input[name="s"]').blur();
    }
});

$(document).on('click', '[data-show-more]', function ($event) {
    const $jQueryElement = $($event.target);
    const $controller = $jQueryElement.data('show-more');
    const $jQueryController = $($controller);

    if ($jQueryController.length > 0) {
        $jQueryController.find('.is-style-topic').slideToggle();

        if ($jQueryController.hasClass('show')) {
            $jQueryController.removeClass('show');
            $jQueryElement.html('Show more');
        } else {
            $jQueryController.addClass('show');
            $jQueryElement.html('Show less');
        }
    }
});

document.addEventListener('scrollToDOMElement', function (e) {
    let hdr = parseInt($('header.site-header').outerHeight()),
        adminHdr = ($('#wpadminbar').length > 0) ? parseInt($('#wpadminbar').outerHeight()) : 0,
        blockNavFixed = ($('.anchors').length > 0) ? parseInt($('.anchors').outerHeight()) : 0;

    $('html, body').animate({scrollTop: ($(e.detail).offset().top - (hdr + adminHdr + blockNavFixed))}, 500)
}, false);


jQuery(document).ready(function( $ ){

    setShareLinks();

    function socialWindow(url) {
        var left = (screen.width - 570) / 2;
        var top = (screen.height - 570) / 2;
        var params = "menubar=no,toolbar=no,status=no,width=570,height=570,top=" + top + ",left=" + left;
// Setting 'params' to an empty string will launch
// content in a new tab or window rather than a pop-up.
// params = "";
        window.open(url,"NewWindow",params);
    }

    function setShareLinks() {
        var pageUrl = encodeURIComponent(document.URL);
        var tweet = encodeURIComponent($("meta[property='og:description']").attr("content"));

        $(".social-share.facebook").on("click", function() {
            let url = "https://www.facebook.com/sharer.php?u=" + pageUrl;
            socialWindow(url);

            return false;
        });

        $(".social-share.twitter").on("click", function() {
            let url = "https://twitter.com/intent/tweet?url=" + pageUrl + "&text=" + tweet;
            socialWindow(url);

            return false;
        });

        $(".social-share.linkedin").on("click", function() {
            let url = "https://www.linkedin.com/shareArticle?mini=true&url=" + pageUrl;
            socialWindow(url);

            return false;
        })
    }
});