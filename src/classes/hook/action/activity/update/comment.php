<?php

/**
 * Activity update comment hook action class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents an action that should only fire for comments on activity updates.
 *
 * Comments can be left on all different kinds of activity items, but this action
 * only fires if the comment is on a status update.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Action_Activity_Update_Comment
	extends WordPoints_Hook_Action {

	/**
	 * @since 1.0.0
	 */
	public function should_fire() {

		$comment = $this->get_arg_value( 'bp_activity_update_comment' );

		if ( ! is_object( $comment ) ) {
			$comment = new BP_Activity_Activity( $comment );
		}

		$activity = new BP_Activity_Activity( $comment->item_id );

		if ( 'activity_update' !== $activity->type ) {
			return false;
		}

		return parent::should_fire();
	}
}

// EOF
