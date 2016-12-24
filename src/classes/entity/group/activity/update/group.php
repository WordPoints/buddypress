<?php

/**
 * Group activity update group entity relationship class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Defines the relationship between an activity update the group it relates to.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Group_Activity_Update_Group
	extends WordPoints_Entity_Relationship_Stored_Field {

	/**
	 * @since 1.0.0
	 */
	protected $storage_type = 'db';

	/**
	 * @since 1.0.0
	 */
	protected $primary_entity_slug = 'bp_group_activity_update';

	/**
	 * @since 1.0.0
	 */
	protected $related_entity_slug = 'bp_group';

	/**
	 * @since 1.0.0
	 */
	protected $related_ids_field = 'item_id';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return _x( 'Group', 'group activity update entity', 'wordpoints-bp' );
	}
}

// EOF
