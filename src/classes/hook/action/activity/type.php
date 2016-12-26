<?php

/**
 * Activity update hook action class.
 *
 * @package WordPoints_BuddyPress
 * @since   1.0.0
 */

/**
 * Action that only fires for activity items that are status updates.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Action_Activity_Type extends WordPoints_Hook_Action {

	/**
	 * The type of activity to check for.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $activity_type = 'activity_update';

	/**
	 * @since 1.0.0
	 */
	public function __construct( $slug, array $action_args, array $args = array() ) {

		if ( isset( $args['activity_type'] ) ) {
			$this->activity_type = $args['activity_type'];
		}

		parent::__construct( $slug, $action_args, $args );
	}

	/**
	 * @since 1.0.0
	 */
	public function should_fire() {

		$activity = $this->get_arg_value( "bp_{$this->activity_type}" );

		if (
			! $activity instanceof BP_Activity_Activity
			&& ! is_object( $activity )
		) {
			$activity = new BP_Activity_Activity( $activity );
		}

		if ( $this->activity_type !== $activity->type ) {
			return false;
		}

		return parent::should_fire();
	}
}

// EOF
