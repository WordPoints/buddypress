<?php

/**
 * Group status nonpublic entity restriction class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Restriction rule for groups with a nonpublic status.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic
	implements WordPoints_Entity_RestrictionI {

	/**
	 * The ID of the entity this restriction relates to.
	 *
	 * @since 1.0.0
	 *
	 * @var int|string
	 */
	protected $entity_id;

	/**
	 * The group ID.
	 *
	 * @since 1.0.0
	 *
	 * @var int
	 */
	protected $group_id;

	/**
	 * Whether this restriction applies to this group.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	protected $applies = false;

	/**
	 * @since 1.0.0
	 */
	public function __construct( $entity_id, array $hierarchy ) {

		$this->entity_id = $entity_id;
		$this->group_id = $this->get_group_id();

		$group = groups_get_group( $this->group_id );

		// Note that if the group doesn't exist, the status won't be set.
		if ( ! $group->id ) {

			$this->applies = true;

		} elseif ( 'public' !== $group->status ) {

			/**
			 * Filters whether the Status Nonpublic restriction applies to a group.
			 *
			 * By default, the restriction applies to all group statuses other than
			 * public. However, since custom statuses can be added, this filter
			 * enables special handling for them.
			 *
			 * @since 1.0.0
			 *
			 * @param bool            $applies Whether the group applies.
			 * @param BP_Groups_Group $group   The group object.
			 */
			$this->applies = apply_filters(
				'wordpoints_bp_group_status_nonpublic_entity_restriction_applies'
				, true
				, $group
			);
		}
	}

	/**
	 * @since 1.0.0
	 */
	public function user_can( $user_id ) {

		if ( ! $this->applies ) {
			return true;
		}

		// Moderators are allowed to view all groups.
		if ( bp_user_can( $user_id, 'bp_moderate' ) ) {
			return true;
		}

		// Group members can view the group.
		if ( groups_is_user_member( $user_id, $this->group_id ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @since 1.0.0
	 */
	public function applies() {
		return $this->applies;
	}

	/**
	 * Get the ID of the message thread that this restriction relates to.
	 *
	 * @since 1.0.0
	 *
	 * @return int|false The ID of the thread, or false.
	 */
	protected function get_group_id() {
		return $this->entity_id;
	}
}

// EOF
