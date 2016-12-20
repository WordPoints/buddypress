<?php

/**
 * Group status entity attribute class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a group's status.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Group_Status extends WordPoints_Entity_Attr_Field {

	/**
	 * @since 1.0.0
	 */
	protected $storage_type = 'db';

	/**
	 * @since 1.0.0
	 */
	protected $data_type = 'text';

	/**
	 * @since 1.0.0
	 */
	protected $field = 'status';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return _x( 'Status', 'group entity', 'wordpoints-bp' );
	}
}

// EOF
