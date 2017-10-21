<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Group_Cover_Image_Upload class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Group_Cover_Image_Upload class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Group_Cover_Image_Upload
 *
 * @WordPoints-requires is_buddypress_2_8_0
 */
class WordPoints_BP_Hook_Event_Group_Cover_Image_Upload_Test
	extends WordPoints_BP_Hook_Event_XProfile_Cover_Image_Upload_Test {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_group_cover_image_upload';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Group_Cover_Image_Upload';

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
	protected function fire_event( $arg, $reactor_slug ) {

		$this->factory->bp = new BP_UnitTest_Factory();

		$user_id  = $this->factory->user->create();
		$group_id = $this->factory->bp->group->create(
			array(
				'creator_id' => $user_id,
				'parent_id'  => $this->factory->bp->group->create(),
			)
		);

		// Needs to be set for the correct upload path to be used.
		buddypress()->current_component = 'groups';

		// Reset this in case it has already been set in an earlier test.
		buddypress()->groups->current_group = null;

		$this->upload_cover_image(
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

		$this->delete_cover_image(
			get_current_user_id()
			, array( 'item_id' => $arg_id['bp_group'], 'object' => 'group' )
		);
	}
}

// EOF
