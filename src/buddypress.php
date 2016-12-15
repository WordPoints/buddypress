<?php

/**
 * Main file of the module.
 *
 * ---------------------------------------------------------------------------------|
 * Copyright 2015-16  J.D. Grimes  (email : jdg@codesymphony.co)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 1.0.0-alpha or later, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * ---------------------------------------------------------------------------------|
 *
 * @package WordPoints_BuddyPress
 * @version 1.0.0-alpha
 * @author  J.D. Grimes <jdg@codesymphony.co>
 * @license GPLv2+
 */

WordPoints_Modules::register(
	'
		Module Name: BuddyPress
		Author:      J.D. Grimes
		Author URI:  https://codesymphony.co/
		Version:     1.0.0-alpha
		License:     GPLv2+
		Description: Integrates WordPoints with BuddyPress.
	'
	, __FILE__
);

/**
 * The module's constants.
 *
 * @since 1.0.0
 */
require_once dirname( __FILE__ ) . '/includes/constants.php';

/**
 * The module's functions.
 *
 * @since 1.0.0
 */
require_once WORDPOINTS_BP_DIR . '/includes/functions.php';

WordPoints_Class_Autoloader::register_dir( WORDPOINTS_BP_DIR . '/classes' );

/**
 * The module's action hooks.
 *
 * @since 1.0.0
 */
require_once WORDPOINTS_BP_DIR . '/includes/actions.php';

if ( wordpoints_component_is_active( 'points' ) ) {
	/**
	 * The module's integration with the points component.
	 *
	 * @since 1.0.0
	 */
	require_once WORDPOINTS_BP_DIR . '/components/points/points.php';
}

if ( wordpoints_component_is_active( 'ranks' ) ) {
	/**
	 * The module's integration with the ranks component.
	 *
	 * @since 1.0.0
	 */
	require_once WORDPOINTS_BP_DIR . '/components/ranks/ranks.php';
}

// EOF
