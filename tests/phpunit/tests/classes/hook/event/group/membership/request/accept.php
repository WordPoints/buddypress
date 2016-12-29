<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Group_Membership_Request_Accept class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Group_Membership_Request_Accept class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Group_Membership_Request_Accept
 *
 * @requires WordPoints version
 * @WordPoints-version 2.3.0-alpha-2
 */
class WordPoints_BP_Hook_Event_Group_Membership_Request_Accept_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_group_membership_request_accept';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Group_Membership_Request_Accept';

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array(
		array( 'bp_group', 'creator', 'user' ),
		array( 'bp_group', 'parent', 'bp_group', 'creator', 'user' ),
		array( 'user' ),
		array( 'current:user' ),
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

		// A group that the user will leave.
		$user_id  = $this->factory->user->create();
		$group_id = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		$current_user_id = $this->factory->user->create();
		wp_set_current_user( $current_user_id );

		groups_send_membership_request( $user_id, $group_id );
		groups_accept_membership_request( null, $user_id, $group_id );

		// A group that the user will be deleted from.
		$user_id_2  = $this->factory->user->create();
		$group_id_2 = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		$current_user_id_2 = $this->factory->user->create();
		wp_set_current_user( $current_user_id_2 );

		groups_send_membership_request( $user_id_2, $group_id_2 );
		groups_accept_membership_request( null, $user_id_2, $group_id_2 );

		return array(
			array( 'bp_group' => $group_id, 'user' => $user_id, 'current:user' => $current_user_id ),
			array( 'bp_group' => $group_id_2, 'user' => $user_id_2, 'current:user' => $current_user_id_2 ),
		);
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		switch ( $index ) {

			case 1:
				add_filter( 'bp_is_item_admin', '__return_true' );

				groups_remove_member( $arg_id['user'], $arg_id['bp_group'] );
			break;

			default:
				groups_leave_group( $arg_id['bp_group'], $arg_id['user'] );
		}
	}
}

// EOF
