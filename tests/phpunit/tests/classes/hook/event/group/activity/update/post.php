<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Group_Activity_Update_Post class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Group_Activity_Update_Post class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Group_Activity_Update_Post
 */
class WordPoints_BP_Hook_Event_Group_Activity_Update_Post_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_group_activity_update_post';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Group_Activity_Update_Post';

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array(
		array( 'bp_group_activity_update', 'author', 'user' ),
		array( 'bp_group_activity_update', 'group', 'bp_group', 'creator', 'user' ),
		array( 'bp_group_activity_update', 'group', 'bp_group', 'parent', 'bp_group', 'creator', 'user' ),
	);

	/**
	 * @since 1.0.0
	 */
	protected function fire_event( $arg, $reactor_slug ) {

		$this->factory->bp = new BP_UnitTest_Factory();

		// An activity to be maked as ham.
		$activity_id = $this->factory->bp->activity->create(
			array(
				'spam'    => 1,
				'type'    => 'activity_update',
				'component' => 'groups',
				'content' => 'Testing',
				'user_id' => $this->factory->user->create(),
				'item_id' => $this->factory->bp->group->create(
					array( 'parent_id' => $this->factory->bp->group->create() )
				),
			)
		);

		$by_ref = new BP_Activity_Activity( $activity_id );

		bp_activity_mark_as_ham( $by_ref );

		// For an activity to be posted regularly.
		$user_id  = $this->factory->user->create();
		$group_id = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		// The user must be a member of the group to post an update.
		groups_join_group( $group_id, $user_id );

		// A non-groups activity, to demonstrate that the event doesn't fire for it.
		$non_group_activity_id = $this->factory->bp->activity->create(
			array(
				'spam'    => 1,
				'type'    => 'activity_update',
				'content' => 'Testing',
				'user_id' => $user_id,
			)
		);

		$by_ref = new BP_Activity_Activity( $non_group_activity_id );

		bp_activity_mark_as_ham( $by_ref );

		return array(
			groups_post_update(
				array(
					'content' => 'Testing',
					'user_id' => $user_id,
					'group_id' => $group_id,
				)
			),
			$activity_id,
		);
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		switch ( $index ) {

			case 1:
				$by_ref = new BP_Activity_Activity( $arg_id );
				bp_activity_mark_as_spam( $by_ref );
			break;

			default:
				bp_activity_delete_by_activity_id( $arg_id );
		}
	}
}

// EOF
