<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Friendship_Accept class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Friendship_Accept class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Friendship_Accept
 */
class WordPoints_BP_Hook_Event_Friendship_Accept_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_friendship_accept';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Friendship_Accept';

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
		$friendship        = $this->factory->bp->friendship->create_and_get();

		// Friendships can only be accepted for the current user.
		// It has always been this way:
		// https://buddypress.trac.wordpress.org/browser/trunk/bp-friends/bp-friends-classes.php?annotate=blame&rev=212#L176
		wp_set_current_user( $friendship->friend_user_id );
		add_filter( 'bp_loggedin_user_id', 'get_current_user_id' );

		friends_accept_friendship( $friendship->id );

		return array( $friendship->id );
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		$friendship = new BP_Friends_Friendship( $arg_id );

		friends_remove_friend(
			$friendship->initiator_user_id
			, $friendship->friend_user_id
		);
	}
}

// EOF
