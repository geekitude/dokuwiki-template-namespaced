module.exports = function(grunt) {

    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.initConfig({

        // Reference package.json
        pkg: grunt.file.readJSON('package.json'),

        postcss: {
            options: {
                map: false,
                processors: [
                    require('autoprefixer')({
                        overrideBrowserlist: ['last 2 versions']
                    }),
                    require('postcss-rtl')()
                ]
            },
            dist: {
                files: {
                    'css/distrib/namespaced.less': ['css/src/namespaced.less'],
                    'css/distrib/namespaced-theme.less': ['css/src/namespaced-theme.less']
                }
            }
        },
        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: 'css/distrib',
                    src: ['*.less'],
                    dest: 'css',
                    ext: '.min.less'
                }]
            }
        },
        watch: {
            css: {
                files: 'css/src/*.*',
                tasks: ['postcss','cssmin'],
            }
        }
    });

    grunt.registerTask('default', ['watch']);
};