<?php

/**
 * Activity update content entity attribute class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents an activity update's content.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Activity_Update_Content
	extends WordPoints_Entity_Attr_Field {

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
	protected $field = 'content';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return _x( 'Content', 'activity update', 'wordpoints-bp' );
	}
}

// EOF
