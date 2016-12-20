<?php

/**
 * Activity update comment activity entity relationship class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Defines the relationship between a comment and the activity update it is on.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity_Update_Comment_Activity
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
	protected $related_entity_slug = 'bp_activity_update';

	/**
	 * @since 1.0.0
	 */
	protected $related_ids_field = 'item_id';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return _x( 'Activity Update', 'activity update comment', 'wordpoints-bp' );
	}
}

// EOF
