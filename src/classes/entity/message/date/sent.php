<?php

/**
 * Message sent date entity attribute.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a message's sent date.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Message_Date_Sent extends WordPoints_Entity_Attr_Field {

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
	protected $field = 'date_sent';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return _x( 'Date Sent', 'message entity', 'wordpoints-bp' );
	}
}

// EOF
