<?php

/**
 * Test case for the entities included in the module.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

/**
 * Tests the entities included with the module.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_BP_Entity_Message
 * @covers WordPoints_BP_Entity_Message_Content
 * @covers WordPoints_BP_Entity_Message_Date_Sent
 * @covers WordPoints_BP_Entity_Message_Recipients
 * @covers WordPoints_BP_Entity_Message_Sender
 * @covers WordPoints_BP_Entity_Message_Subject
 */
class WordPoints_BP_Entity_Message_Test
	extends WordPoints_PHPUnit_TestCase_Entities {

	/**
	 * @since 1.0.0
	 */
	public function data_provider_entities() {

		$factory = $this->factory = new WP_UnitTest_Factory();
		$factory->wordpoints = WordPoints_PHPUnit_Factory::$factory;
		$factory->bp = new BP_UnitTest_Factory();

		$message_sender_id = $factory->user->create();
		$message_recipient_id = $factory->user->create();

		// bp_moderate gets translated to manage_options by BuddyPress.
		$bp_moderator = $factory->user->create_and_get();
		$bp_moderator->add_cap( 'bp_moderate' );
		$bp_moderator->add_cap( 'manage_options' );

		return array(
			'bp_message' => array(
				array(
					'class'          => 'WordPoints_BP_Entity_Message',
					'slug'           => 'bp_message',
					'id_field'       => 'id',
					'human_id_field' => 'subject',
					'context'        => '',
					'storage_info'   => array(
						'type' => 'db',
						'info' => array(
							'type'       => 'table',
							'table_name' => buddypress()->messages->table_name_messages,
						),
					),
					'the_context'    => array(),
					'create_func'    => array( $factory->bp->message, 'create_and_get' ),
					'delete_func'    => array( $this, 'delete_message' ),
					'can_view'       => array(
						$message_sender_id => $factory->bp->message->create(
							array( 'sender_id' => $message_sender_id )
						),
						$message_recipient_id => $factory->bp->message->create(
							array( 'recipients' => $message_recipient_id )
						),
						$bp_moderator->ID => $factory->bp->message->create(),
					),
					'cant_view'      => $factory->bp->message->create(),
					'children'       => array(
						'content' => array(
							'class'        => 'WordPoints_BP_Entity_Message_Content',
							'data_type'    => 'text',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'message',
								),
							),
						),
						'date_sent' => array(
							'class'        => 'WordPoints_BP_Entity_Message_date_sent',
							'data_type'    => 'mysql_datetime',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'date_sent',
								),
							),
						),
						'recipients' => array(
							'class'        => 'WordPoints_BP_Entity_Message_Recipients',
							'primary'      => 'bp_message',
							'related'      => 'user{}',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'             => 'table',
									'table_name'       => buddypress()->messages->table_name_recipients,
									'primary_id_field' => 'thread_id',
									'related_id_field' => 'user_id',
								),
							),
						),
						'sender' => array(
							'class'        => 'WordPoints_BP_Entity_Message_Sender',
							'primary'      => 'bp_message',
							'related'      => 'user',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'sender_id',
								),
							),
						),
						'subject' => array(
							'class'        => 'WordPoints_BP_Entity_Message_Subject',
							'data_type'    => 'text',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'subject',
								),
							),
						),
					),
				),
			),
		);
	}

	/**
	 * Delete a message by ID.
	 *
	 * @since 1.0.0
	 *
	 * @param int $message_id The ID of the message to delete.
	 */
	public function delete_message( $message_id ) {

		$bp = buddypress();

		$message = new BP_Messages_Message( $message_id );

		$bp_loggedin_user_id = $bp->loggedin_user->id;

		$thread_id = messages_get_message_thread_id( $message_id );

		// BuddyPress only fully deletes the message once all recipients have marked
		// it as deleted. See https://buddypress.trac.wordpress.org/ticket/7235
		foreach ( $message->get_recipients() as $user_id ) {

			// The messages are only deleted for the current user.
			$bp->loggedin_user->id = $user_id->user_id;

			messages_delete_thread( $thread_id );
		}

		$bp->loggedin_user->id = $bp_loggedin_user_id;
	}
}

// EOF
