module.exports = function(grunt) {

	//configuration
	grunt.initConfig({
		watch: {
			jsWidget: {
				files: ['assets/src/shell-widget.js'],
				tasks: ['build']
			}
		},

		uglify: {
			jsWidget: {
				src: 'assets/src/shell-widget.js',
				dest: 'assets/src/shell-widget.min.js',
				mangle: false
			},
		},
	});

	//loading of npm tasks
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	//task definitions
	grunt.registerTask('build', ['uglify:jsWidget']);
	grunt.registerTask('default', ['watch']);

};
