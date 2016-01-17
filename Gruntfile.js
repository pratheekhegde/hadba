module.exports = function(grunt) {

  // To show the time taken at the end of a Task
  require('time-grunt')(grunt);

  // for fixing url hasbang issues in development
  var modRewrite  = require('connect-modrewrite');

  //Load wiredeep Plugin to inject bower dependencies.
  grunt.loadNpmTasks('grunt-wiredep');

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-uglify');

  // Load the plugin that generated documentations
  grunt.loadNpmTasks('grunt-ngdocs');

  // Web Server to run along with Grunt
  grunt.loadNpmTasks('grunt-contrib-connect');

  // To clear files and folders
  grunt.loadNpmTasks('grunt-contrib-clean');

  // Load BrowerSync Plugin
  grunt.loadNpmTasks('grunt-browser-sync');

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    //Uglify
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      build: {
        src: 'src/<%= pkg.name %>.js',
        dest: 'build/<%= pkg.name %>.min.js'
      }
    },

    //ngdocs generator
    ngdocs: {
        all: ['modules/**/*.js'],
        options:{
          dest: 'docs',
          title: "openFFS Documentaions"
        }
      },

    //Connect Server
    connect: {
      options: {
          keepalive: true
        },
      server: {}
    },

    //Cleaner
    clean: ['docs'],

    //browserSync
    browserSync: {
      dev:{
        bsFiles: {
            src :[ 'modules/*.*',
                    'modules/**/*.html',
                    'modules/**/*.js',
                    '*.html'
          ]
        },
        options: {
            server: {
                baseDir: "./",
                injectChanges: true,
                open: 'local',
                watchTask: true,
                middleware: [modRewrite([
                  '!\\.\\w+$ /index.html [L]'
                ])]
            }
        }
      }
    },

    //wiredep
    wiredep: {
      target: {
        src: 'index.html' // point to your HTML file.
      }
    }
  });

  // Default task(s).
   grunt.registerTask('default', 'This is the default Task On Running it will list all available Tasks.', function() {
    grunt.log.subhead("Available Tasks for iamptk")
    grunt.log.ok("dev")
    grunt.log.ok("stage")
    grunt.log.ok("build")
  });

  // Default task(s).
  // grunt.registerTask('dev', ['uglify']);

  grunt.registerTask('docs', ['clean', 'ngdocs']);

  grunt.registerTask('dev', ['wiredep','browserSync:dev']);
};
