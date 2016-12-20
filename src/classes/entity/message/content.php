<?php

/**
 * Message content entity attribute class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a message's content.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Message_Content extends WordPoints_Entity_Attr_Field {

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
	protected $field = 'message';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return _x( 'Contents', 'message entity', 'wordpoints-bp' );
	}
}

// EOF
