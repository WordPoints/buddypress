<?php

/**
 * Activity date entity attribute.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents an activity's date.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity_Date extends WordPoints_Entity_Attr_Field {

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
	protected $field = 'date_recorded';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return _x( 'Date', 'activity entity', 'wordpoints-bp' );
	}
}

// EOF
