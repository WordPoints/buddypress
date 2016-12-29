<?php

/**
 * Test case for WordPoints_BP_Hook_Action_Group_Invite_User.
 *
 * @package WordPoints\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests WordPoints_BP_Hook_Action_Group_Invite_User.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Action_Group_Invite_User
 */
class WordPoints_BP_Hook_Action_Group_Invite_User_Test
	extends WordPoints_PHPUnit_TestCase_Hooks {

	/**
	 * Test getting an action arg's value.
	 *
	 * @since 1.0.0
	 */
	public function test_get_arg_value() {

		$action = new WordPoints_BP_Hook_Action_Group_Invite_User(
			'test_event'
			, array( array( 'user_id' => 1, 'group_id' => 2, 'inviter_id' => 3 ) )
		);

		$this->assertSame( 1, $action->get_arg_value( 'user' ) );
		$this->assertSame( 2, $action->get_arg_value( 'bp_group' ) );
		$this->assertSame( 3, $action->get_arg_value( 'inviter:user' ) );
		$this->assertNull( $action->get_arg_value( 'test' ) );
	}
}

// EOF
