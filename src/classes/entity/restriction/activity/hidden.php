<?php

/**
 * Activity hidden entity restriction class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Restriction rule for user activity that has been marked as hidden.
 *
 * Activity can be marked with the `hide_sitewide` property set to true, to indicate
 * that it should not be displayed in the site-wide activity feed, only in its native
 * activity feed. Thus because the native feed may be public, this alone does not
 * indicate privacy restrictions for an activity item, and it is not generally
 * applied to status updates, for example, in BuddyPress core. But we use this
 * restriction as an extra precaution, in case some activity is being hidden by
 * plugins via this mechanism.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Restriction_Activity_Hidden
	implements WordPoints_Entity_RestrictionI {

	/**
	 * The activity object.
	 *
	 * @since 1.0.0
	 *
	 * @var BP_Activity_Activity
	 */
	protected $activity;

	/**
	 * Whether this activity object is hidden.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	protected $is_hidden = true;

	/**
	 * @since 1.0.0
	 */
	public function __construct( $entity_id, array $hierarchy ) {

		$this->activity = new BP_Activity_Activity( $entity_id );

		// We use component to check if the activity exists, because the ID is set
		// even if invalid. See https://buddypress.trac.wordpress.org/ticket/7394.
		if ( $this->activity->component ) {
			$this->is_hidden = (bool) $this->activity->hide_sitewide;
		}
	}

	/**
	 * @since 1.0.0
	 */
	public function user_can( $user_id ) {

		if ( ! $this->is_hidden ) {
			return true;
		}

		// Moderators can view hidden activity.
		if ( bp_user_can( $user_id, 'bp_moderate' ) ) {
			return true;
		}

		// The user can view their own activity, even if it is hidden.
		if ( $this->activity->user_id === $user_id ) {
			return true;
		}

		return false;
	}

	/**
	 * @since 1.0.0
	 */
	public function applies() {
		return $this->is_hidden;
	}
}

// EOF
