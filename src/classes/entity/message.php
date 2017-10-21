<?php

/**
 * Message entity class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a BuddyPress message.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Message extends WordPoints_BP_Entity {

	/**
	 * @since 1.0.0
	 */
	protected $bp_component = 'messages';

	/**
	 * @since 1.0.0
	 */
	protected $bp_component_table_name = 'messages';

	/**
	 * @since 1.0.0
	 */
	protected $id_field = 'id';

	/**
	 * @since 1.2.1
	 */
	protected $id_is_int = true;

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
		return _x( 'Message', 'message entity', 'wordpoints-bp' );
	}
}

// EOF
