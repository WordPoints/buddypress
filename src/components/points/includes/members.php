<?php

/**
 * Functions for integrating the Points component with the BP Members component.
 *
 * @package WordPoints_BuddyPress
 * @since   1.0.0
 */

/**
 * Register the member profile nav items for the points component.
 *
 * @since 1.0.0
 */
function wordpoints_bp_points_members_profile_nav() {

	$bp = buddypress();

	$points_types = wordpoints_get_points_types();

	bp_core_new_nav_item(
		array(
			'name'                => _x( 'Points', 'BuddyPress member profile nav item', 'wordpoints-bp' ),
			'slug'                => 'points',
			'default_subnav_slug' => key( $points_types ),
			'screen_function'     => 'wordpoints_bp_points_members_profile_screen',
			'parent_url'          => $bp->displayed_user->domain,
			'parent_slug'         => $bp->profile->slug,
		)
		, 'members'
	);

	foreach ( $points_types as $slug => $points_type ) {

		bp_core_new_subnav_item(
			array(
				'slug'            => $slug,
				'name'            => $points_type['name'],
				'screen_function' => 'wordpoints_bp_points_members_profile_screen',
				'parent_url'      => bp_displayed_user_domain() . 'points/',
				'parent_slug'     => 'points',
			)
			, 'members'
		);
	}
}

/**
 * Loads the Points member profile screen.
 *
 * @since 1.0.0
 */
function wordpoints_bp_points_members_profile_screen() {

	add_action(
		'bp_template_content'
		, 'wordpoints_bp_points_members_profile_screen_content'
	);

	bp_core_load_template(
		apply_filters( 'bp_core_template_plugin', 'members/single/plugins' )
	);
}

/**
 * Displays the Points members profile screen content.
 *
 * @since 1.0.0
 */
function wordpoints_bp_points_members_profile_screen_content() {

	$points_type = bp_current_action();

	/**
	 * Fires to display the Points screen on the member profile.
	 *
	 * @since 1.0.0
	 *
	 * @param string $points_type The slug of the points type being displayed.
	 */
	do_action( 'wordpoints_bp_points_members_profile_screen_content', $points_type );
}

/**
 * Displays the stats on the Points members profile screen.
 *
 * @since 1.0.0
 *
 * @param string $points_type The slug of the points type being displayed.
 */
function wordpoints_bp_points_members_profile_screen_content_stats( $points_type ) {

	/**
	 * Fires before the stats are displayed on the Points screen on the member profile.
	 *
	 * @since 1.0.0
	 *
	 * @param string $points_type The slug of the points type being displayed.
	 */
	do_action( 'wordpoints_bp_points_members_profile_screen_before_stats', $points_type );

	?>

	<div class="wordpoints-bp-member-profile-stats">

		<div class="wordpoints-bp-member-profile-stat">
			<?php

			echo esc_html(
				sprintf(
					__( '%1$s: %2$s', 'wordpoints-bp' )
					, wordpoints_get_points_type_setting( $points_type, 'name' )
					, wordpoints_get_formatted_points(
						bp_displayed_user_id()
						, $points_type
						, 'bp_members_profile'
					)
				)
			);

			?>
		</div>

		<?php

		/**
		 * Fires when the stats are displayed on the Points screen on the member profile.
		 *
		 * @since 1.0.0
		 *
		 * @param string $points_type The slug of the points type being displayed.
		 */
		do_action( 'wordpoints_bp_points_members_profile_screen_stats', $points_type );

		?>

	</div>

	<?php

	/**
	 * Fires after the stats are displayed on the Points screen on the member profile.
	 *
	 * @since 1.0.0
	 *
	 * @param string $points_type The slug of the points type being displayed.
	 */
	do_action( 'wordpoints_bp_points_members_profile_screen_after_stats', $points_type );
}

/**
 * Displays the points logs on the Points members profile screen.
 *
 * @since 1.0.0
 *
 * @param string $points_type The slug of the points type being displayed.
 */
function wordpoints_bp_points_members_profile_screen_content_logs( $points_type ) {

	/**
	 * Fires before the logs are displayed on the Points screen on the member profile.
	 *
	 * @since 1.0.0
	 *
	 * @param string $points_type The slug of the points type being displayed.
	 */
	do_action( 'wordpoints_bp_points_members_profile_screen_before_logs', $points_type );

	$query = new WordPoints_Points_Logs_Query(
		array(
			'user_id' => bp_displayed_user_id(),
			'points_type' => $points_type,
		)
	);

	wordpoints_show_points_logs( $query, array( 'show_users' => false ) );

	/**
	 * Fires after the logs are displayed on the Points screen on the member profile.
	 *
	 * @since 1.0.0
	 *
	 * @param string $points_type The slug of the points type being displayed.
	 */
	do_action( 'wordpoints_bp_points_members_profile_screen_after_logs', $points_type );
}

// EOF
