<?php

/**
 * Action and filter hooks for this module.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

add_action( 'wordpoints_init_app_registry-apps-entities', 'wordpoints_bp_entities_init' );
add_action( 'wordpoints_init_app_registry-hooks-actions', 'wordpoints_bp_hook_actions_init' );
add_action( 'wordpoints_init_app_registry-hooks-events', 'wordpoints_bp_hook_events_init' );

// EOF
