<?php

/**
 * Test case for WordPoints_BP_Entity_Restriction_Message_Thread_Accessible.
 *
 * @package WordPoints_BuddyPress\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests WordPoints_BP_Entity_Restriction_Message_Thread_Accessible.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Entity_Restriction_Message_Thread_Accessible
 */
class WordPoints_BP_Entity_Restriction_Message_Thread_Accessible_Test
	extends WordPoints_PHPUnit_TestCase {

	/**
	 * @since 1.0.0
	 */
	public function setUp() {

		parent::setUp();

		$this->factory->bp = new BP_UnitTest_Factory();
	}

	/**
	 * Test that it applies.
	 *
	 * @since 1.0.0
	 */
	public function test_applies() {

		$restriction = new WordPoints_BP_Entity_Restriction_Message_Thread_Accessible(
			$this->factory->bp->message->create()
			, array( 'test' )
		);

		$this->assertTrue( $restriction->applies() );
	}

	/**
	 * Test that it applies when the message thread is nonexistent.
	 *
	 * @since 1.0.0
	 */
	public function test_applies_nonexistent() {

		$restriction = new WordPoints_BP_Entity_Restriction_Message_Thread_Accessible(
			0
			, array( 'test' )
		);

		$this->assertTrue( $restriction->applies() );
	}

	/**
	 * Test that the user can when they are a recipient.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_is_recipient() {

		/** @var BP_Messages_Message $message */
		$message = $this->factory->bp->message->create_and_get();

		$restriction = new WordPoints_BP_Entity_Restriction_Message_Thread_Accessible(
			$message->id
			, array( 'test' )
		);

		$this->assertTrue(
			$restriction->user_can( $message->sender_id )
		);
	}

	/**
	 * Test that the user can't when they aren't a recipient.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_is_not_recipient() {

		/** @var BP_Messages_Message $message */
		$message = $this->factory->bp->message->create_and_get();

		$restriction = new WordPoints_BP_Entity_Restriction_Message_Thread_Accessible(
			$message->id
			, array( 'test' )
		);

		$this->assertFalse(
			$restriction->user_can( $this->factory->user->create() )
		);
	}

	/**
	 * Test that the user can't when the message thread is nonexistent.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_nonexistent() {

		$restriction = new WordPoints_BP_Entity_Restriction_Message_Thread_Accessible(
			0
			, array( 'test' )
		);

		$this->assertFalse(
			$restriction->user_can( $this->factory->user->create() )
		);
	}

	/**
	 * Test that the user can when they aren't a recipient if they have the caps.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_not_recipient_has_cap() {

		/** @var BP_Messages_Message $message */
		$message = $this->factory->bp->message->create_and_get();

		$restriction = new WordPoints_BP_Entity_Restriction_Message_Thread_Accessible(
			$message->id
			, array( 'test' )
		);

		// The BuddyPress cap is translated to `manage_options`.
		$user = get_userdata( $message->sender_id );
		$user->add_cap( 'bp_moderate' );
		$user->add_cap( 'manage_options' );

		$this->assertTrue(
			$restriction->user_can( $message->sender_id )
		);
	}

	/**
	 * Test that the user can when the thread is nonexistent if they have the caps.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_nonexistent_has_cap() {

		$restriction = new WordPoints_BP_Entity_Restriction_Message_Thread_Accessible(
			0
			, array( 'test' )
		);

		$user = $this->factory->user->create_and_get();

		// The BuddyPress cap is translated to `manage_options`.
		$user->add_cap( 'bp_moderate' );
		$user->add_cap( 'manage_options' );

		$this->assertTrue(
			$restriction->user_can( $user->ID )
		);
	}
}

// EOF
