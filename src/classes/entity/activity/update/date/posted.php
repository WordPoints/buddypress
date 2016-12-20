<?php

/**
 * Activity update posted date entity attribute.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents an activity update's posted date.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity_Update_Date_Posted
	extends WordPoints_BP_Entity_Activity_Date {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Date Posted', 'wordpoints-bp' );
	}
}

// EOF
