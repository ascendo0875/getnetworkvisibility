document.addEventListener('userIsInteracting', function (e) {
    const configs = [
        {
            selector: '[data-compare]',
            config: {
                moveElement: "tbody tr",
                appendClass: "compare",
                maxElementMoved: 3
            }
        }
    ];

    if (configs.length > 0) {
        import('./move-element.core').then(() => {
            configs.map((conf) => {
                $(conf.selector).moveElement(conf.config);
            });
        });
    }
});