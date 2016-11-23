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
	$children->register( 'bp_friendship', 'initiator', 'WordPoints_BP_Entity_Friendship_Initiator');
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

// EOF
