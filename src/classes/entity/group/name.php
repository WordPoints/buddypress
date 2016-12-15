<?php

/**
 * Group name entity attribute class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a group name.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Group_Name extends WordPoints_Entity_Attr_Field {

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
	protected $field = 'name';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Name', 'wordpoints-bp' );
	}
}

// EOF
