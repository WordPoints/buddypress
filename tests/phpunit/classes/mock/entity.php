<?php

/**
 * Mock entity class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * A mock entity for use in the PHPUnit tests.
 *
 * @since 1.0.0
 */
class WordPoints_BP_PHPUnit_Mock_Entity extends WordPoints_BP_Entity {

	/**
	 * @since 1.0.0
	 */
	public $bp_component;

	/**
	 * @since 1.0.0
	 */
	public $bp_component_table_name;

	/**
	 * Override whether BP Multi Network is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	public $is_bp_multi_network;

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return 'Test BP Entity';
	}

	/**
	 * @since 1.0.0
	 */
	protected function is_bp_multi_network() {

		if ( isset( $this->is_bp_multi_network ) ) {
			return $this->is_bp_multi_network;
		}

		return parent::is_bp_multi_network();
	}
}

// EOF
