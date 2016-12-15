<?php

/**
 * Test case for WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic.
 *
 * @package WordPoints_BuddyPress\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic
 */
class WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic_Test
	extends WordPoints_PHPUnit_TestCase {

	/**
	 * @since 1.0.0
	 */
	public function setUp() {

		parent::setUp();

		$this->factory->bp = new BP_UnitTest_Factory();
	}

	/**
	 * Test that it doesn't apply to public groups.
	 *
	 * @since 1.0.0
	 */
	public function test_applies_public() {

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			$this->factory->bp->group->create()
			, array( 'test' )
		);

		$this->assertFalse( $restriction->applies() );
	}

	/**
	 * Test that it applies to non-public groups.
	 *
	 * @since 1.0.0
	 */
	public function test_applies_not_public() {

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			$this->factory->bp->group->create( array( 'status' => 'private' ) )
			, array( 'test' )
		);

		$this->assertTrue( $restriction->applies() );
	}

	/**
	 * Test that it applies to non-public groups with custom statuses.
	 *
	 * @since 1.0.0
	 */
	public function test_applies_not_public_custom_status() {

		buddypress()->groups->valid_status[] = 'custom';

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			$this->factory->bp->group->create( array( 'status' => 'custom' ) )
			, array( 'test' )
		);

		$this->assertTrue( $restriction->applies() );
	}

	/**
	 * Test that it applies when the group is nonexistent.
	 *
	 * @since 1.0.0
	 */
	public function test_applies_nonexistent() {

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			0
			, array( 'test' )
		);

		$this->assertTrue( $restriction->applies() );
	}

	/**
	 * Test that the filter doesn't get applied when the group is public.
	 *
	 * @since 1.0.0
	 */
	public function test_applies_public_filter() {

		add_filter(
			'wordpoints_bp_group_status_nonpublic_entity_restriction_applies'
			, '__return_true'
		);

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			$this->factory->bp->group->create()
			, array( 'test' )
		);

		$this->assertFalse( $restriction->applies() );
	}

	/**
	 * Test that the filter gets applied for non-public groups.
	 *
	 * @since 1.0.0
	 */
	public function test_applies_not_public_filter() {

		add_filter(
			'wordpoints_bp_group_status_nonpublic_entity_restriction_applies'
			, '__return_false'
		);

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			$this->factory->bp->group->create( array( 'status' => 'private' ) )
			, array( 'test' )
		);

		$this->assertFalse( $restriction->applies() );
	}

	/**
	 * Test that the filter gets applied for non-public groups with custom statuses.
	 *
	 * @since 1.0.0
	 */
	public function test_applies_not_public_custom_status_filter() {

		add_filter(
			'wordpoints_bp_group_status_nonpublic_entity_restriction_applies'
			, '__return_false'
		);

		buddypress()->groups->valid_status[] = 'custom';

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			$this->factory->bp->group->create( array( 'status' => 'custom' ) )
			, array( 'test' )
		);

		$this->assertFalse( $restriction->applies() );
	}

	/**
	 * Test that it applies when the group is nonexistent.
	 *
	 * @since 1.0.0
	 */
	public function test_applies_nonexistent_filter() {

		add_filter(
			'wordpoints_bp_group_status_nonpublic_entity_restriction_applies'
			, '__return_false'
		);

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			0
			, array( 'test' )
		);

		$this->assertTrue( $restriction->applies() );
	}

	/**
	 * Test that the user can for public groups.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_public() {

		/** @var BP_Groups_Group $group */
		$group = $this->factory->bp->group->create_and_get();

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			$group->id
			, array( 'test' )
		);

		$this->assertTrue(
			$restriction->user_can( 0 )
		);
	}

	/**
	 * Test that the user can't for non-public groups.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_not_public() {

		/** @var BP_Groups_Group $group */
		$group = $this->factory->bp->group->create_and_get(
			array( 'status' => 'private' )
		);

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			$group->id
			, array( 'test' )
		);

		$this->assertFalse(
			$restriction->user_can( $this->factory->user->create() )
		);
	}

	/**
	 * Test that the user can for non-public groups they are a member of.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_not_public_is_member() {

		/** @var BP_Groups_Group $group */
		$group = $this->factory->bp->group->create_and_get(
			array( 'status' => 'private' )
		);

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			$group->id
			, array( 'test' )
		);

		$this->assertTrue(
			$restriction->user_can( $group->creator_id )
		);
	}

	/**
	 * Test that the user can for non-public groups if they have the required caps.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_not_public_has_cap() {

		/** @var BP_Groups_Group $group */
		$group = $this->factory->bp->group->create_and_get(
			array( 'status' => 'private' )
		);

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			$group->id
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

	/**
	 * Test that the user can't when the group is nonexistent.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_nonexistent() {

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
			0
			, array( 'test' )
		);

		$this->assertFalse(
			$restriction->user_can( $this->factory->user->create() )
		);
	}

	/**
	 * Test that the user can when the group is nonexistent if they have the caps.
	 *
	 * @since 1.0.0
	 */
	public function test_user_can_nonexistent_has_cap() {

		$restriction = new WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic(
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
