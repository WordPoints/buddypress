<?php

/**
 * Group activity update hook action class.
 *
 * @package WordPoints_BuddyPress
 * @since   1.0.0
 */

/**
 * Action that only fires for activity updates relating to the Groups component.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Action_Group_Activity_Update
	extends WordPoints_Hook_Action {

	/**
	 * @since 1.0.0
	 */
	public function should_fire() {

		$activity = $this->get_arg_value( 'bp_group_activity_update' );

		if (
			! $activity instanceof BP_Activity_Activity
			&& ! is_object( $activity )
		) {
			$activity = new BP_Activity_Activity( $activity );
		}

		if (
			'groups' !== $activity->component
			|| 'activity_update' !== $activity->type
		) {
			return false;
		}

		return parent::should_fire();
	}
}

// EOF
