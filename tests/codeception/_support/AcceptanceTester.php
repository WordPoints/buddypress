<?php

/**
 * Acceptance tester class.
 *
 * @package WordPoints_Dev_Lib
 * @since 2.4.0
 */

/**
 * Tester for use in the acceptance tests.
 *
 * @since 2.4.0
 */
class AcceptanceTester extends \WordPoints\Tests\Codeception\AcceptanceTester {

	/**
	 * Gives the user a given number of points.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $points How many points to give them.
	 * @param string $type   The type of points.
	 */
	public function havePoints( $points, $type ) {
		wordpoints_set_points(
			1
			, $points
			, $type
			, 'codeception'
			, array()
			, 'Testing with Codeception.'
		);
	}
}

// EOF
