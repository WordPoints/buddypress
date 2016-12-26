<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Group_Member_Promote_To_Mod class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Group_Member_Promote_To_Mod class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Group_Member_Promote_To_Mod
 */
class WordPoints_BP_Hook_Event_Group_Member_Promote_To_Mod_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_group_member_promote_to_mod';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Group_Member_Promote_To_Mod';

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
	 *
	 * @dataProvider data_provider_targets
	 */
	public function test_fires( $target, $reactor_slug ) {

		// Support for multiple signature args was added in WordPoints 2.3.0-alpha-2.
		// See https://github.com/WordPoints/wordpoints/issues/594.
		if ( ! version_compare( WORDPOINTS_VERSION, '2.3.0-alpha-1', '>' ) ) {
			$this->markTestSkipped( 'WordPoints version 2.3.0-alpha-2 or greater must be installed.' );
		}

		parent::test_fires( $target, $reactor_slug );
	}

	/**
	 * @since 1.0.0
	 */
	public function test_checked_expected_targets() {

		// Support for multiple signature args was added in WordPoints 2.3.0-alpha-2.
		// See https://github.com/WordPoints/wordpoints/issues/594.
		if ( ! version_compare( WORDPOINTS_VERSION, '2.3.0-alpha-1', '>' ) ) {
			$this->markTestSkipped( 'WordPoints version 2.3.0-alpha-2 or greater must be installed.' );
		}

		parent::test_checked_expected_targets();
	}

	/**
	 * @since 1.0.0
	 */
	protected function fire_event( $arg, $reactor_slug ) {

		$this->factory->bp = new BP_UnitTest_Factory();

		// Ban, unban, remove, promote, and demote require this.
		add_filter( 'bp_is_item_admin', '__return_true' );

		// A group to be promoted and demoted in regularly.
		$user_id  = $this->factory->user->create();
		$group_id = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		groups_join_group( $group_id, $user_id );
		groups_promote_member( $user_id, $group_id, 'mod' );

		// A group that the user will leave.
		$user_id_2  = $this->factory->user->create();
		$group_id_2 = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		groups_join_group( $group_id_2, $user_id_2 );
		groups_promote_member( $user_id_2, $group_id_2, 'mod' );

		// A group that the user will be banned from.
		$user_id_3  = $this->factory->user->create();
		$group_id_3 = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		groups_join_group( $group_id_3, $user_id_3 );
		groups_promote_member( $user_id_3, $group_id_3, 'mod' );

		// A group that the user will be removed from by a moderator.
		$user_id_4  = $this->factory->user->create();
		$group_id_4 = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		groups_join_group( $group_id_4, $user_id_4 );
		groups_promote_member( $user_id_4, $group_id_4, 'mod' );

		// A group that the user will be removed from when the group is deleted.
		$user_id_5  = $this->factory->user->create();
		$group_id_5 = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		groups_join_group( $group_id_5, $user_id_5 );
		groups_promote_member( $user_id_5, $group_id_5, 'mod' );

		return array(
			array( 'bp_group' => $group_id, 'user' => $user_id ),
			array( 'bp_group' => $group_id_2, 'user' => $user_id_2 ),
			array( 'bp_group' => $group_id_3, 'user' => $user_id_3 ),
			array( 'bp_group' => $group_id_4, 'user' => $user_id_4 ),
			array( 'bp_group' => $group_id_5, 'user' => $user_id_5 ),
		);
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		switch ( $index ) {

			case 1:
				groups_leave_group( $arg_id['bp_group'], $arg_id['user'] );
			break;

			case 2:
				groups_ban_member( $arg_id['user'], $arg_id['bp_group'] );
			break;

			case 3:
				groups_remove_member( $arg_id['user'], $arg_id['bp_group'] );
			break;

			case 4:
				groups_delete_group( $arg_id['bp_group'] );
			break;

			default:
				groups_demote_member( $arg_id['user'], $arg_id['bp_group'] );
		}
	}
}

// EOF
