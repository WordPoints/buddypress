<?php

/**
 * Group invite user hook action class.
 *
 * @package WordPoints_BuddyPress
 * @since   1.0.0
 */

/**
 * Action that fires when a user is invited to a group.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Action_Group_Invite_User extends WordPoints_Hook_Action {

	/**
	 * @since 1.0.0
	 */
	public function get_arg_value( $arg_slug ) {

		$map = array(
			'user' => 'user_id',
			'bp_group' => 'group_id',
			'inviter:user' => 'inviter_id',
		);

		if ( isset( $map[ $arg_slug ] ) ) {
			return $this->args[0][ $map[ $arg_slug ] ];
		}

		return parent::get_arg_value( $arg_slug );
	}
}

// EOF
