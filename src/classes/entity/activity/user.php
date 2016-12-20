<?php

/**
 * Activity user entity relationship class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Defines the relationship between an activity item and the user it relates to.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity_User
	extends WordPoints_Entity_Relationship_Stored_Field {

	/**
	 * @since 1.0.0
	 */
	protected $storage_type = 'db';

	/**
	 * @since 1.0.0
	 */
	protected $primary_entity_slug = 'bp_activity';

	/**
	 * @since 1.0.0
	 */
	protected $related_entity_slug = 'user';

	/**
	 * @since 1.0.0
	 */
	protected $related_ids_field = 'user_id';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return _x( 'User', 'activity entity', 'wordpoints-bp' );
	}
}

// EOF
