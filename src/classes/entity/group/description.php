<?php

/**
 * Group description entity attribute class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Represents a group description.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Group_Description extends WordPoints_Entity_Attr_Field {

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
	protected $field = 'description';

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return __( 'Description', 'wordpoints-bp' );
	}
}

// EOF
