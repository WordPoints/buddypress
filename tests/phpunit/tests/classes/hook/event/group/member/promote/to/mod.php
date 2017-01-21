<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Group_Member_Promote_To_Mod class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Group_Member_Promote_To_Mod class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Group_Member_Promote_To_Mod
 *
 * @requires WordPoints version
 * @WordPoints-version 2.3.0-alpha-2
 */
class WordPoints_BP_Hook_Event_Group_Member_Promote_To_Mod_Test
	extends WordPoints_BP_Hook_Event_Group_Member_Promote_To_Admin_Test {

	/**
	 * @since 1.1.0
	 */
	protected $status = 'mod';

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_group_member_promote_to_mod';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Group_Member_Promote_To_Mod';
}

// EOF
