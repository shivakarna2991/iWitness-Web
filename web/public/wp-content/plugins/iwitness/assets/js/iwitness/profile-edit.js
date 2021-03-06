;
(function ($, plupload) {
    "use strict";

    // Custom our logic for uploader
    $().ready(function () {
        var $profileForm = $('#profile'),
            $console = $('#console'),
            $profilePhoto = $('#profile-photo'),
            userId = $profileForm.data('user-id');

        $.iw.getAccessToken().done(function (result) {
            var tokenResult = $.parseJSON(result),
                uploader = new plupload.Uploader({
                    runtimes: 'html5,flash,silverlight,html4',
                    browse_button: 'select-photo',
                    container: 'upload-container',
                    url: $.iw.getApiUrl() + '/user/' + userId + '/upload',
                    filters: {
                        max_file_size: '10mb',
                        mime_types: [
                            {title: "Image files", extensions: "jpg,gif,png"},
                            {title: "Zip files", extensions: "zip"}
                        ]
                    },
                    multipart: true,
                    multipart_params: {
                        'acl': 'public-read'
                    },
                    headers: {Authorization: "Bearer " + tokenResult.token},
                    // Flash settings
                    flash_swf_url: $.iw.getPluginUrl() + '/assets/js/plupload-2.1.2/Moxie.swf',

                    // Silverlight settings
                    silverlight_xap_url: $.iw.getPluginUrl() + '/assets/js/plupload-2.1.2/Moxie.xap',

                    init: {
                        PostInit: function () {
                            $console.val('');
                        },

                        FilesAdded: function (up, files) {
                            $console.val('');
                            up.start();
                        },

                        UploadProgress: function (up, file) {
                            $console.attr('innerHTML', '<span>' + file.percent + '%</span>');
                        },
                        FileUploaded: function (up, file, info) {
                            if (file.status = plupload.DONE) {
                                $console.val('');
                                var response = JSON.parse(info.response);
                                $profilePhoto.attr('src', response.url + '?' + new Date().getTime());
                            }
                        },
                        Error: function (up, err) {
                            var errorMessage = '';
                            if (err.status == 422) {
                                var response = JSON.parse(err.response);
                                var error = response['validation_messages'];
                                for (var key in error) {
                                    if (error.hasOwnProperty(key)) {
                                        var fieldError = error[key];
                                        for (var messageKey in fieldError) {
                                            if (fieldError.hasOwnProperty(messageKey)) {
                                                if (errorMessage.length > 0) {
                                                    errorMessage += '<br/>';
                                                }
                                                errorMessage += messageKey + ':' + fieldError[messageKey];
                                            }
                                        }
                                    }
                                }
                                $console.attr('innerHTML', "\nError #" + err.code + ": " + errorMessage);
                            } else {
                                $console.attr('innerHTML', "\nError #" + err.code + ": " + err.message);
                            }
                        }
                    }
                });

            // init uploader container
            uploader.init();
        });
    });

})(jQuery, plupload);