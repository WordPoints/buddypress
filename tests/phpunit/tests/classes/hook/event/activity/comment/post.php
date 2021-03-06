<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Activity_Comment_Post class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Activity_Comment_Post class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Activity_Comment_Post
 */
class WordPoints_BP_Hook_Event_Activity_Comment_Post_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_activity_comment_post';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Activity_Comment_Post';

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array(
		array( 'bp_activity_comment', 'author', 'user' ),
		array( 'bp_activity_comment', 'activity', 'bp_activity', 'user', 'user' ),
		array( 'bp_activity_comment', 'parent', 'bp_activity_comment', 'author', 'user' ),
	);

	/**
	 * @since 1.0.0
	 */
	protected function fire_event( $arg, $reactor_slug ) {

		$this->factory->bp = new BP_UnitTest_Factory();

		$activity_id = $this->factory->bp->activity->create(
			array( 'user_id' => $this->factory->user->create() )
		);

		$with_parent     = ( 'parent' === $this->target[1] );
		$share_activity  = ( $with_parent && 'activity' !== $this->target[3] );
		$the_activity_id = (
			$share_activity
				? $activity_id
				: $this->factory->bp->activity->create(
					array( 'user_id' => $this->factory->user->create() )
				)
			);

		$user_id    = $this->factory->user->create();
		$comment_id = $this->factory->bp->activity->create(
			array(
				'spam'              => 1,
				'type'              => 'activity_comment',
				'content'           => 'Testing',
				'user_id'           => $user_id,
				'item_id'           => $the_activity_id,
				'secondary_item_id' => ! $with_parent
					? false
					: bp_activity_new_comment(
						array(
							'content'     => 'Testing',
							'user_id'     => $this->factory->user->create(),
							'activity_id' => $the_activity_id,
						)
					),
			)
		);

		$by_ref = new BP_Activity_Activity( $comment_id );

		bp_activity_mark_as_ham( $by_ref );

		// Ham an activity of another type to show that it doesn't trigger the event.
		$other_id = $this->factory->bp->activity->create(
			array(
				'spam'    => 1,
				'type'    => 'other',
				'content' => 'Testing',
				'user_id' => $user_id,
			)
		);

		$by_ref = new BP_Activity_Activity( $other_id );

		bp_activity_mark_as_ham( $by_ref );

		$the_activity_id = (
			$share_activity
				? $activity_id
				: $this->factory->bp->activity->create(
					array( 'user_id' => $this->factory->user->create() )
				)
		);

		// This triggers a different action.
		$skip_notification = bp_activity_new_comment(
			array(
				'content'           => 'Testing',
				'user_id'           => $this->factory->user->create(),
				'activity_id'       => $the_activity_id,
				'parent_id'         => ! $with_parent
					? false
					: bp_activity_new_comment(
						array(
							'content'           => 'Testing',
							'user_id'           => $this->factory->user->create(),
							'activity_id'       => $the_activity_id,
							'skip_notification' => true,
						)
					),
				'skip_notification' => true,
			)
		);

		$the_activity_id = (
			$share_activity
				? $activity_id
				: $this->factory->bp->activity->create(
					array( 'user_id' => $this->factory->user->create() )
				)
		);

		return array(
			$skip_notification,
			bp_activity_new_comment(
				array(
					'content'     => 'Testing',
					'user_id'     => $this->factory->user->create(),
					'activity_id' => $the_activity_id,
					'parent_id'   => ! $with_parent
						? false
						: bp_activity_new_comment(
							array(
								'content'     => 'Testing',
								'user_id'     => $this->factory->user->create(),
								'activity_id' => $the_activity_id,
							)
						),
				)
			),
			$comment_id,
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
