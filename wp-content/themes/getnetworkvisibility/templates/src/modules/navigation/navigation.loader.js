document.addEventListener('DOMContentLoaded', function () {
    const configs = [
        {
            selector: '.navigation > ul',
            config: {
                elementAction: 'li.menu-item-has-children:not(.not-clickable) > a',
                submenu: '.sub-menu',
            }
        },
        {
            selector: '.global-mobile-nav > div > ul',
            config: {
                elementAction: 'li.menu-item-has-children:not(.not-clickable) > a',
                submenu: '.sub-menu',
                toggleMenu: '.mobile-nav a, .global-mobile-nav .x, .mobile-overlayer',
                mobileNav: '.alert-bar, .site-header',
                globalMobileNav: '.global-mobile-nav',
            },
        },
        {
            selector: '.sitemap > ul',
            config: {
                elementAction: 'li.menu-item-has-children:not(.not-clickable) > a',
                submenu: '.sub-menu',
                bodyCssClass: false,
                onlyMobile: true,
            },
        },
    ];

    if (configs.length > 0) {
        import(/* webpackChunkName: "fp-navigation" */ './navigation.core').then(() => {
            configs.map((conf) => {
                $(conf.selector).menuNavigation(conf.config);
            });
        });
    }
});