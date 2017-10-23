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
class WordPoints_BP_Entity_Activity_Update extends WordPoints_BP_Entity_Activity {

	/**
	 * @since 1.2.1
	 */
	protected $bp_activity_type = 'activity_update';

	/**
	 * @since 1.2.1
	 */
	protected $bp_activity_component = 'activity';

	/**
	 * @since 1.2.1
	 */
	public function __construct( $slug ) {

		if ( false !== strpos( $slug, 'group' ) ) {
			$this->bp_activity_component = 'groups';
		}

		parent::__construct( $slug );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Activity Update', 'wordpoints-bp' );
	}
}

// EOF
