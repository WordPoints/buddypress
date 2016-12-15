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

// EOF
