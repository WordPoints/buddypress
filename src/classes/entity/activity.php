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
	 * The activity type this object represents.
	 *
	 * Leaving this unset means that it represents any type of activity.
	 *
	 * @since 1.2.1
	 *
	 * @var string
	 */
	protected $bp_activity_type;

	/**
	 * The component that the activity this object represents is from.
	 *
	 * Leaving this unset means that it can be from any component.
	 *
	 * @since 1.2.0
	 *
	 * @var string
	 */
	protected $bp_activity_component;

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
			$excerpt_length = (int) apply_filters( 'bp_activity_excerpt_length', 358 ); // WPCS: prefix OK.
		}

		// Based on bp_get_activity_latest_update().
		return trim(
			strip_tags( bp_create_excerpt( $entity->content, $excerpt_length ) )
		);
	}

	/**
	 * @since 1.2.1
	 */
	public function get_storage_info() {

		$storage_info = parent::get_storage_info();

		if ( isset( $this->bp_activity_component ) ) {
			$storage_info['info']['conditions'][] = array(
				'field' => 'component',
				'value' => $this->bp_activity_component,
			);
		}

		if ( isset( $this->bp_activity_type ) ) {
			$storage_info['info']['conditions'][] = array(
				'field' => 'type',
				'value' => $this->bp_activity_type,
			);
		}

		return $storage_info;
	}
}

// EOF
