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

// EOF
