<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Activity_Update_Post class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Activity_Update_Post class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Activity_Update_Post
 */
class WordPoints_BP_Hook_Event_Activity_Update_Post_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_activity_update_post';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Activity_Update_Post';

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array(
		array( 'bp_activity_update', 'author', 'user' ),
	);

	/**
	 * @since 1.0.0
	 */
	protected function fire_event( $arg, $reactor_slug ) {

		$this->factory->bp = new BP_UnitTest_Factory();

		$user_id     = $this->factory->user->create();
		$activity_id = $this->factory->bp->activity->create(
			array(
				'spam'    => 1,
				'content' => 'Testing',
				'user_id' => $user_id,
			)
		);

		$by_ref = new BP_Activity_Activity( $activity_id );

		bp_activity_mark_as_ham( $by_ref );

		// A non-update activity, to demonstrate that the event doesn't fire for it.
		$non_group_activity_id = $this->factory->bp->activity->create(
			array(
				'spam'    => 1,
				'type'    => 'other',
				'content' => 'Testing',
				'user_id' => $user_id,
			)
		);

		$by_ref = new BP_Activity_Activity( $non_group_activity_id );

		bp_activity_mark_as_ham( $by_ref );

		return array(
			bp_activity_post_update(
				array(
					'content' => 'Testing',
					'user_id' => $this->factory->user->create(),
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
