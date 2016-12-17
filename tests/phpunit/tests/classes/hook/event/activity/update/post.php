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

		$activity_id = bp_activity_post_update(
			array(
				'content' => 'Testing',
				'user_id' => $this->factory->user->create(),
				'spam'    => 1,
			)
		);

		bp_activity_mark_as_ham( $by_ref = new BP_Activity_Activity( $activity_id ) );

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
				bp_activity_mark_as_spam( new BP_Activity_Activity( $arg_id ) );
			break;

			default:
				bp_activity_delete_by_activity_id( $arg_id );
		}
	}
}

// EOF
