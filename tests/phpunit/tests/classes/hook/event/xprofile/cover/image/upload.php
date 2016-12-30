<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_XProfile_Cover_Image_Upload class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_XProfile_Cover_Image_Upload class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_XProfile_Cover_Image_Upload
 *
 * @WordPoints-requires is_buddypress_2_8_0
 */
class WordPoints_BP_Hook_Event_XProfile_Cover_Image_Upload_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_xprofile_cover_image_upload';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_XProfile_Cover_Image_Upload';

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array(
		array( 'user' ),
	);

	/**
	 * Check if BuddyPress version 2.8.0 or later is installed.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Whether the current BuddyPress version is 2.8.0 or greater.
	 */
	public function is_buddypress_2_8_0() {
		return version_compare( buddypress()->version, '2.8.0-alpha', '>=' );
	}

	/**
	 * @since 1.0.0
	 */
	public function data_provider_targets() {

		// Prevent "empty testsuite" errors on old PHPUnit versions.
		if ( ! $this->is_buddypress_2_8_0() ) {
			return array( array() );
		}

		return parent::data_provider_targets();
	}

	/**
	 * @since 1.0.0
	 */
	protected function fire_event( $arg, $reactor_slug ) {

		$user_id = $this->factory->user->create();

		$this->upload_cover_image( $user_id );

		return array(
			$user_id,
		);
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		$this->delete_cover_image( $arg_id );
	}

	/**
	 * Simulate uploading a profile cover image.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $user_id The ID of the user uploading the image.
	 * @param array $args    {
	 *        Other args.
	 *
	 *        @type int    $item_id The ID of the item the image is for. Defaults to
	 *                              the $user_id.
	 *        @type string $object  The type of object the image is for. Default is
	 *                              'user'.
	 * }
	 */
	protected function upload_cover_image( $user_id, array $args = array() ) {

		$args = array_merge(
			array( 'object' => 'user', 'item_id' => $user_id )
			, $args
		);

		wp_set_current_user( $user_id );
		add_filter( 'bp_loggedin_user_id', 'get_current_user_id' );
		add_filter( 'bp_displayed_user_id', 'get_current_user_id' );

		$path = WORDPOINTS_BP_TESTS_DIR . '/data/images/testing.png';

		// Copy the image, because otherwise it will get deleted.
		copy( WORDPOINTS_BP_TESTS_DIR . '/data/images/test.png', $path );

		$_SERVER['REQUEST_METHOD'] = 'POST';

		$_REQUEST['_wpnonce'] = wp_create_nonce( 'bp-uploader' );

		$_POST['action'] = 'bp_cover_image_upload';
		$_POST['bp_params']['object']  = $args['object'];
		$_POST['bp_params']['item_id'] = $args['item_id'];

		$_FILES['file'] = array(
			'tmp_name' => $path,
			'name' => 'test.png',
			'type' => 'image/png',
			'size' => '4221',
		);

		add_filter( 'wp_doing_ajax', '__return_true' );
		add_action( 'wp_die_ajax_handler', array( $this, 'throw_exception' ) );

		// Back-compat for WordPress <4.7, before the 'wp_doing_ajax' filter.
		add_action( 'wp_die_handler', array( $this, 'throw_exception' ) );

		ob_start();

		try {
			bp_attachments_cover_image_ajax_upload();
		} catch ( WordPoints_PHPUnit_Exception $e ) {
			unset( $e );
		}

		ob_end_clean();
	}

	/**
	 * Simulate deleting a profile cover image.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $user_id The ID of the user deleting the image.
	 * @param array $args    {
	 *        Other args.
	 *
	 *        @type int    $item_id The ID of the item the image is for. Defaults to
	 *                              the $user_id.
	 *        @type string $object  The type of object the image is for. Default is
	 *                              'user'.
	 * }
	 */
	protected function delete_cover_image( $user_id, array $args = array() ) {

		$args = array_merge(
			array( 'object' => 'user', 'item_id' => $user_id )
			, $args
		);

		wp_set_current_user( $user_id );
		add_filter( 'bp_loggedin_user_id', 'get_current_user_id' );

		$_SERVER['REQUEST_METHOD'] = 'POST';

		$_REQUEST['nonce'] = wp_create_nonce( 'bp_delete_cover_image' );

		$_POST['action'] = 'bp_cover_image_upload';
		$_POST['object']  = $args['object'];
		$_POST['item_id'] = $args['item_id'];

		add_filter( 'wp_doing_ajax', '__return_true' );
		add_action( 'wp_die_ajax_handler', array( $this, 'throw_exception' ) );

		ob_start();

		try {
			bp_attachments_cover_image_ajax_delete();
		} catch ( WordPoints_PHPUnit_Exception $e ) {
			unset( $e );
		}

		ob_end_clean();
	}
}

// EOF
