document.addEventListener('userIsInteracting', function (e) {

    if($('.anchors ul li a').length){
        import(/* webpackChunkName: "anchors-nav" */'./anchors-nav.core').then(
            (module) => module.run()
        );
    }

});