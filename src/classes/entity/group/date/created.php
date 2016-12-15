<?php

/**
 * Group created date entity attribute.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a group's creation date.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Group_Date_Created
	extends WordPoints_Entity_Attr_Field {

	/**
	 * @since 1.0.0
	 */
	protected $storage_type = 'db';

	/**
	 * @since 1.0.0
	 */
	protected $data_type = 'mysql_datetime';

	/**
	 * @since 1.0.0
	 */
	protected $field = 'date_created';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Date Created', 'wordpoints-bp' );
	}
}

// EOF
