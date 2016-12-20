<?php

/**
 * Activity update comment entity class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a BuddyPress activity update comment.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity_Update_Comment
	extends WordPoints_BP_Entity_Activity_Update {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Activity Update Comment', 'wordpoints-bp' );
	}
}

// EOF
