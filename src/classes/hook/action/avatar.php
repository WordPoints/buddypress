<?php

/**
 * Avatar hook action class.
 *
 * @package WordPoints_BuddyPress
 * @since   1.2.1
 */

/**
 * Bootstrap for actions relating to avatars.
 *
 * Avatars are supported by both users and groups, so we are able to use the same
 * action classes for both. This class provides some bootstrap to help with that.
 *
 * @since 1.2.1
 */
class WordPoints_BP_Hook_Action_Avatar extends WordPoints_Hook_Action {

	/**
	 * The type of object to fire for.
	 *
	 * @since 1.2.1
	 *
	 * @var string
	 */
	protected $bp_avatar_object_type = 'user';

	/**
	 * @since 1.2.1
	 */
	public function __construct( $slug, array $action_args, array $args = array() ) {

		if ( isset( $args['bp_avatar_object_type'] ) ) {
			$this->bp_avatar_object_type = $args['bp_avatar_object_type'];
		}

		parent::__construct( $slug, $action_args, $args );
	}

	/**
	 * @since 1.2.1
	 */
	public function should_fire() {

		if ( null === $this->get_arg_value( $this->bp_avatar_object_type ) ) {
			return false;
		}

		return parent::should_fire();
	}
}

// EOF
