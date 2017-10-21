<?php

/**
 * Test case for WordPoints_BP_Hook_Action_Avatar_Delete.
 *
 * @package WordPoints\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests WordPoints_BP_Hook_Action_Avatar_Delete.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Action_Avatar_Delete
 */
class WordPoints_BP_Hook_Action_Avatar_Delete_Test
	extends WordPoints_PHPUnit_TestCase_Hooks {

	/**
	 * Test checking if an action should fire.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_requirements_met() {

		$action = new WordPoints_BP_Hook_Action_Avatar_Delete(
			'test_event'
			, array( array( 'item_id' => 1, 'object' => 'test' ) )
			, array( 'bp_avatar_object_type' => 'test' )
		);

		$this->assertTrue( $action->should_fire() );
	}

	/**
	 * Test checking if an action should fire.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_requirements_met_default_user() {

		$action = new WordPoints_BP_Hook_Action_Avatar_Delete(
			'test_event'
			, array( array( 'item_id' => 1, 'object' => 'user' ) )
		);

		$this->assertTrue( $action->should_fire() );
	}

	/**
	 * Test that an action shouldn't fire when the object type doesn't match.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_not_object_type() {

		$action = new WordPoints_BP_Hook_Action_Avatar_Delete(
			'test_event'
			, array( array( 'item_id' => 1, 'object' => 'test' ) )
			, array( 'bp_avatar_object_type' => 'other' )
		);

		$this->assertFalse( $action->should_fire() );
	}

	/**
	 * Test checking if an action should fire when the requirements are met.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_other_requirements_met() {

		$action = new WordPoints_BP_Hook_Action_Avatar_Delete(
			'test_event'
			, array( array( 'item_id' => 1, 'object' => 'test' ), 'a' )
			, array(
				'bp_avatar_object_type' => 'test',
				'requirements'          => array( 1 => 'a' ),
			)
		);

		$this->assertTrue( $action->should_fire() );
	}

	/**
	 * Test checking if an action should fire when the requirements aren't met.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_other_requirements_not_met() {

		$action = new WordPoints_BP_Hook_Action_Avatar_Delete(
			'test_event'
			, array( array( 'item_id' => 1, 'object' => 'test' ), 'a' )
			, array(
				'bp_avatar_object_type' => 'test',
				'requirements'          => array( 1 => 'b' ),
			)
		);

		$this->assertFalse( $action->should_fire() );
	}

	/**
	 * Test an action arg's value.
	 *
	 * @since 1.0.0
	 */
	public function test_get_arg_value() {

		$action = new WordPoints_BP_Hook_Action_Avatar_Delete(
			'test_event'
			, array( array( 'item_id' => 1, 'object' => 'test' ) )
			, array( 'bp_avatar_object_type' => 'test' )
		);

		$this->assertSame( 1, $action->get_arg_value( 'bp_test' ) );
		$this->assertNull( $action->get_arg_value( 'test' ) );
	}

	/**
	 * Test an action arg's value.
	 *
	 * @since 1.0.0
	 */
	public function test_get_arg_value_other_arg() {

		$action = new WordPoints_BP_Hook_Action_Avatar_Delete(
			'test_event'
			, array( array( 'item_id' => 1, 'object' => 'test' ) )
			, array( 'bp_avatar_object_type' => 'test' )
		);

		$this->assertNull( $action->get_arg_value( 'other' ) );
	}

	/**
	 * Test an action arg's value.
	 *
	 * @since 1.0.0
	 */
	public function test_get_arg_value_user() {

		$action = new WordPoints_BP_Hook_Action_Avatar_Delete(
			'test_event'
			, array( array( 'item_id' => 1, 'object' => 'user' ) )
			, array( 'bp_avatar_object_type' => 'user' )
		);

		$this->assertSame( 1, $action->get_arg_value( 'user' ) );
		$this->assertNull( $action->get_arg_value( 'bp_user' ) );
	}

	/**
	 * Test an action arg's value.
	 *
	 * @since 1.0.0
	 */
	public function test_get_arg_value_default_user() {

		$action = new WordPoints_BP_Hook_Action_Avatar_Delete(
			'test_event'
			, array( array( 'item_id' => 1, 'object' => 'user' ) )
		);

		$this->assertSame( 1, $action->get_arg_value( 'user' ) );
		$this->assertNull( $action->get_arg_value( 'bp_user' ) );
	}

	/**
	 * Test an action arg's value.
	 *
	 * @since 1.0.0
	 */
	public function test_get_arg_value_blog() {

		$action = new WordPoints_BP_Hook_Action_Avatar_Delete(
			'test_event'
			, array( array( 'item_id' => 1, 'object' => 'blog' ) )
			, array( 'bp_avatar_object_type' => 'blog' )
		);

		$this->assertSame( 1, $action->get_arg_value( 'site' ) );
		$this->assertNull( $action->get_arg_value( 'blog' ) );
	}
}

// EOF
