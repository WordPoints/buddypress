<?php

/**
 * Base entity class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Provides a bootstrap for classes that represent a BuddyPress entity.
 *
 * @since 1.0.0
 */
abstract class WordPoints_BP_Entity
	extends WordPoints_Entity
	implements WordPoints_Entityish_StoredI {

	/**
	 * The slug of the BuddyPress component this entity belongs to.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $bp_component;

	/**
	 * The name of the table the entity objects are stored in.
	 *
	 * This is just the name of the property on the component object that holds the
	 * table name, sans the `table_name_` prefix. Some components have only a single
	 * table whose name is stored in the `table_name` property, in which case you
	 * don't need to define this property here.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $bp_component_table_name;

	/**
	 * @since 1.0.0
	 */
	public function get_context() {

		// Defaults to global context.
		$context = '';

		// However, when BP Multi Network is installed, each network has its own
		// separate social network.
		if ( $this->is_bp_multi_network() ) {
			$context = 'network';
		}

		return $context;
	}

	/**
	 * Check if the BP Multi Network plugin is installed.
	 *
	 * This plugin allows BuddyPress to have a different social network for each
	 * network in a multi-network install, instead of a single one global to the
	 * multi-network.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Whether BP Multi Network is installed.
	 */
	protected function is_bp_multi_network() {
		return (
			// Version 0.1: https://wordpress.org/plugins/bp-multi-network/
			function_exists( 'ra_bp_multinetwork_filter' )
			// Version 0.2: https://github.com/johnjamesjacoby/bp-multi-network
			|| class_exists( 'BP_Multi_Network' )
		);
	}

	/**
	 * @since 1.0.0
	 */
	public function get_storage_info() {

		$table_name = 'table_name';

		if ( isset( $this->bp_component_table_name ) ) {
			$table_name = "table_name_{$this->bp_component_table_name}";
		}

		return array(
			'type' => 'db',
			'info' => array(
				'type'       => 'table',
				'table_name' => buddypress()->{$this->bp_component}->{$table_name},
			),
		);
	}
}

// EOF
