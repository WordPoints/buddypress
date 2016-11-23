<?php

/**
 * Friendship initiator entity relationship class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Defines the relationship between a friendship and the initiator.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Friendship_Initiator
	extends WordPoints_Entity_Relationship_Stored_Field {

	/**
	 * @since 1.0.0
	 */
	protected $storage_type = 'db';

	/**
	 * @since 1.0.0
	 */
	protected $primary_entity_slug = 'bp_friendship';

	/**
	 * @since 1.0.0
	 */
	protected $related_entity_slug = 'user';

	/**
	 * @since 1.0.0
	 */
	protected $related_ids_field = 'initiator_user_id';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Initiator', 'wordpoints-bp' );
	}
}

// EOF
