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
 * @WordPoints-requires is_buddypress_2_8_0
 */
class WordPoints_BP_Hook_Event_Group_Avatar_Upload_Test
	extends WordPoints_BP_Hook_Event_xProfile_Avatar_Upload_Test {

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
				'parent_id'  => $this->factory->bp->group->create(),
			)
		);

		// Groups may have an avatar set, so we need to delete it. Otherwise the
		// event will not be triggered, since it only triggers when initially set.
		bp_core_delete_existing_avatar(
			array( 'object' => 'group', 'item_id' => $group_id )
		);

		$this->upload_avatar(
			$user_id
			, array( 'item_id' => $group_id, 'object' => 'group' )
		);

		$this->upload_avatar(
			$user_id
			, array( 'item_id' => $group_id, 'object' => 'group' )
		);

		return array(
			array( 'bp_group' => $group_id, 'current:user' => $user_id ),
		);
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		unset( $_POST['nonce'] );

		bp_core_delete_existing_avatar(
			array( 'object' => 'group', 'item_id' => $arg_id['bp_group'] )
		);
	}
}

// EOF
