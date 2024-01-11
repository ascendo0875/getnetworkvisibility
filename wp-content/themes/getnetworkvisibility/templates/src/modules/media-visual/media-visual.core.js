import {SiteEvents, FPMessenger} from "../messenger/fp.messenger";

export const run = (definitions) => {
    new MediaVisual();
}

class MediaVisual extends FPMessenger {

    constructor() {
        super();

        this.bind();
    }

    stopVideos() {
        $('iframe').each( function (index, element){
            let play = $(this).closest('a');

            if (!play.hasClass('play')) {
                $(this).closest('a').addClass('play');
                $(this).closest('.video-container').removeClass('on');

                let url = $(this).attr('src');

                // Remove the autoplay parameter from YouTube url if any
                if (typeof url !== 'undefined' && url.split('?')[1].includes('autoplay=1&')){
                    url = url.split('?')[0] + '?' + url.split('?')[1].replace('autoplay=1&', '');
                    url = url.replace('?&', '?').replace('&&', '&');
                }

                $(this).attr('src', url);
            }
        });
    }

    bind() {
        let self = this;

        $('a.play').on('click', function (e){
            let iframeContainer = $(this).find('.video-container');
            let videoURL = iframeContainer.data('videourl');

            self.stopVideos();
            $(this).removeClass('play');
            iframeContainer.addClass('on');
            iframeContainer.find('iframe').attr('src', videoURL);

            return false;
        });
    }
}