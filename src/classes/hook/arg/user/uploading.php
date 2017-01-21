<?php

/**
 * Uploading user hook arg class.
 *
 * @package WordPoints_BuddyPress\Hooks
 * @since 1.1.0
 */

/**
 * Represents the uploading user as a hook arg.
 *
 * @since 1.1.0
 */
class WordPoints_BP_Hook_Arg_User_Uploading
	extends WordPoints_Hook_Arg_Current_User {

	/**
	 * @since 1.1.0
	 */
	public function get_title() {
		return __( 'Uploading User', 'wordpoints-bp' );
	}
}

// EOF
