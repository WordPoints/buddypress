<?php

/**
 * Group parent entity relationship class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Defines the relationship between a group and its parent group.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Group_Parent
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
	protected $related_entity_slug = 'bp_group';

	/**
	 * @since 1.0.0
	 */
	protected $related_ids_field = 'parent_id';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Parent', 'wordpoints-bp' );
	}
}

// EOF
