<?php

/**
 * Test case for the WordPoints_BP_Hook_Event_Message_Send class.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the WordPoints_BP_Hook_Event_Message_Send class.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Hook_Event_Message_Send
 */
class WordPoints_BP_Hook_Event_Message_Send_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'bp_message_send';

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_BP_Hook_Event_Message_Send';

	/**
	 * @since 1.0.0
	 */
	protected $is_reversible = false;

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array(
		array( 'bp_message', 'sender', 'user' ),
	);

	/**
	 * @since 1.0.0
	 */
	protected function fire_event( $arg, $reactor_slug ) {

		$this->factory->bp = new BP_UnitTest_Factory();

		return array(
			$this->factory->bp->message->create(),
		);
	}
}

// EOF
