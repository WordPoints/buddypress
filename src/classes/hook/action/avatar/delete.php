<?php

/**
 * Avatar delete hook action class.
 *
 * @package WordPoints_BuddyPress
 * @since   1.0.0
 */

/**
 * Action that only fires for avatar deletion for particular object types.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Hook_Action_Avatar_Delete extends WordPoints_Hook_Action {

	/**
	 * The type of activity to check for.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $bp_avatar_object_type = 'user';

	/**
	 * @since 1.0.0
	 */
	public function __construct( $slug, array $action_args, array $args = array() ) {

		if ( isset( $args['bp_avatar_object_type'] ) ) {
			$this->bp_avatar_object_type = $args['bp_avatar_object_type'];
		}

		parent::__construct( $slug, $action_args, $args );
	}

	/**
	 * @since 1.0.0
	 */
	public function should_fire() {

		if ( $this->bp_avatar_object_type !== $this->args[0]['object'] ) {
			return false;
		}

		return parent::should_fire();
	}

	/**
	 * @since 1.0.0
	 */
	public function get_arg_value( $arg_slug ) {

		$expected_arg_slug = $this->bp_avatar_object_type;

		if ( 'blog' === $expected_arg_slug ) {
			$expected_arg_slug = 'site';
		} elseif ( 'user' !== $expected_arg_slug ) {
			$expected_arg_slug = "bp_{$expected_arg_slug}";
		}

		if ( $arg_slug === $expected_arg_slug ) {
			return $this->args[0]['item_id'];
		}

		return parent::get_arg_value( $arg_slug );
	}
}

// EOF
