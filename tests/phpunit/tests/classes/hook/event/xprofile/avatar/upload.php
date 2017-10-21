<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_XProfile_Avatar_Upload class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_XProfile_Avatar_Upload class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_XProfile_Avatar_Upload
 */
class WordPoints_BP_Hook_Event_XProfile_Avatar_Upload_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_xprofile_avatar_upload';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_XProfile_Avatar_Upload';

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array(
		array( 'user' ),
	);

	/**
	 * @since 1.0.0
	 */
	protected function fire_event( $arg, $reactor_slug ) {

		$user_id = $this->factory->user->create();

		$this->upload_avatar( $user_id );

		return array(
			$user_id,
		);
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		bp_core_delete_existing_avatar(
			array( 'object' => 'user', 'item_id' => (string) $arg_id )
		);
	}

	/**
	 * Simulate uploading an avatar.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $user_id The ID of the user uploading the avatar.
	 * @param array $args    {
	 *        Other args.
	 *
	 *        @type int    $item_id The ID of the item the avatar is for. Defaults to
	 *                              the $user_id.
	 *        @type string $object  The type of object the avatar is for. Default is
	 *                              'user'.
	 * }
	 */
	protected function upload_avatar( $user_id, array $args = array() ) {

		$args = array_merge(
			array( 'object' => 'user', 'item_id' => $user_id )
			, $args
		);

		wp_set_current_user( $user_id );
		add_filter( 'bp_loggedin_user_id', 'get_current_user_id' );

		if ( 'user' === $args['object'] ) {
			$avatar_dir = 'avatars';
		} else {
			$avatar_dir = 'group-avatars';
		}

		$path = bp_core_avatar_upload_path() . "/{$avatar_dir}/{$args['item_id']}/test.png";

		wp_mkdir_p( dirname( $path ) );

		copy( WORDPOINTS_BP_TESTS_DIR . '/data/images/test.png', $path );

		$_SERVER['REQUEST_METHOD'] = 'POST';

		$_REQUEST['nonce']      = wp_create_nonce( 'bp_avatar_cropstore' );
		$_POST['type']          = 'crop';
		$_POST['object']        = $args['object'];
		$_POST['item_id']       = (string) $args['item_id'];
		$_POST['original_file'] = $path;

		add_filter( 'wp_doing_ajax', '__return_true' );
		add_action( 'wp_die_ajax_handler', array( $this, 'throw_exception' ) );

		// Back-compat for WordPress <4.7, before the 'wp_doing_ajax' filter.
		add_action( 'wp_die_handler', array( $this, 'throw_exception' ) );

		ob_start();

		try {
			bp_avatar_ajax_set();
		} catch ( WordPoints_PHPUnit_Exception $e ) {
			unset( $e );
		}

		ob_end_clean();
	}
}

// EOF
