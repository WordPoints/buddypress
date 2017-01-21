<?php

/**
 * Accepting user hook arg class.
 *
 * @package WordPoints_BuddyPress\Hooks
 * @since 1.1.0
 */

/**
 * Represents the accepting user as a hook arg.
 *
 * @since 1.1.0
 */
class WordPoints_BP_Hook_Arg_User_Accepting
	extends WordPoints_Hook_Arg_Current_User {

	/**
	 * @since 1.1.0
	 */
	public function get_title() {
		return __( 'Accepting User', 'wordpoints-bp' );
	}
}

// EOF
