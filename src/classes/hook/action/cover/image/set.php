<?php

/**
 * Cover image set hook action class.
 *
 * @package WordPoints_BuddyPress
 * @since   1.2.1
 */

/**
 * Action that only fires for cover image set when the user doesn't already have one.
 *
 * @since 1.2.1
 */
class WordPoints_BP_Hook_Action_Cover_Image_Set extends WordPoints_Hook_Action {

	/**
	 * Whether the object already has a cover image.
	 *
	 * @since 1.2.1
	 *
	 * @var bool
	 */
	protected static $has_cover_image;

	/**
	 * @since 1.2.1
	 */
	public function should_fire() {

		if ( self::$has_cover_image ) {
			return false;
		}

		return parent::should_fire();
	}

	/**
	 * Set whether the object already has a cover image.
	 *
	 * @since 1.2.1
	 *
	 * @WordPress\filter bp_attachments_pre_cover_image_ajax_upload
	 *
	 * @param mixed $var       Filtered var.
	 * @param array $bp_params The BuddyPress parameters.
	 *
	 * @return mixed The filtered value.
	 */
	public static function set_has_cover_image( $var, $bp_params ) {

		if ( isset( $bp_params['item_id'], $bp_params['object'] ) ) {
			if ( 'group' === $bp_params['object'] ) {
				self::$has_cover_image = bp_attachments_get_group_has_cover_image( $bp_params['item_id'] );
			} else {
				self::$has_cover_image = bp_attachments_get_user_has_cover_image( $bp_params['item_id'] );
			}
		}

		return $var;
	}
}

// EOF
