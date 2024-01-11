$(document).ready(function(){

    if($('.play .video-container').length){
        import(/* webpackChunkName: "media-visual" */'./media-visual.core').then(
            (module) => module.run()
        );
    }

});