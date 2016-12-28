<?php

/**
 * XProfile cover image upload hook event class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * An event that fires when a user uploads a new profile cover image.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Event_XProfile_Cover_Image_Upload
	extends WordPoints_Hook_Event
	implements WordPoints_Hook_Event_ReversingI {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Set Profile Cover Image', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Setting your profile cover image on the BuddyPress social network.', 'wordpoints-bp' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_reversal_text() {
		return __( 'Image deleted.', 'wordpoints-bp' );
	}
}

// EOF
