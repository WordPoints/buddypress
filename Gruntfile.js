/**
 * Grunt configuration file.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/* jshint node:true */
module.exports = function( grunt ) {

	var SOURCE_DIR = 'src/',
		DEV_LIB_DIR = 'dev-lib/';

	// Load tasks.
	require( 'matchdep' ).filterDev( 'grunt-*' ).forEach( grunt.loadNpmTasks );
	grunt.loadTasks( DEV_LIB_DIR + 'grunt/tasks/' );

	// Project configuration.
	grunt.initConfig({
		autoloader: {
			all: {
				src_dir: SOURCE_DIR,
				prefix: 'wordpoints_bp_',
				filter:  function ( class_files ) {

					// This class needs to come before other event classes.
					class_files.splice(
						class_files.indexOf( 'entity.php' ) + 1
						, 0
						, class_files.splice(
							class_files.indexOf( 'entity/activity/user.php' )
							, 1
						)[0]
					);

					return class_files;
				}
			}
		},
		watch: {
			autoloader: {
				files: [
					SOURCE_DIR + '**/classes/**/*.php',
					'!' + SOURCE_DIR + '**/classes/index.php'
				],
				tasks: ['autoloader'],
				options: {
					event: [ 'added', 'deleted' ]
				}
			},
			// This triggers an automatic reload of the `watch` task.
			config: {
				files: 'Gruntfile.js',
				tasks: ['build']
			}
		}
	});

	grunt.registerTask( 'build', ['autoloader'] );
	grunt.registerTask( 'default', 'build' );
};

// EOF
