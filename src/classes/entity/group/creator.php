<?php

/**
 * Group creator entity relationship class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Defines the relationship between a group and the user who created it.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Group_Creator
	extends WordPoints_Entity_Relationship_Stored_Field {

	/**
	 * @since 1.0.0
	 */
	protected $storage_type = 'db';

	/**
	 * @since 1.0.0
	 */
	protected $primary_entity_slug = 'bp_group';

	/**
	 * @since 1.0.0
	 */
	protected $related_entity_slug = 'user';

	/**
	 * @since 1.0.0
	 */
	protected $related_ids_field = 'creator_id';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return _x( 'Creator', 'group entity', 'wordpoints-bp' );
	}
}

// EOF
