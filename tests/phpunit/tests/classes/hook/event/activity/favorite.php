<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Activity_Favorite class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Activity_Favorite class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Activity_Favorite
 *
 * @requires WordPoints version
 * @WordPoints-version 2.3.0-alpha-2
 */
class WordPoints_BP_Hook_Event_Activity_Favorite_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_activity_favorite';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Activity_Favorite';

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array(
		array( 'user' ),
		array( 'bp_activity', 'user', 'user' ),
	);

	/**
	 * @since 1.0.0
	 */
	public function data_provider_targets() {

		// Support for multiple signature args was added in WordPoints 2.3.0-alpha-2.
		// See https://github.com/WordPoints/wordpoints/issues/594.
		if ( ! version_compare( WORDPOINTS_VERSION, '2.3.0-alpha-1', '>' ) ) {
			return array( array() );
		}

		return parent::data_provider_targets();
	}

	/**
	 * @since 1.0.0
	 */
	protected function fire_event( $arg, $reactor_slug ) {

		$this->factory->bp = new BP_UnitTest_Factory();

		$activity_id = $this->factory->bp->activity->create(
			array( 'user_id' => $this->factory->user->create() )
		);

		$user_id = $this->factory->user->create();

		wp_set_current_user( $user_id );

		bp_activity_add_user_favorite( $activity_id, $user_id );

		return array(
			array( 'bp_activity' => $activity_id, 'user' => $user_id ),
		);
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		bp_activity_remove_user_favorite( $arg_id['bp_activity'], $arg_id['user'] );
	}
}

// EOF
