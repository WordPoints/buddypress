<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Group_Avatar_Upload class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Group_Avatar_Upload class.
 *
 * Requires BuddyPress 2.8.0-alpha+.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Group_Avatar_Upload
 *
 * @requires function bp_activity_get_excerpt_length
 */
class WordPoints_BP_Hook_Event_Group_Avatar_Upload_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_group_avatar_upload';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Group_Avatar_Upload';

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array(
		array( 'bp_group', 'creator', 'user' ),
		array( 'bp_group', 'parent', 'bp_group', 'creator', 'user' ),
		array( 'current:user' ),
	);

	/**
	 * @since 1.0.0
	 */
	public function data_provider_targets() {

		// Prevent "empty testsuite" errors on old PHPUnit versions.
		if ( ! version_compare( buddypress()->version, '2.8.0-alpha', '>=' ) ) {
			return array( array() );
		}

		return parent::data_provider_targets();
	}

	/**
	 * @since 1.0.0
	 */
	protected function fire_event( $arg, $reactor_slug ) {

		$this->factory->bp = new BP_UnitTest_Factory();

		$user_id  = $this->factory->user->create();
		$group_id = $this->factory->bp->group->create(
			array(
				'creator_id' => $user_id,
				'parent_id' => $this->factory->bp->group->create(),
			)
		);

		$this->upload_group_avatar( $user_id, $group_id );

		return array(
			$group_id,
		);
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		bp_core_delete_existing_avatar(
			array( 'object' => 'group', 'item_id' => $arg_id )
		);
	}

	/**
	 * Simulate uploading a group avatar.
	 *
	 * @since 1.0.0
	 *
	 * @param int $user_id  The ID of the user uploading the avatar.
	 * @param int $group_id The ID of the group to upload the avatar for.
	 */
	protected function upload_group_avatar( $user_id, $group_id ) {

		wp_set_current_user( $user_id );
		add_filter( 'bp_loggedin_user_id', 'get_current_user_id' );

		$path = bp_core_avatar_upload_path() . "/group-avatars/{$group_id}/test.png";

		wp_mkdir_p( dirname( $path ) );

		copy( WORDPOINTS_BP_TESTS_DIR . '/data/images/test.png', $path );

		$_SERVER['REQUEST_METHOD'] = 'POST';

		$_REQUEST['nonce']      = wp_create_nonce( 'bp_avatar_cropstore' );
		$_POST['type']          = 'crop';
		$_POST['object']        = 'group';
		$_POST['item_id']       = $group_id;
		$_POST['original_file'] = $path;

		add_filter( 'wp_doing_ajax', '__return_true' );
		add_action( 'wp_die_ajax_handler', array( $this, 'throw_exception' ) );

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
