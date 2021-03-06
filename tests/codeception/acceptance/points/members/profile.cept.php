<?php

/**
 * Tests points tabs on the member profile.
 *
 * @package WordPoints_BuddyPress\Codeception
 * @since 1.0.0
 */

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Viewing points info on my profile' );
$I->hadCreatedAPointsType( array( 'prefix' => '$', 'suffix' => '' ) );
$I->hadCreatedAPointsType( array( 'name' => 'XP' ) );
$I->havePoints( 5, 'points' );
$I->havePoints( 3, 'xp' );
$I->amLoggedInAsAdminOnPage( 'members/admin/' );
$I->see( 'Points: $5', '.wordpoints-bp-member-profile-meta' );
$I->see( 'XP: 3', '.wordpoints-bp-member-profile-meta' );
$I->see( 'Points', '#object-nav' );
$I->click( 'Points', '#object-nav' );
$I->see( 'Points', '#object-nav .current' );
$I->see( 'Points', '#subnav .current' );
$I->see( 'XP', '#subnav' );
$I->see( 'Points: $5', '.wordpoints-bp-member-profile-stat' );
$I->see( 'Points', '.wordpoints-points-logs' );
$I->click( 'XP', '#subnav' );
$I->see( 'XP', '#subnav .current' );
$I->see( 'XP: 3', '.wordpoints-bp-member-profile-stat' );
$I->see( 'XP', '.wordpoints-points-logs' );

// EOF
