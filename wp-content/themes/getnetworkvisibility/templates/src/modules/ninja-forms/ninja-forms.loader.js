$(document).on( 'nfFormReady', function() {

    const classesToMoveOnNFField        = ['half', 'third', 'full'];

    if($('.nf-form-content').length){
        import(/* webpackChunkName: "ninja-forms" */'./ninja-forms.core').then(
            (module) => module.run({
                classesToMoveOnNFField          : classesToMoveOnNFField
            })
        );
    }

});