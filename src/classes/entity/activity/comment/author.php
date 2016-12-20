<?php

/**
 * Activity comment author entity relationship class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Defines the relationship between an activity comment and the user who posted it.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity_Comment_Author
	extends WordPoints_BP_Entity_Activity_User {

	/**
	 * @since 1.0.0
	 */
	protected $primary_entity_slug = 'bp_activity_comment';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return _x( 'Author', 'activity comment entity', 'wordpoints-bp' );
	}
}

// EOF
