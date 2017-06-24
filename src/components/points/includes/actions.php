<?php

/**
 * Action and filter hooks for the points component-related code.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

add_action( 'bp_setup_nav', 'wordpoints_bp_points_members_profile_nav' );
add_action( 'wordpoints_bp_points_members_profile_screen_content', 'wordpoints_bp_points_members_profile_screen_content_stats' );
add_action( 'wordpoints_bp_points_members_profile_screen_content', 'wordpoints_bp_points_members_profile_screen_content_logs' );

add_filter( 'wordpoints_points_logs_table_username', 'wordpoints_bp_points_members_get_profile_link', 10, 2 );
add_filter( 'wordpoints_points_top_users_username', 'wordpoints_bp_points_members_get_profile_link', 10, 2 );

// EOF
