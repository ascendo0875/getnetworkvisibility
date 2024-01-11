var urlManagerGlobal;

function UrlManager(opts) {

    var defaults = {
        selector: ".no-reload",
    }

    opts = $.extend(defaults, opts);
    this.selector = opts.selector;
    urlManager = this;
    preload = false;
    scrollTo = false;
    isPagination = false;
    disableScrollAfterSubmitForm = false;
    isScrolled = false;

    this.trDataHref = function () {
        $('[data-href]').click(function () {
            if ($(this).data('href')) {
                window.location.href = $(this).data('href');
            }
        });
    }

    this.rebindJSEvents = function () {
        if (this.scrollTo && !this.isScrolled) {
            $('html, body').animate({scrollTop: ($('.no-reload-container:visible').offset().top - 100)}, 500);
            this.isScrolled = true;
        }

    }

    this.disabledButton = function () {
        $(this.selector).find("[type=submit]").attr('disabled', true);
    }

    this.enabledButton = function () {
        $(this.selector).find("[type=submit]").removeAttr('disabled');
    }

    this.showPreloader = function () {
        if (this.preload) {
            this.preload.toggleClass('loading');
        }
    }

    this.hidePreloader = function () {
        if (this.preload) {
            // this.preload.map($element => $($element).toggleClass('visible'));
            this.preload.toggleClass('loading');
        }
    }

    this.changePage = function () {
        var self = this;
        this.isPagination = ($('.pagination' + this.selector).length > 0);

        $('a' + this.selector + ', .pagination' + this.selector + ' a').unbind('click').on('click', function (event) {
            event.preventDefault();

            var url = $(this).attr('href');
            self.rebindJSEvents();
            self.dispatchUrlManagerIndex(event);
            urlManager.loadPage(url);
        });
    }

    this.submitLoadPage = function (params = [], event = false) {
        let $search = window.location.search;

        let $searchParams = new URLSearchParams($search);
        let $newSearchParams = new URLSearchParams('');

        if ($searchParams.has('tab')) {
            $newSearchParams.set('tab', $searchParams.get('tab'));
        }

        if (typeof params === 'object') {
            params.map((param) => {
                $newSearchParams.set(param.name, param.value);
            })

            $search = `?${$newSearchParams.toString()}`;
        }

        let url = `${window.location.protocol}//${window.location.host}${window.location.pathname}${$search}`;

        if (url.search('/page/')) {
            var urlSplit = url.split('/');
            var newUrl = Array();
            for (let index = 0; index < urlSplit.length; index++) {
                if (!urlSplit.hasOwnProperty(index) || urlSplit[index] !== 'page') {
                    newUrl.push(urlSplit[index]);
                    continue;
                }

                index++;
            }

            url = newUrl.join('/');
        }

        if(event !== false) {
            this.dispatchUrlManagerIndex(event);
        }

        this.loadPage(url, true);
    }

    this.loadPage = function (url, isSearch = false) {
        var self = this;

        self.dispatchNoReloadPageContentUpdatedToggleActiveClass();
        self.disabledButton();

        this.showPreloader();

        $.get(url, function (data) {
            var parsed = $('<div/>').append(data);

            self.hidePreloader();
            if (parsed.find('.tab.active').length > 0 && parsed.find('.tab-content .product-filter').length > 0) {
                let $blockId = parsed.find('.tab.active a').attr('fp-tabs-trigger');

                if ($(`.tab-content[fp-tabs-id=${$blockId}]`)) {
                    $('.no-reload-container').html(parsed.find(`.tab-content[fp-tabs-id=${$blockId}] .no-reload-container`).html());
                    if (self.isPagination === true) {
                        $('.pagination' + self.selector + '').html(parsed.find(`.tab-content[fp-tabs-id=${$blockId}] .pagination${self.selector}`).html());
                        self.changePage();
                    }
                }
            } else {
                $('.no-reload-container').html(parsed.find(".no-reload-container").html());
                if (self.isPagination === true) {
                    $('.pagination' + self.selector + '').html(parsed.find('.pagination' + self.selector + '').html());
                    self.changePage();
                }
            }

            var title = parsed.find('title').text();
            document.title = title;
            window.history.pushState({"html": parsed.find(".page-wrap").html(), "pageTitle": title}, "", this.url);


            setTimeout(function () {
                if ((!isSearch) || (isSearch && !self.disableScrollAfterSubmitForm)) {
                    self.rebindJSEvents();
                }

                self.enabledButton();
                self.checkIsEnableLoading();
                self.trDataHref();
                self.isScrolled = false;

            }, 1000);
        });
    }

    this.dispatchNoReloadPageContentUpdated = function () {
        const event = new Event('noReloadPageContentUpdated');
        document.dispatchEvent(event);
    }

    this.dispatchUrlManagerIndex = function ({currentTarget: $element, type: $eventType}) {
        const event = new Event('urlManagerIndex');
        event.urlManagerElement = $element;
        event.isSubmitForm = ($eventType === 'submit');

        document.dispatchEvent(event);
    }

    this.dispatchNoReloadPageContentUpdatedToggleActiveClass = function () {
        const event = new Event('noReloadPageContentUpdatedToggleActiveClass');
        document.dispatchEvent(event);
    }

    this.checkIsEnableLoading = function () {
        this.preload = false;

        if ($(this.selector) && $(this.selector).length > 0) {
            let $noReload = $(this.selector);
            for (let index in $noReload) {
                if ($noReload.hasOwnProperty(index) && $($noReload[index]).data('preload-container')) {
                    this.preload = $(".load-more-container");
                    break;
                }
            }
        }
    }

    this.init = function () {
        var oself = this;
        oself.disableScrollAfterSubmitForm = ($(this.selector).data('disable-scroll-after-submit-form') !== undefined && $(this.selector).data('disable-scroll-after-submit-form') === true);

        if ($(this.selector).hasClass('scrollto')) {
            oself.scrollTo = $(this);
        } else {
            oself.scrollTo = false;
        }

        this.checkIsEnableLoading();
        this.changePage();
        this.trDataHref();

        $(this.selector).submit(function (event) {
            event.preventDefault();

            var url = window.location.href.split('#');
            url = url[0].split('?');

            urlManager.submitLoadPage($(this).serializeArray(), event);
            return false;
        });

        window.onpopstate = function (e) {
            if (e.state) {
                $(".page-wrap").html(e.state.html);
                document.title = e.state.pageTitle;
                oself.rebindJSEvents();
            }
        };

        this.dispatchNoReloadPageContentUpdated();
    }

    this.init();


}

document.addEventListener('DOMContentLoaded', function () {

    window.urlManagerGlobal = new UrlManager();

}, false);
