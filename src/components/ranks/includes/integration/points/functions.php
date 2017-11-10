<?php

/**
 * Functions for integrating the Points component with the BP Members component.
 *
 * @package WordPoints_BuddyPress
 * @since   1.0.0
 */

/**
 * Displays the rank stats on the Points members profile screen content.
 *
 * @since 1.0.0
 *
 * @param string $points_type The slug of the points type being displayed.
 */
function wordpoints_bp_ranks_points_members_profile_screen_content_stats( $points_type ) {

	$rank = wordpoints_bp_ranks_get_formatted_user_rank_for_points_type(
		bp_displayed_user_id()
		, $points_type
	);

	if ( ! $rank ) {
		return;
	}

	?>

	<div class="wordpoints-bp-member-profile-stat">
		<?php

		// translators: Rank name.
		echo wp_kses_post( sprintf( __( 'Rank: %s', 'wordpoints-bp' ), $rank ) );

		?>
	</div>

	<?php
}

/**
 * Displays the rank meta in the members profile header.
 *
 * @since 1.3.0
 *
 * @param string $points_type The slug of the points type being displayed.
 */
function wordpoints_bp_ranks_points_members_profile_header_meta( $points_type ) {

	$rank = wordpoints_bp_ranks_get_formatted_user_rank_for_points_type(
		bp_displayed_user_id()
		, $points_type
	);

	if ( ! $rank ) {
		return;
	}

	?>

	<div class="wordpoints-bp-member-profile-meta-item">
		<?php

		// translators: Rank name.
		echo wp_kses_post( sprintf( __( 'Rank: %s', 'wordpoints-bp' ), $rank ) );

		?>
	</div>

	<?php
}

/**
 * Gets the formatted rank for a points type for a user.
 *
 * @since 1.3.0
 *
 * @param int    $user_id     The ID of the user to get the rank of.
 * @param string $points_type The points type to get the rank for.
 *
 * @return string|false The formatted rank, or false on failure.
 */
function wordpoints_bp_ranks_get_formatted_user_rank_for_points_type(
	$user_id,
	$points_type
) {

	$rank_id = wordpoints_get_user_rank(
		$user_id
		, "points_type-$points_type"
	);

	if ( ! $rank_id ) {
		return false;
	}

	$rank = wordpoints_get_rank( $rank_id );

	if ( empty( $rank->name ) ) {
		return false;
	}

	$rank = wordpoints_get_formatted_user_rank(
		$user_id
		, "points_type-$points_type"
		, 'bp_members_profile_meta'
	);

	return $rank;
}

// EOF
