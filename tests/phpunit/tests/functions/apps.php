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
}

// EOF
