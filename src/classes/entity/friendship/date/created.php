<?php

/**
 * Friendship created date entity attribute.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a friendship's creation date.
 *
 * BuddyPress uses a single object and table for both friendships and friendship
 * requests. A friendship starts out as a request, but when it is accepted it gets
 * marked as confirmed. The creation date is updated at both times. So it represents
 * the date of the creation of the friendship request initially, and then once the
 * friendship is accepted, it becomes the date that the friendship was created (by
 * being upgraded from a friendship request).
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Friendship_Date_Created
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
		return _x( 'Date Created', 'friendship entity', 'wordpoints-bp' );
	}
}

// EOF
