<?php

/**
 * Activity update author entity relationship class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Defines the relationship between an activity update and the user who posted it.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity_Update_Author
	extends WordPoints_BP_Entity_Activity_User {

	/**
	 * @since 1.0.0
	 */
	protected $primary_entity_slug = 'bp_activity_update';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return _x( 'Author', 'activity update', 'wordpoints-bp' );
	}
}

// EOF
