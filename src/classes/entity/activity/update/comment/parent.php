<?php

/**
 * Activity update comment parent entity relationship class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Defines the relationship between an activity comment and its parent comment.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity_Update_Comment_Parent
	extends WordPoints_Entity_Relationship_Stored_Field {

	/**
	 * @since 1.0.0
	 */
	protected $storage_type = 'db';

	/**
	 * @since 1.0.0
	 */
	protected $primary_entity_slug = 'bp_activity_update_comment';

	/**
	 * @since 1.0.0
	 */
	protected $related_entity_slug = 'bp_activity_update_comment';

	/**
	 * @since 1.0.0
	 */
	protected $related_ids_field = 'secondary_item_id';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return _x( 'Parent Comment', 'activity update comment', 'wordpoints-bp' );
	}
}

// EOF
