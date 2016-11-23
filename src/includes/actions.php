<?php

/**
 * Action and filter hooks for this module.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

if ( function_exists( 'bp_is_active' ) ) {

	if ( bp_is_active( 'messages' ) ) {

		add_action( 'wordpoints_init_app_registry-apps-entities', 'wordpoints_bp_messages_entities_init' );
		add_action( 'wordpoints_init_app_registry-hooks-actions', 'wordpoints_bp_messages_hook_actions_init' );
		add_action( 'wordpoints_init_app_registry-hooks-events', 'wordpoints_bp_messages_hook_events_init' );
	}

	if ( bp_is_active( 'friends' ) ) {

		add_action( 'wordpoints_init_app_registry-apps-entities', 'wordpoints_bp_friends_entities_init' );
		add_action( 'wordpoints_init_app_registry-hooks-actions', 'wordpoints_bp_friends_hook_actions_init' );
		add_action( 'wordpoints_init_app_registry-hooks-events', 'wordpoints_bp_friends_hook_events_init' );
	}
}

// EOF
