<?php

/**
 * Activity update entity class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a BuddyPress activity update.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity_Update extends WordPoints_BP_Entity_Activity {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Activity Update', 'wordpoints-bp' );
	}
}

// EOF
