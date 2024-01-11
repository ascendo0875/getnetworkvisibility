import {SiteEvents, FPMessenger} from "../messenger/fp.messenger";
import {isSmall} from "../../main/js/fp.breakpoint";
// import '../../../tools/node_modules/waypoints/lib/jquery.waypoints.min';
// import {isSmall} from "../../main/js/fp.breakpoint";

export const run = (definitions) => {

    new AnchorsNav();

}

class AnchorsNav extends FPMessenger {

    constructor() {
        super();

        this.init();
        this.bind();
    }

    init() {
        const self = this;
    }

    updateNavigation(activeElement) {
        let navParent = activeElement.closest('li');

        if (!navParent.hasClass('active')) {
            navParent.siblings('li').removeClass('active');
            navParent.addClass('active');
        }

        if($(`[data-anchors-scroll] option[value=${$(activeElement).attr('href')}]`).length > 0) {
            $(`[data-anchors-scroll] option`).attr('selected', false);
            $(`[data-anchors-scroll] option[value=${$(activeElement).attr('href')}]`).attr('selected', true);
        }
    }

    getPreviousNavigation(activeElement) {

        return activeElement.closest('li').prev('li').length ? activeElement.closest('li').prev('li').find('a') : activeElement;
    }

    bind() {
        const self = this;

        $('.anchors ul li a').on('click', function ($event) {
            $event.preventDefault();
            const $element = $($event.target).closest('li');

            if ($element.hasClass('active')) {
                return true;
            }

            self.updateNavigation($(this));
            return true;
            // const $jQueryParentElement = $element.closest('ul');
            // $jQueryParentElement.find('li.active').removeClass('active');
            // $element.addClass('active');
        });

        $(document).on('change', '[data-anchors-scroll]', function ($event) {
            const $element = $event.target;
            const $selector = `.anchors ul li:not(.active) a[href=${$element.value}]`;

            if ($element.value && $($selector).length) {
                $($selector).trigger('click');
            }
        });

        $('.anchors ul li a').each(function (index, element) {

            let navElement = $(this);
            let sectionId = $(this).attr('href');
            let section = $(sectionId);

            if (section.length) {

                    new Waypoint({
                        element: section,
                        offset: '50%',
                        handler: function (direction) {
                            if (direction == 'down')
                                self.updateNavigation(navElement);
                            else
                                self.updateNavigation(self.getPreviousNavigation(navElement));
                        }
                    });

                $('.side-articles, .featured-items.is-slider, .carousel-items.is-slider, .topics-slider').on('init', function () {
                    Waypoint.refreshAll()
                });
                $('.side-articles, .featured-items.is-slider, .carousel-items.is-slider, .topics-slider').on('reInit', function () {
                    Waypoint.refreshAll()
                });
            }

        });
    }
}