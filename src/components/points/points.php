<?php

/**
 * Load code relating to the points component.
 *
 * @package WordPoints_BuddyPress
 * @since   1.0.0
 */

/**
 * The Members-related functions.
 *
 * We always load this because BuddyPress's Members component cannot be deactivated.
 *
 * @since 1.0.0
 */
require_once WORDPOINTS_BP_DIR . '/components/points/includes/members.php';

/**
 * Hook up the action and filter hooks relating to the points component.
 *
 * @since 1.0.0
 */
require_once WORDPOINTS_BP_DIR . '/components/points/includes/actions.php';

// EOF
