<?php

/**
 * Test case for WordPoints_BP_Entity_Restriction_Activity_Spam.
 *
 * @package WordPoints_BuddyPress\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests WordPoints_BP_Entity_Restriction_Activity_Spam.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Entity_Restriction_Activity_Spam
 */
class WordPoints_BP_Entity_Restriction_Activity_Spam_Test
	extends WordPoints_PHPUnit_TestCase {

	/**
	 * @since 1.0.0
	 */
	public function setUp() {

		parent::setUp();

		$this->factory->bp = new BP_UnitTest_Factory();
	}

	/**
	 * Test that it doesn't apply to public activity.
	 *
	 * @since 1.0.0
	 */
	public function test_applies_not_spam() {

		$restriction = new WordPoints_BP_Entity_Restriction_Activity_Spam(
			$this->factory->bp->activity->create()
			, array( 'test' )
		);

		$this->assertFalse( $restriction->applies() );
	}

	/**
	 * Test that it applies to spam activity.
	 *
	 * @since 1.0.0
	 */
	public function test_applies_spam() {

		$restriction = new WordPoints_BP_Entity_Restriction_Activity_Spam(
			$this->factory->bp->activity->create( array( 'is_spam' => 1 ) )
			, array( 'test' )
		);

		$this->assertTrue( $restriction->applies() );
	}

	/**
	 * Test that it applies when the activity item is nonexistent.
	 *
	 * @since 1.0.0
	 */
	public function test_applies_nonexistent() {

		$restriction = new WordPoints_BP_Entity_Restriction_Activity_Spam(
			0
			, array( 'test' )
		);

		$this->assertTrue( $restriction->applies() );
	}

	/**
	 * Test that the user can for non-spam activity.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_not_spam() {

		$restriction = new WordPoints_BP_Entity_Restriction_Activity_Spam(
			$this->factory->bp->activity->create()
			, array( 'test' )
		);

		$this->assertTrue( $restriction->user_can( 0 ) );
	}

	/**
	 * Test that the user can't for spam activity.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_spam() {

		$restriction = new WordPoints_BP_Entity_Restriction_Activity_Spam(
			$this->factory->bp->activity->create( array( 'is_spam' => 1 ) )
			, array( 'test' )
		);

		$this->assertFalse(
			$restriction->user_can( $this->factory->user->create() )
		);
	}

	/**
	 * Test that the user can't for spam activity evenn if they are its author.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_spam_is_author() {

		/** @var BP_Activity_Activity $activity */
		$activity = $this->factory->bp->activity->create_and_get(
			array( 'is_spam' => 1 )
		);

		$restriction = new WordPoints_BP_Entity_Restriction_Activity_Spam(
			$activity->id
			, array( 'test' )
		);

		$this->assertFalse( $restriction->user_can( $activity->user_id ) );
	}

	/**
	 * Test that the user can for spam activity if they have the required caps.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_spam_has_cap() {

		$restriction = new WordPoints_BP_Entity_Restriction_Activity_Spam(
			$this->factory->bp->activity->create( array( 'is_spam' => 1 ) )
			, array( 'test' )
		);

		$user = $this->factory->user->create_and_get();

		// The BuddyPress cap is translated to `manage_options`.
		$user->add_cap( 'bp_moderate' );
		$user->add_cap( 'manage_options' );

		$this->assertTrue( $restriction->user_can( $user->ID ) );
	}

	/**
	 * Test that the user can't when the activity item is nonexistent.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_nonexistent() {

		$restriction = new WordPoints_BP_Entity_Restriction_Activity_Spam(
			0
			, array( 'test' )
		);

		$this->assertFalse(
			$restriction->user_can( $this->factory->user->create() )
		);
	}

	/**
	 * Test that the user can when the activity is nonexistent if they have the caps.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_nonexistent_has_cap() {

		$restriction = new WordPoints_BP_Entity_Restriction_Activity_Spam(
			0
			, array( 'test' )
		);

		$user = $this->factory->user->create_and_get();

		// The BuddyPress cap is translated to `manage_options`.
		$user->add_cap( 'bp_moderate' );
		$user->add_cap( 'manage_options' );

		$this->assertTrue( $restriction->user_can( $user->ID ) );
	}
}

// EOF
