<?php

/**
 * Test case for WordPoints_BP_Hook_Action_Activity_Type.
 *
 * @package WordPoints\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests WordPoints_BP_Hook_Action_Activity_Type.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Action_Activity_Type
 */
class WordPoints_BP_Hook_Action_Activity_Update_Test
	extends WordPoints_PHPUnit_TestCase_Hooks {

	/**
	 * Test checking if an action should fire.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_requirements_met() {

		$this->factory->bp = new BP_UnitTest_Factory();

		$action = new WordPoints_BP_Hook_Action_Activity_Type(
			'test_event'
			, array( 'a', $this->factory->bp->activity->create_and_get() )
			, array( 'arg_index' => array( 'bp_activity_update' => 1 ) )
		);

		$this->assertTrue( $action->should_fire() );
	}

	/**
	 * Test checking if an action should fire.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_requirements_met_id() {

		$this->factory->bp = new BP_UnitTest_Factory();

		$action = new WordPoints_BP_Hook_Action_Activity_Type(
			'test_event'
			, array( 'a', $this->factory->bp->activity->create() )
			, array( 'arg_index' => array( 'bp_activity_update' => 1 ) )
		);

		$this->assertTrue( $action->should_fire() );
	}

	/**
	 * Test that an action shouldn't fire when it isn't an update.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_not_update() {

		$this->factory->bp = new BP_UnitTest_Factory();

		$activity = $this->factory->bp->activity->create_and_get(
			array( 'type' => 'other' )
		);

		$action = new WordPoints_BP_Hook_Action_Activity_Type(
			'test_event'
			, array( 'a', $activity )
			, array( 'arg_index' => array( 'bp_activity_update' => 1 ) )
		);

		$this->assertFalse( $action->should_fire() );
	}

	/**
	 * Test checking if an action should fire.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_requirements_met_other_type() {

		$this->factory->bp = new BP_UnitTest_Factory();

		$activity = $this->factory->bp->activity->create_and_get(
			array( 'type' => 'activity_comment' )
		);

		$action = new WordPoints_BP_Hook_Action_Activity_Type(
			'test_event'
			, array( 'a', $activity )
			, array(
				'arg_index'     => array( 'bp_activity_comment' => 1 ),
				'activity_type' => 'activity_comment',
			)
		);

		$this->assertTrue( $action->should_fire() );
	}

	/**
	 * Test checking if an action should fire when the requirements are met.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_other_requirements_met() {

		$this->factory->bp = new BP_UnitTest_Factory();

		$action = new WordPoints_BP_Hook_Action_Activity_Type(
			'test_event'
			, array( 'a', $this->factory->bp->activity->create_and_get() )
			, array(
				'arg_index' => array( 'bp_activity_update' => 1 ),
				'requirements' => array( 0 => 'a' ),
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

		$this->factory->bp = new BP_UnitTest_Factory();

		$action = new WordPoints_BP_Hook_Action_Activity_Type(
			'test_event'
			, array( 'a', $this->factory->bp->activity->create_and_get() )
			, array(
				'arg_index' => array( 'bp_activity_update' => 1 ),
				'requirements' => array( 0 => 'b' ),
			)
		);

		$this->assertFalse( $action->should_fire() );
	}
}

// EOF
