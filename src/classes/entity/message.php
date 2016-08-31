<?php

/**
 * Message hook entity.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a BuddyPress message.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Message
	extends WordPoints_Entity
	implements WordPoints_Entityish_StoredI,
		WordPoints_Entity_Restricted_VisibilityI {

	/**
	 * @since 1.0.0
	 */
	protected $id_field = 'id';

	/**
	 * @since 1.0.0
	 */
	protected $human_id_field = 'subject';

	/**
	 * @since 1.0.0
	 */
	protected function get_entity( $id ) {

		$entity = new BP_Messages_Message( $id );

		if ( ! $entity->id ) {
			return false;
		}

		return $entity;
	}

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Message', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_storage_info() {
		return array(
			'type' => 'db',
			'info' => array(
				'type'       => 'table',
				'table_name' => buddypress()->messages->table_name_messages,
			),
		);
	}

	/**
	 * @since 1.0.0
	 */
	public function user_can_view( $user_id, $id ) {

		$message = $this->get_entity( $id );

		if ( ! $message ) {
			return false;
		}

		// Moderators are allowed to view conversations.
		if ( bp_user_can( $user_id, 'bp_moderate' ) ) {
			return true;
		}

		return (bool) messages_check_thread_access( $message->thread_id, $user_id );
	}
}

// EOF
