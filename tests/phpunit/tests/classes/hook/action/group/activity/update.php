<?php

/**
 * Test case for WordPoints_BP_Hook_Action_Group_Activity_Update.
 *
 * @package WordPoints\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests WordPoints_BP_Hook_Action_Group_Activity_Update.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Action_Group_Activity_Update
 */
class WordPoints_BP_Hook_Action_Group_Activity_Update_Test
	extends WordPoints_PHPUnit_TestCase_Hooks {

	/**
	 * Test checking if an action should fire.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_requirements_met() {

		$this->factory->bp = new BP_UnitTest_Factory();

		$activity = $this->factory->bp->activity->create_and_get(
			array( 'component' => 'groups' )
		);

		$action = new WordPoints_BP_Hook_Action_Group_Activity_Update(
			'test_event'
			, array( 'a', $activity )
			, array( 'arg_index' => array( 'bp_group_activity_update' => 1 ) )
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

		$activity_id = $this->factory->bp->activity->create(
			array( 'component' => 'groups' )
		);

		$action = new WordPoints_BP_Hook_Action_Group_Activity_Update(
			'test_event'
			, array( 'a', $activity_id )
			, array( 'arg_index' => array( 'bp_group_activity_update' => 1 ) )
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
			array(
				'type'      => 'other',
				'component' => 'groups',
			)
		);

		$action = new WordPoints_BP_Hook_Action_Group_Activity_Update(
			'test_event'
			, array( 'a', $activity )
			, array( 'arg_index' => array( 'bp_group_activity_update' => 1 ) )
		);

		$this->assertFalse( $action->should_fire() );
	}

	/**
	 * Test that an action shouldn't fire if the update isn't for the Groups.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_not_groups() {

		$this->factory->bp = new BP_UnitTest_Factory();

		$activity = $this->factory->bp->activity->create_and_get(
			array( 'component' => 'activity' )
		);

		$action = new WordPoints_BP_Hook_Action_Group_Activity_Update(
			'test_event'
			, array( 'a', $activity )
			, array( 'arg_index' => array( 'bp_group_activity_update' => 1 ) )
		);

		$this->assertFalse( $action->should_fire() );
	}

	/**
	 * Test checking if an action should fire when the requirements are met.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_other_requirements_met() {

		$this->factory->bp = new BP_UnitTest_Factory();

		$activity = $this->factory->bp->activity->create_and_get(
			array( 'component' => 'groups' )
		);

		$action = new WordPoints_BP_Hook_Action_Group_Activity_Update(
			'test_event'
			, array( 'a', $activity )
			, array(
				'arg_index' => array( 'bp_group_activity_update' => 1 ),
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

		$activity = $this->factory->bp->activity->create_and_get(
			array( 'component' => 'groups' )
		);

		$action = new WordPoints_BP_Hook_Action_Group_Activity_Update(
			'test_event'
			, array( 'a', $activity )
			, array(
				'arg_index' => array( 'bp_group_activity_update' => 1 ),
				'requirements' => array( 0 => 'b' ),
			)
		);

		$this->assertFalse( $action->should_fire() );
	}
}

// EOF
