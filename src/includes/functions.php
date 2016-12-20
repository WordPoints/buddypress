<?php

/**
 * Functions of the module.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

//
// Messages Component.
//

/**
 * Register entities for the Messages component when the entities app is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-apps-entities
 *
 * @param WordPoints_App_Registry $entities The entities app.
 */
function wordpoints_bp_messages_entities_init( $entities ) {

	$children = $entities->get_sub_app( 'children' );

	$entities->register( 'bp_message', 'WordPoints_BP_Entity_Message' );
	$children->register( 'bp_message', 'content', 'WordPoints_BP_Entity_Message_Content' );
	$children->register( 'bp_message', 'date_sent', 'WordPoints_BP_Entity_Message_Date_Sent' );
	$children->register( 'bp_message', 'recipients', 'WordPoints_BP_Entity_Message_Recipients' );
	$children->register( 'bp_message', 'sender', 'WordPoints_BP_Entity_Message_Sender' );
	$children->register( 'bp_message', 'subject', 'WordPoints_BP_Entity_Message_Subject' );
}

/**
 * Register entity "know" restrictions for the Messages component.
 *
 * These are entities that are totally restricted, so that when the restriction
 * applies, the user is not even allowed to know that such an object exists.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-entities-restrictions-know
 *
 * @param WordPoints_Class_Registry_Deep_Multilevel $restrictions The restrictions
 *                                                                registry.
 */
function wordpoints_bp_messages_entity_restrictions_know_init( $restrictions ) {

	$restrictions->register(
		'thread_accessible'
		, array( 'bp_message' )
		, 'WordPoints_BP_Entity_Restriction_Message_Thread_Accessible'
	);
}

/**
 * Register hook actions for the Messages component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-actions
 *
 * @param WordPoints_Hook_Actions $actions The action registry.
 */
function wordpoints_bp_messages_hook_actions_init( $actions ) {

	$actions->register(
		'bp_message_send'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'messages_message_sent',
			'data'   => array(
				'arg_index' => array( 'bp_message' => 0 ),
			),
		)
	);
}

/**
 * Register hook events for the Messages component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-events
 *
 * @param WordPoints_Hook_Events $events The event registry.
 */
function wordpoints_bp_messages_hook_events_init( $events ) {

	$events->register(
		'bp_message_send'
		, 'WordPoints_BP_Hook_Event_Message_Send'
		, array(
			'actions' => array(
				// There is no "unsend" feature at present, so we don't register any
				// toggle_off actions. Unsending is different than deleting a sent
				// message, since the message won't be deleted for the recipient, so
				// the original action isn't really reversed.
				'toggle_on'  => 'bp_message_send',
			),
			'args' => array(
				'bp_message' => 'WordPoints_Hook_Arg',
			),
		)
	);
}

//
// Friends Component.
//

/**
 * Register entities for the Friends component when the entities app is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-apps-entities
 *
 * @param WordPoints_App_Registry $entities The entities app.
 */
function wordpoints_bp_friends_entities_init( $entities ) {

	$children = $entities->get_sub_app( 'children' );

	$entities->register( 'bp_friendship', 'WordPoints_BP_Entity_Friendship' );
	$children->register( 'bp_friendship', 'date_created', 'WordPoints_BP_Entity_Friendship_Date_Created' );
	$children->register( 'bp_friendship', 'friend', 'WordPoints_BP_Entity_Friendship_Friend' );
	$children->register( 'bp_friendship', 'initiator', 'WordPoints_BP_Entity_Friendship_Initiator' );
}

/**
 * Register hook actions for the Friends component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-actions
 *
 * @param WordPoints_Hook_Actions $actions The action registry.
 */
