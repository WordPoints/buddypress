<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Friendship_Request class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Friendship_Request class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Friendship_Request
 */
class WordPoints_BP_Hook_Event_Friendship_Request_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_friendship_request';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Friendship_Request';

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array(
		array( 'bp_friendship', 'friend', 'user' ),
		array( 'bp_friendship', 'initiator', 'user' ),
	);

	/**
	 * @since 1.0.0
	 */
	protected function fire_event( $arg, $reactor_slug ) {

		$this->factory->bp = new BP_UnitTest_Factory();

		$initiator_id = $this->factory->user->create();
		$friend_id    = $this->factory->user->create();

		friends_add_friend( $initiator_id, $friend_id );

		return array( friends_get_friendship_id( $initiator_id, $friend_id ) );
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		$friendship = new BP_Friends_Friendship( $arg_id );

		// Friendships can only be withdrawn for the current user.
		// It has always been this way:
		// https://buddypress.trac.wordpress.org/browser/trunk/bp-friends/bp-friends-classes.php?annotate=blame&rev=212#L176
		wp_set_current_user( $friendship->initiator_user_id );
		add_filter( 'bp_loggedin_user_id', 'get_current_user_id' );

		friends_withdraw_friendship(
			$friendship->initiator_user_id
			, $friendship->friend_user_id
		);
	}
}

// EOF
