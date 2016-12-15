<?php

/**
 * Group entity class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a BuddyPress group.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Group extends WordPoints_BP_Entity {

	/**
	 * @since 1.0.0
	 */
	protected $bp_component = 'groups';

	/**
	 * @since 1.0.0
	 */
	protected $id_field = 'id';

	/**
	 * @since 1.0.0
	 */
	protected $human_id_field = 'name';

	/**
	 * @since 1.0.0
	 */
	protected function get_entity( $id ) {

		$entity = groups_get_group( $id );

		if ( ! $entity->id ) {
			return false;
		}

		return $entity;
	}

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Group', 'wordpoints-bp' );
	}
}

// EOF
