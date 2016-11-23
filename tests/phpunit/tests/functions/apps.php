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

		$this->assertEventRegistered( 'bp_friendship_accept', 'bp_friendship' );
	}
}

// EOF
