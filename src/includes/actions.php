<?php

/**
 * Action and filter hooks for this extension.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

if ( function_exists( 'bp_is_active' ) ) {

	if ( bp_is_active( 'messages' ) ) {

		add_action( 'wordpoints_init_app_registry-apps-entities', 'wordpoints_bp_messages_entities_init' );
		add_action( 'wordpoints_init_app_registry-entities-restrictions-know', 'wordpoints_bp_messages_entity_restrictions_know_init' );
		add_action( 'wordpoints_init_app_registry-hooks-actions', 'wordpoints_bp_messages_hook_actions_init' );
		add_action( 'wordpoints_init_app_registry-hooks-events', 'wordpoints_bp_messages_hook_events_init' );
	}

	if ( bp_is_active( 'friends' ) ) {

		add_action( 'wordpoints_init_app_registry-apps-entities', 'wordpoints_bp_friends_entities_init' );
		add_action( 'wordpoints_init_app_registry-hooks-actions', 'wordpoints_bp_friends_hook_actions_init' );
		add_action( 'wordpoints_init_app_registry-hooks-events', 'wordpoints_bp_friends_hook_events_init' );
	}

	if ( bp_is_active( 'groups' ) ) {

		add_action( 'wordpoints_init_app_registry-apps-entities', 'wordpoints_bp_groups_entities_init' );
		add_action( 'wordpoints_init_app_registry-entities-restrictions-know', 'wordpoints_bp_groups_entity_restrictions_know_init' );
		add_action( 'wordpoints_init_app_registry-hooks-actions', 'wordpoints_bp_groups_hook_actions_init' );
		add_action( 'wordpoints_init_app_registry-hooks-events', 'wordpoints_bp_groups_hook_events_init' );

		add_action( 'bp_groups_delete_group', 'wordpoints_bp_groups_split_delete_group_action', 10, 2 );
	}

	if ( bp_is_active( 'activity' ) ) {

		add_action( 'wordpoints_init_app_registry-apps-entities', 'wordpoints_bp_activity_entities_init' );
		add_action( 'wordpoints_init_app_registry-entities-restrictions-know', 'wordpoints_bp_activity_entity_restrictions_know_init' );
		add_action( 'wordpoints_init_app_registry-hooks-actions', 'wordpoints_bp_activity_hook_actions_init' );
		add_action( 'wordpoints_init_app_registry-hooks-events', 'wordpoints_bp_activity_hook_events_init' );

		add_action( 'bp_activity_before_delete', 'wordpoints_bp_activity_split_before_delete_action' );
	}

	if ( bp_is_active( 'xprofile' ) ) {

		add_action( 'wordpoints_init_app_registry-hooks-actions', 'wordpoints_bp_xprofile_hook_actions_init' );
		add_action( 'wordpoints_init_app_registry-hooks-events', 'wordpoints_bp_xprofile_hook_events_init' );

		add_filter( 'bp_core_pre_avatar_handle_crop', 'WordPoints_BP_Hook_Action_Avatar_Set::set_has_avatar', 10, 2 );
		add_filter( 'bp_attachments_pre_cover_image_ajax_upload', 'WordPoints_BP_Hook_Action_Cover_Image_Set::set_has_cover_image', 10, 2 );
	}

} // End if ( BuddyPress installed ).

// EOF