function wordpoints_bp_friends_hook_actions_init( $actions ) {

	$actions->register(
		'bp_friendship_request'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'friends_friendship_requested',
			'data'   => array(
				// 0 is the ID, but 3 gives us the object itself.
				'arg_index' => array( 'bp_friendship' => 3 ),
			),
		)
	);

	$actions->register(
		'bp_friendship_withdraw'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'friends_friendship_withdrawn',
			'data'   => array(
				// 0 is the ID, but 1 gives us the object itself.
				'arg_index' => array( 'bp_friendship' => 1 ),
			),
		)
	);

	$actions->register(
		'bp_friendship_accept'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'friends_friendship_accepted',
			'data'   => array(
				// 0 is the ID, but 3 gives us the object itself.
				'arg_index' => array( 'bp_friendship' => 3 ),
			),
		)
	);

	$actions->register(
		'bp_friendship_delete'
		, 'WordPoints_Hook_Action'
		, array(
			// Despite the name, it fires before delete.
			'action' => 'friends_friendship_deleted',
			'data'   => array(
				'arg_index' => array( 'bp_friendship' => 0 ),
			),
		)
	);
}

/**
 * Register hook events for the Friends component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-events
 *
 * @param WordPoints_Hook_Events $events The event registry.
 */
function wordpoints_bp_friends_hook_events_init( $events ) {

	$events->register(
		'bp_friendship_request'
		, 'WordPoints_BP_Hook_Event_Friendship_Request'
		, array(
			'actions' => array(
				'toggle_on'  => 'bp_friendship_request',
				'toggle_off' => 'bp_friendship_withdraw',
			),
			'args' => array(
				'bp_friendship' => 'WordPoints_Hook_Arg',
			),
		)
	);

	$events->register(
		'bp_friendship_accept'
		, 'WordPoints_BP_Hook_Event_Friendship_Accept'
		, array(
			'actions' => array(
				'toggle_on'  => 'bp_friendship_accept',
				'toggle_off' => 'bp_friendship_delete',
			),
			'args' => array(
				'bp_friendship' => 'WordPoints_Hook_Arg',
			),
		)
	);
}

//
// Groups Component.
//

/**
 * Register entities for the Groups component when the entities app is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-apps-entities
 *
 * @param WordPoints_App_Registry $entities The entities app.
 */
function wordpoints_bp_groups_entities_init( $entities ) {

	$children = $entities->get_sub_app( 'children' );

	$entities->register( 'bp_group', 'WordPoints_BP_Entity_Group' );
	$children->register( 'bp_group', 'creator', 'WordPoints_BP_Entity_Group_Creator' );
	$children->register( 'bp_group', 'date_created', 'WordPoints_BP_Entity_Group_Date_Created' );
	$children->register( 'bp_group', 'description', 'WordPoints_BP_Entity_Group_Description' );
	$children->register( 'bp_group', 'name', 'WordPoints_BP_Entity_Group_Name' );
	$children->register( 'bp_group', 'parent', 'WordPoints_BP_Entity_Group_Parent' );
	$children->register( 'bp_group', 'slug', 'WordPoints_BP_Entity_Group_Slug' );
	$children->register( 'bp_group', 'status', 'WordPoints_BP_Entity_Group_Status' );
}

/**
 * Register entity "know" restrictions for the Groups component.
 *
 * These are entities that are totally restricted, so that when the restriction
 * applies, the user is not even allowed to know that such an object exists.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-entities-restrictions-know
 *
 * @param WordPoints_Class_Registry_Deep_Multilevel $restrictions The restrictions
 *                                                                registry.
 */
function wordpoints_bp_groups_entity_restrictions_know_init( $restrictions ) {

	$restrictions->register(
		'status_nonpublic'
		, array( 'bp_group' )
		, 'WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic'
	);
}

/**
 * Register hook actions for the Groups component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-actions
 *
 * @param WordPoints_Hook_Actions $actions The action registry.
 */
