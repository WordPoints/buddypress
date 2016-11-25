<?php

/**
 * Message thread accessible entity restriction class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Restriction rule for message threads.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Restriction_Message_Thread_Accessible
	implements WordPoints_Entity_RestrictionI {

	/**
	 * The ID of the entity this restriction relates to.
	 *
	 * @since 1.0.0
	 *
	 * @var int|string
	 */
	protected $entity_id;

	/**
	 * The thread ID.
	 *
	 * @since 1.0.0
	 *
	 * @var int
	 */
	protected $thread_id;

	/**
	 * @since 1.0.0
	 */
	public function __construct( $entity_id, array $hierarchy ) {

		$this->entity_id = $entity_id;
		$this->thread_id = $this->get_thread_id();
	}

	/**
	 * @since 1.0.0
	 */
	public function user_can( $user_id ) {

		// Moderators are allowed to view conversations.
		if ( bp_user_can( $user_id, 'bp_moderate' ) ) {
			return true;
		}

		if ( ! $this->thread_id ) {
			return false;
		}

		return (bool) messages_check_thread_access( $this->thread_id, $user_id );
	}

	/**
	 * @since 1.0.0
	 */
	public function applies() {
		return true; // Message threads are never public.
	}

	/**
	 * Get the ID of the message thread that this restriction relates to.
	 *
	 * @since 1.0.0
	 *
	 * @return int|false The ID of the thread, or false.
	 */
	protected function get_thread_id() {

		$message = new BP_Messages_Message( $this->entity_id );

		if ( ! $message->id ) {
			return false;
		}

		return $message->thread_id;
	}
}

// EOF
