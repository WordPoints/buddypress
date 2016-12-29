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

		if ( bp_is_active( 'activity' ) ) {
			$this->assertTrue( $entities->is_registered( 'bp_group_activity_update' ) );
			$this->assertTrue( $children->is_registered( 'bp_group_activity_update', 'author' ) );
			$this->assertTrue( $children->is_registered( 'bp_group_activity_update', 'content' ) );
			$this->assertTrue( $children->is_registered( 'bp_group_activity_update', 'date_posted' ) );
			$this->assertTrue( $children->is_registered( 'bp_group_activity_update', 'group' ) );
		} else {
			$this->assertFalse( $entities->is_registered( 'bp_group_activity_update' ) );
			$this->assertFalse( $children->is_registered( 'bp_group_activity_update', 'author' ) );
			$this->assertFalse( $children->is_registered( 'bp_group_activity_update', 'content' ) );
			$this->assertFalse( $children->is_registered( 'bp_group_activity_update', 'date_posted' ) );
			$this->assertFalse( $children->is_registered( 'bp_group_activity_update', 'group' ) );
		}
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

		if ( bp_is_active( 'activity' ) ) {

			$this->assertTrue(
				$restrictions->is_registered( 'hidden', array( 'bp_group_activity_update' ) )
			);

			$this->assertTrue(
				$restrictions->is_registered( 'spam', array( 'bp_group_activity_update' ) )
			);

		} else {

			$this->assertFalse(
				$restrictions->is_registered( 'hidden', array( 'bp_group_activity_update' ) )
			);

			$this->assertFalse(
				$restrictions->is_registered( 'spam', array( 'bp_group_activity_update' ) )
			);
		}
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

		$this->assertTrue( $actions->is_registered( 'bp_group_join' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_leave' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_member_ban' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_member_unban' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_member_remove' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_delete_member_remove' ) );

		$this->assertTrue( $actions->is_registered( 'bp_group_member_promote_to_mod' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_member_promote_to_admin' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_member_demote' ) );

		$this->assertTrue( $actions->is_registered( 'bp_group_invite_user' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_uninvite_user' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_invite_accept' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_invite_reject' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_invite_delete' ) );

		$this->assertTrue( $actions->is_registered( 'bp_group_avatar_upload' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_avatar_delete' ) );

		$this->assertTrue( $actions->is_registered( 'bp_group_cover_image_upload' ) );
		$this->assertTrue( $actions->is_registered( 'bp_group_cover_image_delete' ) );

		if ( bp_is_active( 'activity' ) ) {
			$this->assertTrue( $actions->is_registered( 'bp_group_activity_update_post' ) );
			$this->assertTrue( $actions->is_registered( 'bp_group_activity_update_ham' ) );
			$this->assertTrue( $actions->is_registered( 'bp_group_activity_update_spam' ) );
			$this->assertTrue( $actions->is_registered( 'bp_group_activity_update_delete' ) );
		} else {
			$this->assertFalse( $actions->is_registered( 'bp_group_activity_update_post' ) );
			$this->assertFalse( $actions->is_registered( 'bp_group_activity_update_ham' ) );
			$this->assertFalse( $actions->is_registered( 'bp_group_activity_update_spam' ) );
			$this->assertFalse( $actions->is_registered( 'bp_group_activity_update_delete' ) );
		}
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

		if ( version_compare( WORDPOINTS_VERSION, '2.3.0-alpha-1', '>' ) ) {
			$this->assertEventRegistered( 'bp_group_join', array( 'bp_group', 'user' ) );
			$this->assertEventRegistered( 'bp_group_member_promote_to_admin', array( 'bp_group', 'user' ) );
			$this->assertEventRegistered( 'bp_group_member_promote_to_mod', array( 'bp_group', 'user' ) );
			$this->assertEventRegistered( 'bp_group_invite_user', array( 'bp_group', 'user', 'inviter:user' ) );
		} else {
			$this->assertEventNotRegistered( 'bp_group_join', array( 'bp_group', 'user' ) );
			$this->assertEventNotRegistered( 'bp_group_member_promote_to_admin', array( 'bp_group', 'user' ) );
			$this->assertEventNotRegistered( 'bp_group_member_promote_to_mod', array( 'bp_group', 'user' ) );
			$this->assertEventNotRegistered( 'bp_group_invite_user', array( 'bp_group', 'user', 'inviter:user' ) );
		}

		if ( version_compare( buddypress()->version, '2.8.0-alpha', '>=' ) ) {
			$this->assertEventRegistered( 'bp_group_avatar_upload', array( 'bp_group', 'current:user' ) );
		} else {
			$this->assertEventNotRegistered( 'bp_group_avatar_upload', array( 'bp_group', 'current:user' ) );
		}

		if ( version_compare( buddypress()->version, '2.8.0-alpha', '>=' ) ) {
			$this->assertEventRegistered( 'bp_group_cover_image_upload', array( 'bp_group', 'current:user' ) );
		} else {
			$this->assertEventNotRegistered( 'bp_group_cover_image_upload', array( 'bp_group', 'current:user' ) );
		}

		if ( bp_is_active( 'activity' ) ) {
			$this->assertEventRegistered( 'bp_group_activity_update_post', 'bp_group_activity_update' );
		} else {
			$this->assertEventNotRegistered( 'bp_group_activity_update_post', 'bp_group_activity_update' );
		}
	}

	/**
	 * Test Groups events registration when group avatar uploads are disabled.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_groups_hook_events_init
	 */
	public function test_groups_events_group_avatar_uploads_disabled() {

		add_filter( 'bp_disable_group_avatar_uploads', '__return_true' );

		$this->mock_apps();

		$events = wordpoints_hooks()->get_sub_app( 'events' );

		wordpoints_bp_groups_hook_events_init( $events );

		$this->assertEventNotRegistered( 'bp_group_avatar_upload', array( 'bp_group', 'current:user' ) );
	}

	/**
	 * Test Groups events registration when group cover image uploads are disabled.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_groups_hook_events_init
	 */
	public function test_groups_events_group_cover_image_uploads_disabled() {

		add_filter( 'bp_disable_group_cover_image_uploads', '__return_true' );

		$this->mock_apps();

		$events = wordpoints_hooks()->get_sub_app( 'events' );

		wordpoints_bp_groups_hook_events_init( $events );

		$this->assertEventNotRegistered( 'bp_group_cover_image_upload', array( 'bp_group', 'current:user' ) );
	}

	/**
	 * Test the Groups component's delete group action splitting function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_groups_split_delete_group_action
	 */
	public function test_groups_split_delete_group_action() {

		$this->factory->bp = new BP_UnitTest_Factory();

		$group = $this->factory->bp->group->create_and_get();
		$user_ids = $this->factory->user->create_many( 2 );

		$mock = new WordPoints_PHPUnit_Mock_Filter();
		$mock->add_action( 'wordpoints_bp_groups_delete_group_remove_member', 10, 2 );

		wordpoints_bp_groups_split_delete_group_action( $group, $user_ids );

		$this->assertSame(
			array( array( $group, $user_ids[0] ), array( $group, $user_ids[1] ) )
			, $mock->calls
		);
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

		$this->assertTrue( $entities->is_registered( 'bp_activity' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity', 'date' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity', 'user' ) );

		$this->assertTrue( $entities->is_registered( 'bp_activity_update' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity_update', 'author' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity_update', 'content' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity_update', 'date_posted' ) );

		$this->assertTrue( $entities->is_registered( 'bp_activity_comment' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity_comment', 'activity' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity_comment', 'author' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity_comment', 'content' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity_comment', 'date_posted' ) );
		$this->assertTrue( $children->is_registered( 'bp_activity_comment', 'parent' ) );
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

		$this->assertTrue( $restrictions->is_registered( 'hidden', array( 'bp_activity' ) ) );
		$this->assertTrue( $restrictions->is_registered( 'spam', array( 'bp_activity' ) ) );

		$this->assertTrue( $restrictions->is_registered( 'hidden', array( 'bp_activity_update' ) ) );
		$this->assertTrue( $restrictions->is_registered( 'spam', array( 'bp_activity_update' ) ) );

		$this->assertTrue( $restrictions->is_registered( 'hidden', array( 'bp_activity_comment' ) ) );
		$this->assertTrue( $restrictions->is_registered( 'spam', array( 'bp_activity_comment' ) ) );
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

		$this->assertTrue( $actions->is_registered( 'bp_activity_comment_post' ) );
		$this->assertTrue( $actions->is_registered( 'bp_activity_comment_ham' ) );
		$this->assertTrue( $actions->is_registered( 'bp_activity_comment_spam' ) );
		$this->assertTrue( $actions->is_registered( 'bp_activity_comment_delete' ) );

		$this->assertTrue( $actions->is_registered( 'bp_activity_favorite' ) );
		$this->assertTrue( $actions->is_registered( 'bp_activity_defavorite' ) );
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
		$this->assertEventRegistered( 'bp_activity_comment_post', 'bp_activity_comment' );

		if ( version_compare( WORDPOINTS_VERSION, '2.3.0-alpha-1', '>' ) ) {
			$this->assertEventRegistered( 'bp_activity_favorite', array( 'bp_activity', 'user' ) );
		} else {
			$this->assertEventNotRegistered( 'bp_activity_favorite', array( 'bp_activity', 'user' ) );
		}
	}

	/**
	 * Test the Activity component's before delete action splitting function.
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

		$activity_comment = $this->factory->bp->activity->create_and_get(
			array( 'type' => 'activity_comment' )
		);

		$mock = new WordPoints_PHPUnit_Mock_Filter();
		$mock->add_action( 'wordpoints_bp_activity_before_delete_activity_update' );

		$mock_2 = new WordPoints_PHPUnit_Mock_Filter();
		$mock_2->add_action( 'wordpoints_bp_activity_before_delete_activity_comment' );

		wordpoints_bp_activity_split_before_delete_action(
			array( $activity_test, $activity_update, $activity_update_2, $activity_comment )
		);

		$this->assertSame(
			array( array( $activity_update ), array( $activity_update_2 ) )
			, $mock->calls
		);

		$this->assertSame( array( array( $activity_comment ) ), $mock_2->calls );
	}

	/**
	 * Test the xProfile component action registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_xprofile_hook_actions_init
	 */
	public function test_xprofile_actions() {

		$this->mock_apps();

		$actions = wordpoints_hooks()->get_sub_app( 'actions' );

		wordpoints_bp_xprofile_hook_actions_init( $actions );

		$this->assertTrue( $actions->is_registered( 'bp_xprofile_avatar_upload' ) );
		$this->assertTrue( $actions->is_registered( 'bp_xprofile_avatar_delete' ) );

		$this->assertTrue( $actions->is_registered( 'bp_xprofile_cover_image_upload' ) );
		$this->assertTrue( $actions->is_registered( 'bp_xprofile_cover_image_delete' ) );
	}

	/**
	 * Test the xProfile component events registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_xprofile_hook_events_init
	 */
	public function test_xprofile_events() {

		$this->mock_apps();

		$events = wordpoints_hooks()->get_sub_app( 'events' );

		wordpoints_bp_xprofile_hook_events_init( $events );

		$this->assertEventRegistered( 'bp_xprofile_avatar_upload', 'user' );

		if ( version_compare( buddypress()->version, '2.8.0-alpha', '>=' ) ) {
			$this->assertEventRegistered( 'bp_xprofile_cover_image_upload', 'user' );
		} else {
			$this->assertEventNotRegistered( 'bp_xprofile_cover_image_upload', 'user' );
		}
	}

	/**
	 * Test xProfile events registration when avatar uploads are disabled.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_groups_hook_events_init
	 */
	public function test_xprofile_events_avatar_uploads_disabled() {

		add_filter( 'bp_disable_avatar_uploads', '__return_true' );

		$this->mock_apps();

		$events = wordpoints_hooks()->get_sub_app( 'events' );

		wordpoints_bp_groups_hook_events_init( $events );

		$this->assertEventNotRegistered( 'bp_xprofile_avatar_upload', 'user' );
	}

	/**
	 * Test xProfile events registration when cover image uploads are disabled.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_bp_groups_hook_events_init
	 */
	public function test_xprofile_events_cover_image_uploads_disabled() {

		add_filter( 'bp_disable_cover_image_uploads', '__return_true' );

		$this->mock_apps();

		$events = wordpoints_hooks()->get_sub_app( 'events' );

		wordpoints_bp_groups_hook_events_init( $events );

		$this->assertEventNotRegistered( 'bp_xprofile_cover_image_upload', 'user' );
	}
}

// EOF