function wordpoints_bp_groups_hook_actions_init( $actions ) {

	$actions->register(
		'bp_group_create'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_create_group',
			'data'   => array(
				// 0 is the ID, but 2 gives us the object itself.
				'arg_index' => array( 'bp_group' => 2 ),
			),
		)
	);

	$actions->register(
		'bp_group_delete'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_before_delete_group',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0 ),
			),
		)
	);
}

/**
 * Register hook events for the Groups component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-events
 *
 * @param WordPoints_Hook_Events $events The event registry.
 */
function wordpoints_bp_groups_hook_events_init( $events ) {

	$events->register(
		'bp_group_create'
		, 'WordPoints_BP_Hook_Event_Group_Create'
		, array(
			'actions' => array(
				'toggle_on'  => 'bp_group_create',
				'toggle_off' => 'bp_group_delete',
			),
			'args' => array(
				'bp_group' => 'WordPoints_Hook_Arg',
			),
		)
	);
}

//
// Activity Component.
//

/**
 * Register entities for the Activity component when the entities app is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-apps-entities
 *
 * @param WordPoints_App_Registry $entities The entities app.
 */
function wordpoints_bp_activity_entities_init( $entities ) {

	$children = $entities->get_sub_app( 'children' );

	$entities->register( 'bp_activity_update', 'WordPoints_BP_Entity_Activity_Update' );
	$children->register( 'bp_activity_update', 'author', 'WordPoints_BP_Entity_Activity_Update_Author' );
	$children->register( 'bp_activity_update', 'content', 'WordPoints_BP_Entity_Activity_Update_Content' );
	$children->register( 'bp_activity_update', 'date_posted', 'WordPoints_BP_Entity_Activity_Update_Date_Posted' );

	$entities->register( 'bp_activity_update_comment', 'WordPoints_BP_Entity_Activity_Update_Comment' );
	$children->register( 'bp_activity_update_comment', 'activity', 'WordPoints_BP_Entity_Activity_Update_Comment_Activity' );
	$children->register( 'bp_activity_update_comment', 'author', 'WordPoints_BP_Entity_Activity_Update_Author' );
	$children->register( 'bp_activity_update_comment', 'content', 'WordPoints_BP_Entity_Activity_Update_Content' );
	$children->register( 'bp_activity_update_comment', 'date_posted', 'WordPoints_BP_Entity_Activity_Update_Date_Posted' );
	$children->register( 'bp_activity_update_comment', 'parent', 'WordPoints_BP_Entity_Activity_Update_Comment_Parent' );
}

/**
 * Register entity "know" restrictions for the Activity component.
 *
 * These are entities that are totally restricted, so that when the restriction
 * applies, the user is not even allowed to know that such an object exists.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-entities-restrictions-know
 *
 * @param WordPoints_Class_Registry_Deep_Multilevel $restrictions The restrictions
 *                                                                registry.
 */
function wordpoints_bp_activity_entity_restrictions_know_init( $restrictions ) {

	$restrictions->register(
		'hidden'
		, array( 'bp_activity_update' )
		, 'WordPoints_BP_Entity_Restriction_Activity_Hidden'
	);

	$restrictions->register(
		'spam'
		, array( 'bp_activity_update' )
		, 'WordPoints_BP_Entity_Restriction_Activity_Spam'
	);

	$restrictions->register(
		'hidden'
		, array( 'bp_activity_update_comment' )
		, 'WordPoints_BP_Entity_Restriction_Activity_Hidden'
	);

	$restrictions->register(
		'spam'
		, array( 'bp_activity_update_comment' )
		, 'WordPoints_BP_Entity_Restriction_Activity_Spam'
	);
}

/**
 * Register hook actions for the Activity component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-actions
 *
 * @param WordPoints_Hook_Actions $actions The action registry.
 */
