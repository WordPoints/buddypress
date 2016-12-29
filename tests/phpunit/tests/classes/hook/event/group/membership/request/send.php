<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Group_Membership_Request_Send class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Group_Membership_Request_Send class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Group_Membership_Request_Send
 *
 * @requires WordPoints version
 * @WordPoints-version 2.3.0-alpha-2
 */
class WordPoints_BP_Hook_Event_Group_Membership_Request_Send_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_group_membership_request_send';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Group_Membership_Request_Send';

	/**
	 * Whether the event is reversible.
	 *
	 * We have to set this to false, because although this event is reversible, there
	 * are currently no actions that reverse it (requests can't be withdrawn).
	 *
	 * @since 1.0.0
	 */
	protected $is_reversible = false;

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array(
		array( 'bp_group', 'creator', 'user' ),
		array( 'bp_group', 'parent', 'bp_group', 'creator', 'user' ),
		array( 'user' ),
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

		$user_id  = $this->factory->user->create();
		$group_id = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		groups_send_membership_request( $user_id, $group_id );

		return array(
			array( 'bp_group' => $group_id, 'user' => $user_id ),
		);
	}
}

// EOF
