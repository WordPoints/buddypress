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
class WordPoints_BP_Hook_Action_Avatar_Delete
	extends WordPoints_BP_Hook_Action_Avatar {

	/**
	 * @since 1.0.0
	 */
	public function __construct( $slug, array $action_args, array $args = array() ) {

		// Back-compat with pre-1.2.1.
		if (
			isset( $args['bp_avatar_object_type'] )
			&& 'group' === $args['bp_avatar_object_type']
		) {
			$args['bp_avatar_object_type'] = 'bp_group';
		}

		parent::__construct( $slug, $action_args, $args );
	}

	/**
	 * @since 1.0.0
	 */
	public function should_fire() {

		// If this image is being deleted just because a new one is being uploaded,
		// then don't trigger the action.
		if ( $this->is_upload() ) {
			return false;
		}

		return parent::should_fire();
	}

	/**
	 * Checks if a new avatar is being uploaded.
	 *
	 * @since 1.2.1
	 *
	 * @return bool Whether or not a new avatar is being uploaded.
	 */
	protected function is_upload() {

		return (bool) wordpoints_verify_nonce(
			'nonce'
			, 'bp_avatar_cropstore'
			, null
			, 'post'
		);
	}

	/**
	 * @since 1.0.0
	 */
	public function get_arg_value( $arg_slug ) {

		$expected_arg_slug = $this->bp_avatar_object_type;

		if ( 'blog' === $expected_arg_slug ) {
			$expected_arg_slug = 'site';
		}

		if (
			$arg_slug === $expected_arg_slug
			&& str_replace( 'bp_', '', $this->bp_avatar_object_type ) === $this->args[0]['object']
		) {
			return $this->args[0]['item_id'];
		}

		return parent::get_arg_value( $arg_slug );
	}
}

// EOF
