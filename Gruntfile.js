module.exports = function(grunt) {
  
  // To show the time taken at the end of a Task
  require('time-grunt')(grunt);

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-uglify');

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      build: {
        src: 'src/<%= pkg.name %>.js',
        dest: 'build/<%= pkg.name %>.min.js'
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
  grunt.registerTask('dev', ['uglify']);
};
