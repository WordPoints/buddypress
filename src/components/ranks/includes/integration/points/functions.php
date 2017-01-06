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

	?>

	<div class="wordpoints-bp-member-profile-stat">
		<?php

		echo wp_kses_post(
			sprintf(
				// translators: Rank name.
				__( 'Rank: %s', 'wordpoints-bp' )
				, wordpoints_get_formatted_user_rank(
					bp_displayed_user_id()
					, "points_type-$points_type"
					, 'bp_members_profile'
				)
			)
		);

		?>
	</div>

	<?php
}

// EOF