function wordpoints_bp_activity_hook_actions_init( $actions ) {

	// Activity update.
	$actions->register(
		'bp_activity_update_post'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'bp_activity_posted_update',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update' => 2 ),
			),
		)
	);

	$actions->register(
		'bp_activity_update_spam'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'bp_activity_mark_as_spam',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_activity_update_ham'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'bp_activity_mark_as_ham',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update' => 2 ),
			),
		)
	);

	$actions->register(
		'bp_activity_update_delete'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'wordpoints_bp_activity_before_delete_activity_update',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update' => 0 ),
			),
		)
	);

	// Activity update comment.
	$actions->register(
		'bp_activity_update_comment_post'
		, 'WordPoints_BP_Hook_Action_Activity_Update_Comment'
		, array(
			'action' => 'bp_activity_comment_posted',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update_comment' => 0 ),
			),
		)
	);

	// See https://github.com/WordPoints/wordpoints/issues/592.
	wordpoints_hooks()->get_sub_app( 'router' )->add_action(
		'bp_activity_update_comment_post'
		, array(
			'action' => 'bp_activity_comment_posted_notification_skipped',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update_comment' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_activity_update_comment_spam'
		, 'WordPoints_BP_Hook_Action_Activity_Update_Comment'
		, array(
			'action' => 'bp_activity_mark_as_spam',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update_comment' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_activity_update_comment_ham'
		, 'WordPoints_BP_Hook_Action_Activity_Update_Comment'
		, array(
			'action' => 'bp_activity_mark_as_ham',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update_comment' => 2 ),
			),
		)
	);

	$actions->register(
		'bp_activity_update_comment_delete'
		, 'WordPoints_BP_Hook_Action_Activity_Update_Comment'
		, array(
			'action' => 'wordpoints_bp_activity_before_delete_activity_comment',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update_comment' => 0 ),
			),
		)
	);
}

/**
 * Register hook events for the Activity component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-events
 *
 * @param WordPoints_Hook_Events $events The event registry.
 */
function wordpoints_bp_activity_hook_events_init( $events ) {

	$events->register(
		'bp_activity_update_post'
		, 'WordPoints_BP_Hook_Event_Activity_Update_Post'
		, array(
			'actions' => array(
				'toggle_on'  => array(
					'bp_activity_update_post',
					'bp_activity_update_ham',
				),
				'toggle_off' => array(
					'bp_activity_update_delete',
					'bp_activity_update_spam',
				),
			),
			'args' => array(
				'bp_activity_update' => 'WordPoints_Hook_Arg',
			),
		)
	);

	$events->register(
		'bp_activity_update_comment_post'
		, 'WordPoints_BP_Hook_Event_Activity_Update_Comment_Post'
		, array(
			'actions' => array(
				'toggle_on'  => array(
					'bp_activity_update_comment_post',
					'bp_activity_update_comment_ham',
				),
				'toggle_off' => array(
					'bp_activity_update_comment_delete',
					'bp_activity_update_comment_spam',
				),
			),
			'args' => array(
				'bp_activity_update_comment' => 'WordPoints_Hook_Arg',
			),
		)
	);
}

/**
 * Splits the 'bp_activity_before_delete' action by for each activity individually.
 *
 * @since 1.0.0
 *
 * @WordPress\action bp_activity_before_delete
 *
 * @param object[] $activities The activities being deleted.
 */
function wordpoints_bp_activity_split_before_delete_action( $activities ) {

	foreach ( $activities as $activity ) {

		if ( 'activity_update' === $activity->type ) {

			/**
			 * Fires for an activity update before it is deleted.
			 *
			 * @since 1.0.0
			 *
			 * @param object $activity The activity object.
			 */
			do_action(
				'wordpoints_bp_activity_before_delete_activity_update'
				, $activity
			);

		} elseif ( 'activity_comment' === $activity->type ) {

			/**
			 * Fires for an activity comment before it is deleted.
			 *
			 * @since 1.0.0
			 *
			 * @param object $activity The activity object.
			 */
			do_action(
				'wordpoints_bp_activity_before_delete_activity_comment'
				, $activity
			);
		}
	}
}

// EOF
