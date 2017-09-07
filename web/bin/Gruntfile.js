module.exports = function (grunt) {
    grunt.initConfig({
        concat: {
            options: {
                separator: ';'
            },
            js_main: {
                src: [
                    // vendor scripts
                    '../public/wp-content/plugins/iwitness/assets/js/jquery/jquery-1.11.1.js',
                    '../public/wp-content/plugins/iwitness/assets/js/sass-bootstrap.js',
                    '../public/wp-content/plugins/iwitness/assets/js/jquery-validation-1.12.0/jquery.validate.js',
                    '../public/wp-content/plugins/iwitness/assets/js/jquery-validation-1.12.0/additional-methods.js',
                    '../public/wp-content/plugins/iwitness/assets/js/jquery/jquery.metadata.js',
                    '../public/wp-content/plugins/iwitness/assets/js/jquery/jquery.blockUI.js',
                    '../public/wp-content/plugins/iwitness/assets/js/jquery-loadTemplate/jquery.loadTemplate-1.4.4.js',
                    '../public/wp-content/plugins/iwitness/assets/js/infinite-scroll/jquery.infinitescroll.js',
                    '../public/wp-content/plugins/iwitness/assets/js/jquery-ui.js',
                    '../public/wp-content/plugins/iwitness/assets/js/jquery.form/jquery.form.min.js',
                    '../public/wp-content/plugins/iwitness/assets/js/plupload-2.1.2/plupload.full.min.js',
                    '../public/wp-content/plugins/iwitness/assets/js/select2/select2.min.js',
                    '../public/wp-content/plugins/iwitness/assets/js/jwplayer/jwplayer.js',
                    '../public/wp-content/plugins/iwitness/assets/js/jquery.bootgrid/jquery.bootgrid.js',
                    '../public/wp-content/plugins/iwitness/assets/js/jquery.creditCardValidator.js',

                    // iwitness scripts
                    '../public/wp-content/plugins/iwitness/assets/js/iwitness/jquery.registry.js',
                    '../public/wp-content/plugins/iwitness/assets/js/iwitness/jquery.iwitness.js',
                    '../public/wp-content/plugins/iwitness/assets/js/iwitness/jquery.validation.ext.js',
                    '../public/wp-content/plugins/iwitness/assets/js/iwitness/common.js'
                ],
                dest: '../public/wp-content/plugins/iwitness/assets/js/main.js'
            }
        },
        compass: {
            dist: {
                options: {
                    sassDir: '../public/wp-content/themes/iwitness/css/scss',
                    cssDir: '../public/wp-content/themes/iwitness/css/compiled',
                    config: '../public/wp-content/themes/iwitness/css/config.rb',
                    environment: 'production'
                }
            }
        },
        uglify: {
            options: {
                mangle: true
            },
            main: {
                files: {
                    '../public/wp-content/plugins/iwitness/assets/js/main.js': '../public/wp-content/plugins/iwitness/assets/js/main.js'
                }
            }
        }
    });

    // Plugin loading
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // Task definition
    grunt.registerTask('dev', ['concat', 'compass']);
    grunt.registerTask('default', ['concat', 'compass', 'uglify']);
};