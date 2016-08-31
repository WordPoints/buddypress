<?php

/**
 * Message recipients entity relationship class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Defines the relationship between a message and its recipients.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Message_Recipients
	extends WordPoints_Entity_Relationship
	implements WordPoints_Entityish_StoredI {

	/**
	 * @since 1.0.0
	 */
	protected $primary_entity_slug = 'bp_message';

	/**
	 * @since 1.0.0
	 */
	protected $related_entity_slug = 'user{}';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Recipients', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	protected function get_related_entity_ids( WordPoints_Entity $entity ) {

		$message = new BP_Messages_Message( $entity->get_the_id() );

		if ( ! $message->id ) {
			return false;
		}

		return $message->get_recipients();
	}

	/**
	 * @since 1.0.0
	 */
	public function get_storage_info() {

		return array(
			'type' => 'db',
			'info' => array(
				'type'             => 'table',
				'table_name'       => buddypress()->messages->table_name_recipients,
				'primary_id_field' => 'thread_id',
				'related_id_field' => 'user_id',
			),
		);
	}
}

// EOF
