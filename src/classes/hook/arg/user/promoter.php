<?php

/**
 * Promoter user hook arg class.
 *
 * @package WordPoints_BuddyPress\Hooks
 * @since 1.0.0
 */

/**
 * Represents the promoter user as a hook arg.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Arg_User_Promoter extends WordPoints_Hook_Arg_Current_User {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Promoter', 'wordpoints-bp' );
	}
}

// EOF
