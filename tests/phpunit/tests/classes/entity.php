<?php

/**
 * Test case for the WordPoints_BP_Entity class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Entity class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Entity
 */
class WordPoints_BP_Entity_Test extends WordPoints_PHPUnit_TestCase {

	/**
	 * Test that get_context() returns the global context by default.
	 *
	 * @since 1.0.0
	 */
	public function test_get_context_global_by_default() {

		$entity = new WordPoints_BP_PHPUnit_Mock_Entity( 'test' );

		$this->assertSame( '', $entity->get_context() );
	}

	/**
	 * Test get_context() returns 'network' context when BP Multi Network installed.
	 *
	 * @since 1.0.0
	 */
	public function test_get_context_network_if_is_bp_multi_network() {

		$entity = new WordPoints_BP_PHPUnit_Mock_Entity( 'test' );
		$entity->is_bp_multi_network = true;

		$this->assertSame( 'network', $entity->get_context() );
	}

	/**
	 * Test get_storage_info().
	 *
	 * @since 1.0.0
	 */
	public function test_get_storage_info() {

		$entity = new WordPoints_BP_PHPUnit_Mock_Entity( 'test' );
		$entity->bp_component = 'friends';

		$this->assertSame(
			array(
	             'type' => 'db',
	             'info' => array(
	                 'type'       => 'table',
	                 'table_name' => buddypress()->friends->table_name,
	             ),
	         )
			, $entity->get_storage_info()
		);
	}

	/**
	 * Test get_storage_info() when the component has multiple tables.
	 *
	 * @since 1.0.0
	 */
	public function test_get_storage_info_table_name() {

		$entity = new WordPoints_BP_PHPUnit_Mock_Entity( 'test' );
		$entity->bp_component = 'messages';
		$entity->bp_component_table_name = 'messages';

		$this->assertSame(
			array(
				'type' => 'db',
				'info' => array(
					'type'       => 'table',
					'table_name' => buddypress()->messages->table_name_messages,
				),
			)
			, $entity->get_storage_info()
		);
	}
}

// EOF
