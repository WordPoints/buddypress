<?php

/**
 * Friendship entity class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a BuddyPress friendship.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Friendship extends WordPoints_BP_Entity {

	/**
	 * @since 1.0.0
	 */
	protected $bp_component = 'friends';

	/**
	 * @since 1.0.0
	 */
	protected $id_field = 'id';

	/**
	 * @since 1.0.0
	 */
	protected function get_entity( $id ) {

		$entity = new BP_Friends_Friendship( $id );

		if ( ! $entity->id ) {
			return false;
		}

		return $entity;
	}

	/**
	 * @since 1.0.0
	 */
	protected function get_entity_human_id( $entity ) {

		return sprintf(
			// translators: 1: initiator's display name, 2: friend's display name.
			_x( '%1$s + %2$s', 'friendship', 'wordpoints-bp' )
			, bp_core_get_user_displayname( $entity->initiator_user_id )
			, bp_core_get_user_displayname( $entity->friend_user_id )
		);
	}

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Friendship', 'wordpoints-bp' );
	}
}

// EOF
