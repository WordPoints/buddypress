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
 * @covers WordPoints_BP_Entity_Friendship
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
			'bp_friendship' => array(
				array(
					'class'          => 'WordPoints_BP_Entity_Friendship',
					'slug'           => 'bp_friendship',
					'id_field'       => 'id',
					'get_human_id'   => array( $this, 'get_friendship_human_id' ),
					'context'        => '',
					'storage_info'   => array(
						'type' => 'db',
						'info' => array(
							'type'       => 'table',
							'table_name' => buddypress()->friends->table_name,
						),
					),
					'the_context'    => array(),
					'create_func'    => array( $factory->bp->friendship, 'create_and_get' ),
					'delete_func'    => array( $this, 'delete_friendship' ),
					'children'       => array(
						'date_created' => array(
							'class'        => 'WordPoints_BP_Entity_Friendship_Date_Created',
							'data_type'    => 'mysql_datetime',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'date_created',
								),
							),
						),
						'friend' => array(
							'class'        => 'WordPoints_BP_Entity_Friendship_Friend',
							'primary'      => 'bp_friendship',
							'related'      => 'user',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'friend_user_id',
								),
							),
						),
						'initiator' => array(
							'class'        => 'WordPoints_BP_Entity_Friendship_Initiator',
							'primary'      => 'bp_friendship',
							'related'      => 'user',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'initiator_user_id',
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

	/**
	 * Delete a friendship by ID.
	 *
	 * @since 1.0.0
	 *
	 * @param int $friendship_id The ID of the friendship to delete.
	 */
	public function delete_friendship( $friendship_id ) {

		$friendship = new BP_Friends_Friendship( $friendship_id );

		bp_friends_clear_bp_friends_friendships_cache_remove(
			$friendship_id
			, $friendship
		);

		$friendship->delete();
	}

	/**
	 * Get the human ID for a friendship.
	 *
	 * @since 1.0.0
	 *
	 * @param BP_Friends_Friendship $friendship The friendship object.
	 *
	 * @return string The human ID for the friendship.
	 */
	public function get_friendship_human_id( $friendship ) {
		return bp_core_get_user_displayname( $friendship->initiator_user_id )
			. ' + ' . bp_core_get_user_displayname( $friendship->friend_user_id );
	}
}

// EOF
