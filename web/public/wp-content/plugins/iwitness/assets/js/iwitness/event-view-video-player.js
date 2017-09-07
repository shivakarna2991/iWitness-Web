;
(function ($) {
    "use strict";

    $(document).ready(function () {
        var $eventPage =  $('#events'),
            eventWidth = $eventPage.data('width'),
            eventHeight = $eventPage.data('height'),
            imageUrl = $eventPage.data('image-url'),
            videoUrl = $eventPage.data('video-url');
        
        jwplayer('mediaplayer').setup({
            id: 'vplayer',
            width: eventWidth,
            height: eventHeight,
            aspectratio: "16:9",
            file: videoUrl,
            image: imageUrl,
            skin: $.iw.getPluginUrl() + '/assets/js/jwplayer/skins/glow/glow.zip',
            bufferlength: 0, /* See http://jira.apps.webonyx.com/browse/PERPII-296 */
            startparam: "ec_seek",
            modes: [
                { type: 'flash', src: $.iw.getPluginUrl() + '/assets/js/jwplayer/player.swf' },
                { type: 'html5' },
                { type: 'download' }
            ]
        });
    });
})(jQuery);
