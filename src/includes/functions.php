<?php

/**
 * Functions of the module.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Register entities when the entities app is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-apps-entities
 *
 * @param WordPoints_App_Registry $entities The entities app.
 */
function wordpoints_bp_entities_init( $entities ) {

	$children = $entities->get_sub_app( 'children' );

	$entities->register( 'bp_message', 'WordPoints_BP_Entity_Message' );
	$children->register( 'bp_message', 'content', 'WordPoints_BP_Entity_Message_Content' );
	$children->register( 'bp_message', 'date_sent', 'WordPoints_BP_Entity_Message_Date_Sent' );
	$children->register( 'bp_message', 'recipients', 'WordPoints_BP_Entity_Message_Recipients' );
	$children->register( 'bp_message', 'sender', 'WordPoints_BP_Entity_Message_Sender' );
	$children->register( 'bp_message', 'subject', 'WordPoints_BP_Entity_Message_Subject' );
}

/**
 * Register hook actions when the action registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-actions
 *
 * @param WordPoints_Hook_Actions $actions The action registry.
 */
function wordpoints_bp_hook_actions_init( $actions ) {

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
 * Register hook events when the event registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-events
 *
 * @param WordPoints_Hook_Events $events The event registry.
 */
function wordpoints_bp_hook_events_init( $events ) {

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

// EOF
