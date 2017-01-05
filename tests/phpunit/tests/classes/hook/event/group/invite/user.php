<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Group_Invite_Send class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Group_Invite_Send class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Group_Invite_Send
 *
 * @requires WordPoints version
 * @WordPoints-version 2.3.0-alpha-2
 */
class WordPoints_BP_Hook_Event_Group_Invite_User_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_group_invite_send';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Group_Invite_Send';

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array(
		array( 'bp_group', 'creator', 'user' ),
		array( 'bp_group', 'parent', 'bp_group', 'creator', 'user' ),
		array( 'user' ),
		array( 'inviter:user' ),
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

		// A group that the user will be uninvited from.
		$user_id  = $this->factory->user->create();
		$inviter_id = $this->factory->user->create();
		$group_id = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		groups_invite_user(
			array(
				'group_id' => $group_id,
				'user_id' => $user_id,
				'inviter_id' => $inviter_id,
			)
		);

		// A group that the invite will be deleted from.
		$user_id_2  = $this->factory->user->create();
		$inviter_id_2 = $this->factory->user->create();
		$group_id_2 = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		groups_invite_user(
			array(
				'group_id' => $group_id_2,
				'user_id' => $user_id_2,
				'inviter_id' => $inviter_id_2,
			)
		);

		return array(
			array( 'bp_group' => $group_id, 'user' => $user_id, 'inviter:user' => $inviter_id ),
			array( 'bp_group' => $group_id_2, 'user' => $user_id_2, 'inviter:user' => $inviter_id_2 ),
		);
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		switch ( $index ) {

			case 1:
				groups_delete_invite( $arg_id['user'], $arg_id['bp_group'] );
			break;

			default:
				groups_uninvite_user( $arg_id['user'], $arg_id['bp_group'] );
		}
	}
}

// EOF
