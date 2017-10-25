<?php

/**
 * Main file of the extension.
 *
 * ---------------------------------------------------------------------------------|
 * Copyright 2015-17  J.D. Grimes  (email : jdg@codesymphony.co)
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
 * @version 1.2.1
 * @author  J.D. Grimes <jdg@codesymphony.co>
 * @license GPLv2+
 */

wordpoints_register_extension(
	'
		Extension Name: BuddyPress
		Author:         J.D. Grimes
		Author URI:     https://codesymphony.co/
		Extension URI:  https://wordpoints.org/extensions/buddypress/
		Version:        1.2.1
		License:        GPLv2+
		Description:    Integrates WordPoints with BuddyPress.
		Text Domain:    wordpoints-bp
		Domain Path:    /languages
		Server:         wordpoints.org
		ID:             944
		Namespace:      BP
	'
	, __FILE__
);

/**
 * The extension's constants.
 *
 * @since 1.0.0
 */
require_once dirname( __FILE__ ) . '/includes/constants.php';

/**
 * The extension's functions.
 *
 * @since 1.0.0
 */
require_once WORDPOINTS_BP_DIR . '/includes/functions.php';

WordPoints_Class_Autoloader::register_dir( WORDPOINTS_BP_DIR . '/classes' );

/**
 * The extension's action hooks.
 *
 * @since 1.0.0
 */
require_once WORDPOINTS_BP_DIR . '/includes/actions.php';

if ( wordpoints_component_is_active( 'points' ) ) {
	/**
	 * The extension's integration with the points component.
	 *
	 * @since 1.0.0
	 */
	require_once WORDPOINTS_BP_DIR . '/components/points/points.php';
}

if ( wordpoints_component_is_active( 'ranks' ) ) {
	/**
	 * The extension's integration with the ranks component.
	 *
	 * @since 1.0.0
	 */
	require_once WORDPOINTS_BP_DIR . '/components/ranks/ranks.php';
}

// EOF
