<?php

/**
 * Inviter user hook arg class.
 *
 * @package WordPoints_BuddyPress\Hooks
 * @since 1.0.0
 */

/**
 * Represents the inviter user as a hook arg.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Arg_User_Inviter extends WordPoints_Hook_Arg {

	/**
	 * @since 1.0.0
	 */
	protected $is_stateful = true;

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Inviter', 'wordpoints-bp' );
	}
}

// EOF
