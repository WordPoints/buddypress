<?php

/**
 * Activity spam entity restriction class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Restriction rule for user activity that has been marked as spam.
 *
 * @since 1.0.0
 */
class WordPoints_BP_Entity_Restriction_Activity_Spam
	implements WordPoints_Entity_RestrictionI {

	/**
	 * Whether this activity item is spam.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	protected $is_spam = true;

	/**
	 * @since 1.0.0
	 */
	public function __construct( $entity_id, array $hierarchy ) {

		$activity = new BP_Activity_Activity( $entity_id );

		// We use component to check if the activity exists, because the ID is set
		// even if invalid. See https://buddypress.trac.wordpress.org/ticket/7394.
		if ( $activity->component ) {
			$this->is_spam = (bool) $activity->is_spam;
		}
	}

	/**
	 * @since 1.0.0
	 */
	public function user_can( $user_id ) {

		if ( ! $this->is_spam ) {
			return true;
		}

		if ( bp_user_can( $user_id, 'bp_moderate' ) ) {
			return true;
		}

		// We're not worried about spammers being allowed to see their own spam,
		// since they aren't generally allowed to.
		return false;
	}

	/**
	 * @since 1.0.0
	 */
	public function applies() {
		return $this->is_spam;
	}
}

// EOF
