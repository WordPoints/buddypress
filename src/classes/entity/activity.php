<?php

/**
 * Activity entity class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a BuddyPress activity item.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity extends WordPoints_BP_Entity {

	/**
	 * @since 1.0.0
	 */
	protected $bp_component = 'activity';

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
		return __( 'Activity', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	protected function get_entity_human_id( $entity ) {

		if ( empty( $entity->content ) ) {
			return $entity->action;
		}

		// Back-compat for BuddyPress <2.8.
		if ( function_exists( 'bp_activity_get_excerpt_length' ) ) {

			$excerpt_length = bp_activity_get_excerpt_length();

		} else {

			/**
			 * Filters the excerpt length for the activity excerpt.
			 *
			 * @param int $length Character length for activity excerpts.
			 */
			$excerpt_length = (int) apply_filters( 'bp_activity_excerpt_length', 358 );
		}

		// Based on bp_get_activity_latest_update().
		return trim(
			strip_tags( bp_create_excerpt( $entity->content, $excerpt_length ) )
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
