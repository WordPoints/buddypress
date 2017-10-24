<?php

/**
 * Avatar set hook action class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.2.1
 */

/**
 * Action that fires when an avatar is set.
 *
 * @since 1.2.1
 */
class WordPoints_BP_Hook_Action_Avatar_Set extends WordPoints_Hook_Action {

	/**
	 * Whether the user already has a cover image.
	 *
	 * @since 1.2.1
	 *
	 * @var bool
	 */
	protected static $has_avatar;

	/**
	 * @since 1.2.1
	 */
	public function should_fire() {

		if ( self::$has_avatar ) {
			return false;
		}

		return parent::should_fire();
	}

	/**
	 * Sets whether the user already has an avatar.
	 *
	 * @since 1.2.1
	 *
	 * @WordPress\filter bp_core_pre_avatar_handle_crop
	 *
	 * @param mixed $var       Filtered var.
	 * @param array $bp_params The BuddyPress parameters.
	 *
	 * @return mixed The filtered value.
	 */
	public static function set_has_avatar( $var, $bp_params ) {

		self::$has_avatar = (
			isset( $bp_params['item_id'] )
			&& bp_get_user_has_avatar( $bp_params['item_id'] )
		);

		return $var;
	}
}

// EOF
