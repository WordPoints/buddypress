<?php

/**
 * Message sender entity relationship class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Defines the relationship between a message and the sender.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Message_Sender
	extends WordPoints_Entity_Relationship_Stored_Field {

	/**
	 * @since 1.0.0
	 */
	protected $storage_type = 'db';

	/**
	 * @since 1.0.0
	 */
	protected $primary_entity_slug = 'bp_message';

	/**
	 * @since 1.0.0
	 */
	protected $related_entity_slug = 'user';

	/**
	 * @since 1.0.0
	 */
	protected $related_ids_field = 'sender_id';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Sender', 'wordpoints-bp' );
	}
}

// EOF
