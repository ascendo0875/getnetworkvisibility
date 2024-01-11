import {isSmall} from "../../main/js/fp.breakpoint";

(function ($) {
    const FP_NAVIGATION = 'fp.navigation';

    /**
     *
     * @param $element
     * @param $option
     * @constructor
     */
    function FpNavigation($element, $option) {
        const $this = this;

        $this.element = $element;
        $this.jqueryElement = $($element);
        $this.elementActionList = false;
        $this.topPadding = 0;

        $this.options = $.extend({}, FpNavigation.prototype.DEFAULTS, $option);

        if ($this.options.elementAction) {
            $this.elementActionList = [];
            $($this.element).find($this.options.elementAction).each(($key, $element) => {
                $this.elementActionList.push($($element));
            });
        }

        $this.init();
    }

    /**
     *
     * @type {{submenu: boolean|string, elementOpenCssClass: string, mobileNav: boolean|string, elementAction: boolean|string, bodyCssClass: string|boolean, globalMobileNav: boolean|string, autoClose: boolean, toggleMenu: boolean|string}}
     */
    FpNavigation.prototype.DEFAULTS = {
        'elementOpenCssClass': 'open',
        'elementAction': false,
        'bodyCssClass': 'menu-open',
        'autoClose': true,
        'submenu': false,
        'toggleMenu': false,
        'mobileNav': false,
        'globalMobileNav': false,
        'onlyMobile': false,
    };

    FpNavigation.prototype.init = function () {
        const $this = this;

        $this.setupGlobalMobileNav();
        $this.binds();
        $this.publishEvent('init');
    }

    FpNavigation.prototype.binds = function () {
        const $this = this;

        $(window).resize(function () {
            $this.setupGlobalMobileNav();
        });

        if ($this.elementActionList && $this.elementActionList.length > 0 && ((!$this.options.onlyMobile) || ($this.options.onlyMobile && isSmall()))) {
            $($this.elementActionList).each(($index, $element) => {
                $($element).bind('click', function ($event) {
                    $event.preventDefault();
                    $this.itemClicked($($element).parent());
                });
            });
        }

        if ($this.options.autoClose) {
            $(document).bind('click', function ($event) {
                if ($($event.target).closest($this.element).length < 1) {

                    for (let $element of $this.elementActionList) {
                        if ($($element).parent().hasClass($this.options.elementOpenCssClass)) {
                            $this.close($($element).parent());
                            break;
                        }
                    }

                }
            });
        }

        if ($this.options.toggleMenu) {
            $($this.options.toggleMenu).bind('click', function () {
                if ($(document.body).hasClass($this.options.bodyCssClass)) {
                    $this.removeClassOnBody();
                } else {
                    $this.addClassOnBody();
                }
            });
        }

        $this.publishEvent('binds');
    }

    /**
     *
     * @param $item
     */
    FpNavigation.prototype.itemClicked = function ($item) {
        const $this = this;
        const $jQueryItem = $($item);

        if ($jQueryItem) {
            $this.publishEvent('itemClicked');

            if ($jQueryItem.hasClass($this.options.elementOpenCssClass)) {
                $this.close($item, $jQueryItem);
            } else {
                $this.open($item, $jQueryItem);
            }
        }
    }

    /**
     *
     * @param $item
     * @param $jQueryItem
     */
    FpNavigation.prototype.open = function ($item, $jQueryItem = false) {
        const $this = this;

        if (!$jQueryItem) {
            $jQueryItem = $($item);
        }

        if ($this.elementActionList && $this.elementActionList.length > 1) {
            $($this.elementActionList).not($jQueryItem).stop().each(($index, $element) => {
                if(!$element.parent().is($item)) {
                    $this.close($element.parent());
                }
            });
        }

        if ($this.options.submenu) {
            $jQueryItem.find($this.options.submenu).slideDown('fast');
        }

        $this.addClassOnBody();

        $jQueryItem.addClass($this.options.elementOpenCssClass);
        $this.publishEvent('itemOpen');
    }

    /**
     *
     * @param $item
     * @param $jQueryItem
     */
    FpNavigation.prototype.close = function ($item, $jQueryItem = false) {
        const $this = this;

        if (!$jQueryItem) {
            $jQueryItem = $($item);
        }

        $this.publishEvent('itemClose', $jQueryItem);

        if ($this.options.submenu) {
            $jQueryItem.find($this.options.submenu).slideUp('fast');
        }

        $this.removeClassOnBody();

        $jQueryItem.removeClass($this.options.elementOpenCssClass);
    }

    FpNavigation.prototype.addClassOnBody = function () {
        const $this = this;

        if ($this.options.bodyCssClass) {
            $(document.body).addClass($this.options.bodyCssClass);
        }
    }

    FpNavigation.prototype.removeClassOnBody = function () {
        const $this = this;
        if ($this.options.bodyCssClass) {
            $(document.body).removeClass($this.options.bodyCssClass);
        }
    }

    /**
     *
     * @param {string} $eventName
     * @param {Object} $data
     */
    FpNavigation.prototype.publishEvent = function ($eventName = 'init', $data = {}) {
        const $this = this;
        $($this.element).trigger(`${FP_NAVIGATION}.${$eventName}`, $data);
    }

    FpNavigation.prototype.setupGlobalMobileNav = function () {
        const $this = this;
        if ($this.options.mobileNav) {
            $($this.options.mobileNav).each(function ($index, $element) {
                $this.topPadding += $($element).outerHeight();
            });

            if ($this.options.globalMobileNav) {
                $($this.options.globalMobileNav).css('top', $this.topPadding);
            }
        }
    }

    /**
     *
     * @param $opts
     * @returns {Window.jQuery|*|jQuery|HTMLElement}
     */
    $.fn.menuNavigation = function ($opts) {
        const $this = $(this);

        if (!$this.length) {
            return $this;
        }

        const $typeofOpts = typeof $opts === 'object';
        let $instance = $this.data(FP_NAVIGATION);

        if ($typeofOpts || !$opts) {
            $instance = new FpNavigation($this, $opts);
            $this.data(FP_NAVIGATION, $instance);

            return this;
        }

        if (!$instance) {
            $.error(`Plugin must be initialised before using method: ${$opts}`);
        }

        if (!$typeofOpts && $opts.indexOf('_') === 0) {
            $.error(`Method ${opts} is private!`);
        }

        if ($instance && !($opts in $instance)) {
            $.error(`Method ${$opts} does not exist!`);
        }

        let args = Array.prototype.slice.call(arguments, 1);

        return $instance[$opts](...args);
    }
})(window.jQuery);