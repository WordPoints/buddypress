<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Group_Join class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Group_Join class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Group_Join
 */
class WordPoints_BP_Hook_Event_Group_Join_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_group_join';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Group_Join';

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
	protected function fire_event( $arg, $reactor_slug ) {

		$this->factory->bp = new BP_UnitTest_Factory();

		// A group to be joined regularly and left regularly.
		$user_id  = $this->factory->user->create();
		$group_id = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		groups_join_group( $group_id, $user_id );

		// A group that the user will be banned from and then unbanned.
		$user_id_2  = $this->factory->user->create();
		$group_id_2 = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		// Ban, unban, and remove require this.
		add_filter( 'bp_is_item_admin', '__return_true' );

		groups_join_group( $group_id_2, $user_id_2 );
		groups_ban_member( $user_id_2, $group_id_2 );
		groups_unban_member( $user_id_2, $group_id_2 );

		// A group that the user will be removed from by a moderator.
		$user_id_3  = $this->factory->user->create();
		$group_id_3 = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		groups_join_group( $group_id_3, $user_id_3 );

		// A group that the user will be removed from when the group is deleted.
		$user_id_4  = $this->factory->user->create();
		$group_id_4 = $this->factory->bp->group->create(
			array( 'parent_id' => $this->factory->bp->group->create() )
		);

		groups_join_group( $group_id_4, $user_id_4 );

		return array(
			array( 'bp_group' => $group_id, 'user' => $user_id ),
			array( 'bp_group' => $group_id_2, 'user' => $user_id_2 ),
			array( 'bp_group' => $group_id_3, 'user' => $user_id_3 ),
			array( 'bp_group' => $group_id_4, 'user' => $user_id_4 ),
		);
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		switch ( $index ) {

			case 1:
				groups_ban_member( $arg_id['user'], $arg_id['bp_group'] );
			break;

			case 2:
				groups_remove_member( $arg_id['user'], $arg_id['bp_group'] );
			break;

			case 3:
				groups_delete_group( $arg_id['bp_group'] );
			break;

			default:
				groups_leave_group( $arg_id['bp_group'], $arg_id['user'] );
		}
	}
}

// EOF
