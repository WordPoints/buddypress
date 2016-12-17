<?php

/**
 * Activity update entity class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a BuddyPress activity update.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity_Update extends WordPoints_BP_Entity {

	/**
	 * @since 1.0.0
	 */
	protected $bp_component = 'activity';

	/**
	 * @since 1.0.0
	 */
	protected $id_field = 'id';

	/**
	 * @since 1.0.0
	 */
	protected function get_entity( $id ) {

		$entity = new BP_Activity_Activity( $id );

		// We check this instead of the ID because the ID is always set.
		// See https://buddypress.trac.wordpress.org/ticket/7394
		if ( ! $entity->component ) {
			return false;
		}

		return $entity;
	}

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Activity Update', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	protected function get_entity_human_id( $entity ) {

		// Based on bp_get_activity_latest_update().
		return trim(
			strip_tags(
				bp_create_excerpt(
					$entity->content
					, bp_activity_get_excerpt_length()
				)
			)
		);
	}

	/**
	 * @since 1.0.0
	 */
	public function get_the_id() {

		// See https://github.com/WordPoints/wordpoints/issues/556.
		$the_id = parent::get_the_id();

		if ( ! $the_id ) {
			return $the_id;
		}

		return (int) $the_id;
	}
}

// EOF
