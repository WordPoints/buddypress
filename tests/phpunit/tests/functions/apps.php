<?php

/**
 * Test case for the apps functions.
 *
 * @package WordPoints_BuddyPress\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests the apps functions.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Apps_Functions_Test extends WordPoints_PHPUnit_TestCase_Hooks {

	/**
	 * Test the Messages component entity registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_messages_entities_init
	 */
	public function test_messages_entities() {

		$this->mock_apps();

		$entities = wordpoints_entities();

		wordpoints_bp_messages_entities_init( $entities );

		$children = $entities->get_sub_app( 'children' );

		$this->assertTrue( $entities->is_registered( 'bp_message' ) );
		$this->assertTrue( $children->is_registered( 'bp_message', 'content' ) );
		$this->assertTrue( $children->is_registered( 'bp_message', 'date_sent' ) );
		$this->assertTrue( $children->is_registered( 'bp_message', 'recipients' ) );
		$this->assertTrue( $children->is_registered( 'bp_message', 'sender' ) );
		$this->assertTrue( $children->is_registered( 'bp_message', 'subject' ) );
	}

	/**
	 * Test the Messages component 'know' entity restriction registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_messages_entity_restrictions_know_init
	 */
	public function test_messages_know_restrictions() {

		$restrictions = new WordPoints_Class_Registry_Deep_Multilevel();

		wordpoints_bp_messages_entity_restrictions_know_init( $restrictions );

		$this->assertTrue( $restrictions->is_registered( 'thread_accessible', array( 'bp_message' ) ) );
	}

	/**
	 * Test the Messages component action registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_messages_hook_actions_init
	 */
	public function test_messages_actions() {

		$this->mock_apps();

		$actions = wordpoints_hooks()->get_sub_app( 'actions' );

		wordpoints_bp_messages_hook_actions_init( $actions );

		$this->assertTrue( $actions->is_registered( 'bp_message_send' ) );
	}

	/**
	 * Test the Messages component events registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_messages_hook_events_init
	 */
	public function test_messages_events() {

		$this->mock_apps();

		$events = wordpoints_hooks()->get_sub_app( 'events' );

		wordpoints_bp_messages_hook_events_init( $events );

		$this->assertEventRegistered( 'bp_message_send', 'bp_message' );
	}

	/**
	 * Test the Friends component entity registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_friends_entities_init
	 */
	public function test_friends_entities() {

		$this->mock_apps();

		$entities = wordpoints_entities();

		wordpoints_bp_friends_entities_init( $entities );

		$children = $entities->get_sub_app( 'children' );

		$this->assertTrue( $entities->is_registered( 'bp_friendship' ) );
		$this->assertTrue( $children->is_registered( 'bp_friendship', 'date_created' ) );
		$this->assertTrue( $children->is_registered( 'bp_friendship', 'friend' ) );
		$this->assertTrue( $children->is_registered( 'bp_friendship', 'initiator' ) );
	}

	/**
	 * Test the Friends component action registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_friends_hook_actions_init
	 */
	public function test_friends_actions() {

		$this->mock_apps();

		$actions = wordpoints_hooks()->get_sub_app( 'actions' );

		wordpoints_bp_friends_hook_actions_init( $actions );

		$this->assertTrue( $actions->is_registered( 'bp_friendship_request' ) );
		$this->assertTrue( $actions->is_registered( 'bp_friendship_withdraw' ) );
		$this->assertTrue( $actions->is_registered( 'bp_friendship_accept' ) );
		$this->assertTrue( $actions->is_registered( 'bp_friendship_delete' ) );
	}

	/**
	 * Test the Friends component events registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_friends_hook_events_init
	 */
	public function test_friends_events() {

		$this->mock_apps();

		$events = wordpoints_hooks()->get_sub_app( 'events' );

		wordpoints_bp_friends_hook_events_init( $events );

		$this->assertEventRegistered( 'bp_friendship_request', 'bp_friendship' );
		$this->assertEventRegistered( 'bp_friendship_accept', 'bp_friendship' );
	}

	/**
	 * Test the Groups component entity registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_groups_entities_init
	 */
	public function test_groups_entities() {

		$this->mock_apps();

		$entities = wordpoints_entities();

		wordpoints_bp_groups_entities_init( $entities );

		$children = $entities->get_sub_app( 'children' );

		$this->assertTrue( $entities->is_registered( 'bp_group' ) );
		$this->assertTrue( $children->is_registered( 'bp_group', 'creator' ) );
		$this->assertTrue( $children->is_registered( 'bp_group', 'date_created' ) );
		$this->assertTrue( $children->is_registered( 'bp_group', 'description' ) );
		$this->assertTrue( $children->is_registered( 'bp_group', 'name' ) );
		$this->assertTrue( $children->is_registered( 'bp_group', 'parent' ) );
		$this->assertTrue( $children->is_registered( 'bp_group', 'slug' ) );
		$this->assertTrue( $children->is_registered( 'bp_group', 'status' ) );
	}

	/**
	 * Test the Groups component 'know' entity restriction registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_groups_entity_restrictions_know_init
	 */
	public function test_groups_know_restrictions() {

		$restrictions = new WordPoints_Class_Registry_Deep_Multilevel();

		wordpoints_bp_groups_entity_restrictions_know_init( $restrictions );

		$this->assertTrue( $restrictions->is_registered( 'status_nonpublic', array( 'bp_group' ) ) );
	}

	/**
	 * Test the Groups component action registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_groups_hook_actions_init
	 */
	public function test_groups_actions() {

		$this->mock_apps();

		$actions = wordpoints_hooks()->get_sub_app( 'actions' );

		wordpoints_bp_groups_hook_actions_init( $actions );

		$this->assertTrue( $actions->is_registered( 'bp_group_create' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_delete' ) );
	}

	/**
	 * Test the Groups component events registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_groups_hook_events_init
	 */
	public function test_groups_events() {

		$this->mock_apps();

		$events = wordpoints_hooks()->get_sub_app( 'events' );

		wordpoints_bp_groups_hook_events_init( $events );

		$this->assertEventRegistered( 'bp_group_create', 'bp_group' );
	}

	/**
	 * Test the Activity component entity registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_groups_entities_init
	 */
	public function test_activity_entities() {

		$this->mock_apps();

		$entities = wordpoints_entities();

		wordpoints_bp_activity_entities_init( $entities );

		$children = $entities->get_sub_app( 'children' );

		$this->assertTrue( $entities->is_registered( 'bp_activity_update' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity_update', 'author' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity_update', 'content' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity_update', 'date_posted' ) );
	}

	/**
	 * Test the Activity component 'know' entity restriction registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_groups_entity_restrictions_know_init
	 */
	public function test_activity_know_restrictions() {

		$restrictions = new WordPoints_Class_Registry_Deep_Multilevel();

		wordpoints_bp_activity_entity_restrictions_know_init( $restrictions );

		$this->assertTrue( $restrictions->is_registered( 'hidden', array( 'bp_activity_update' ) ) );
		$this->assertTrue( $restrictions->is_registered( 'spam', array( 'bp_activity_update' ) ) );
	}

	/**
	 * Test the Activity component action registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_groups_hook_actions_init
	 */
	public function test_activity_actions() {

		$this->mock_apps();

		$actions = wordpoints_hooks()->get_sub_app( 'actions' );

		wordpoints_bp_activity_hook_actions_init( $actions );

		$this->assertTrue( $actions->is_registered( 'bp_activity_update_post' ) );
		$this->assertTrue( $actions->is_registered( 'bp_activity_update_ham' ) );
		$this->assertTrue( $actions->is_registered( 'bp_activity_update_spam' ) );
		$this->assertTrue( $actions->is_registered( 'bp_activity_update_delete' ) );
	}

	/**
	 * Test the Activity component events registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_activity_hook_events_init
	 */
	public function test_activity_events() {

		$this->mock_apps();

		$events = wordpoints_hooks()->get_sub_app( 'events' );

		wordpoints_bp_activity_hook_events_init( $events );

		$this->assertEventRegistered( 'bp_activity_update_post', 'bp_activity_update' );
	}

	/**
	 * Test the Activity component events registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_activity_split_before_delete_action
	 */
	public function test_activity_split_before_delete_action() {

		$this->factory->bp = new BP_UnitTest_Factory();

		$activity_test = $this->factory->bp->activity->create_and_get(
			array( 'type' => 'test' )
		);

		$activity_update = $this->factory->bp->activity->create_and_get(
			array( 'type' => 'activity_update' )
		);

		$activity_update_2 = $this->factory->bp->activity->create_and_get(
			array( 'type' => 'activity_update' )
		);

		$mock = new WordPoints_PHPUnit_Mock_Filter();
		$mock->add_action( 'wordpoints_bp_activity_before_delete_activity_update' );

		wordpoints_bp_activity_split_before_delete_action(
			array( $activity_test, $activity_update, $activity_update_2 )
		);

		$this->assertSame(
			array( array( $activity_update ), array( $activity_update_2 ) )
			, $mock->calls
		);
	}
}

// EOF
