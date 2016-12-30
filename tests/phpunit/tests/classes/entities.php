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
 * @covers WordPoints_BP_Entity_Friendship_Date_Created
 * @covers WordPoints_BP_Entity_Friendship_Friend
 * @covers WordPoints_BP_Entity_Friendship_Initiator
 * @covers WordPoints_BP_Entity_Group
 * @covers WordPoints_BP_Entity_Group_Creator
 * @covers WordPoints_BP_Entity_Group_Date_Created
 * @covers WordPoints_BP_Entity_Group_Description
 * @covers WordPoints_BP_Entity_Group_Name
 * @covers WordPoints_BP_Entity_Group_Parent
 * @covers WordPoints_BP_Entity_Group_Slug
 * @covers WordPoints_BP_Entity_Group_Status
 * @covers WordPoints_BP_Entity_Activity
 * @covers WordPoints_BP_Entity_Activity_Date
 * @covers WordPoints_BP_Entity_Activity_User
 * @covers WordPoints_BP_Entity_Activity_Update
 * @covers WordPoints_BP_Entity_Activity_Update_Author
 * @covers WordPoints_BP_Entity_Activity_Update_Content
 * @covers WordPoints_BP_Entity_Activity_Update_Date_Posted
 * @covers WordPoints_BP_Entity_Activity_Comment
 * @covers WordPoints_BP_Entity_Activity_Comment_Activity
 * @covers WordPoints_BP_Entity_Activity_Comment_Author
 * @covers WordPoints_BP_Entity_Activity_Comment_Parent
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
			'bp_group' => array(
				array(
					'class'          => 'WordPoints_BP_Entity_Group',
					'slug'           => 'bp_group',
					'id_field'       => 'id',
					'human_id_field' => 'name',
					'context'        => '',
					'storage_info'   => array(
						'type' => 'db',
						'info' => array(
							'type'       => 'table',
							'table_name' => buddypress()->groups->table_name,
						),
					),
					'the_context'    => array(),
					'create_func'    => array( $factory->bp->group, 'create_and_get' ),
					'delete_func'    => 'groups_delete_group',
					'children'       => array(
						'creator' => array(
							'class'        => 'WordPoints_BP_Entity_Group_Creator',
							'primary'      => 'bp_group',
							'related'      => 'user',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'creator_id',
								),
							),
						),
						'date_created' => array(
							'class'        => 'WordPoints_BP_Entity_Group_Date_Created',
							'data_type'    => 'mysql_datetime',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'date_created',
								),
							),
						),
						'description' => array(
							'class'        => 'WordPoints_BP_Entity_Group_Description',
							'data_type'    => 'text',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'description',
								),
							),
						),
						'name' => array(
							'class'        => 'WordPoints_BP_Entity_Group_Name',
							'data_type'    => 'text',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'name',
								),
							),
						),
						'parent' => array(
							'class'        => 'WordPoints_BP_Entity_Group_Parent',
							'primary'      => 'bp_group',
							'related'      => 'bp_group',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'parent_id',
								),
							),
						),
						'slug' => array(
							'class'        => 'WordPoints_BP_Entity_Group_Slug',
							'data_type'    => 'text',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'slug',
								),
							),
						),
						'status' => array(
							'class'        => 'WordPoints_BP_Entity_Group_Status',
							'data_type'    => 'text',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'status',
								),
							),
						),
					),
				),
			),
			'bp_activity' => array(
				array(
					'class'          => 'WordPoints_BP_Entity_Activity',
					'slug'           => 'bp_activity',
					'id_field'       => 'id',
					'get_human_id'   => array( $this, 'get_activity_human_id' ),
					'context'        => '',
					'storage_info'   => array(
						'type' => 'db',
						'info' => array(
							'type'       => 'table',
							'table_name' => buddypress()->activity->table_name,
						),
					),
					'the_context'    => array(),
					'create_func'    => array( $factory->bp->activity, 'create_and_get' ),
					'delete_func'    => 'bp_activity_delete_by_activity_id',
					'children'       => array(
						'date' => array(
							'class'        => 'WordPoints_BP_Entity_Activity_Date',
							'data_type'    => 'mysql_datetime',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'date_recorded',
								),
							),
						),
						'user' => array(
							'class'        => 'WordPoints_BP_Entity_Activity_User',
							'primary'      => 'bp_activity',
							'related'      => 'user',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'user_id',
								),
							),
						),
					),
				),
			),
			'bp_activity_update' => array(
				array(
					'class'          => 'WordPoints_BP_Entity_Activity_Update',
					'slug'           => 'bp_activity_update',
					'id_field'       => 'id',
					'get_human_id'   => array( $this, 'get_activity_human_id' ),
					'context'        => '',
					'storage_info'   => array(
						'type' => 'db',
						'info' => array(
							'type'       => 'table',
							'table_name' => buddypress()->activity->table_name,
						),
					),
					'the_context'    => array(),
					'create_func'    => array( $factory->bp->activity, 'create_and_get' ),
					'delete_func'    => 'bp_activity_delete_by_activity_id',
					'children'       => array(
						'author' => array(
							'class'        => 'WordPoints_BP_Entity_Activity_Update_Author',
							'primary'      => 'bp_activity_update',
							'related'      => 'user',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'user_id',
								),
							),
						),
						'content' => array(
							'class'        => 'WordPoints_BP_Entity_Activity_Update_Content',
							'data_type'    => 'text',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'content',
								),
							),
						),
						'date_posted' => array(
							'class'        => 'WordPoints_BP_Entity_Activity_Update_Date_Posted',
							'data_type'    => 'mysql_datetime',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'date_recorded',
								),
							),
						),
					),
				),
			),
			'bp_activity_comment' => array(
				array(
					'class'          => 'WordPoints_BP_Entity_Activity_Comment',
					'slug'           => 'bp_activity_update_update',
					'id_field'       => 'id',
					'get_human_id'   => array( $this, 'get_activity_human_id' ),
					'context'        => '',
					'storage_info'   => array(
						'type' => 'db',
						'info' => array(
							'type'       => 'table',
							'table_name' => buddypress()->activity->table_name,
						),
					),
					'the_context'    => array(),
					'create_func'    => array( $factory->bp->activity, 'create_and_get' ),
					'delete_func'    => 'bp_activity_delete_by_activity_id',
					'children'       => array(
						'activity' => array(
							'class'        => 'WordPoints_BP_Entity_Activity_Comment_Activity',
							'primary'      => 'bp_activity_comment',
							'related'      => 'bp_activity',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'item_id',
								),
							),
						),
						'author' => array(
							'class'        => 'WordPoints_BP_Entity_Activity_Comment_Author',
							'primary'      => 'bp_activity_comment',
							'related'      => 'user',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'user_id',
								),
							),
						),
						'content' => array(
							'class'        => 'WordPoints_BP_Entity_Activity_Update_Content',
							'data_type'    => 'text',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'content',
								),
							),
						),
						'date_posted' => array(
							'class'        => 'WordPoints_BP_Entity_Activity_Update_Date_Posted',
							'data_type'    => 'mysql_datetime',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'date_recorded',
								),
							),
						),
						'parent' => array(
							'class'        => 'WordPoints_BP_Entity_Activity_Comment_Parent',
							'primary'      => 'bp_activity_comment',
							'related'      => 'bp_activity_comment',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type'  => 'field',
									'field' => 'secondary_item_id',
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

		$message = new BP_Messages_Message( $message_id );

		$thread_id = messages_get_message_thread_id( $message_id );

		// BuddyPress only fully deletes the message once all recipients have marked
		// it as deleted.
		foreach ( $message->get_recipients() as $recipient ) {
			messages_delete_thread( $thread_id, $recipient->user_id );
		}
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

	/**
	 * Get the human ID for an activity.
	 *
	 * @since 1.0.0
	 *
	 * @param BP_Activity_Activity $activity The activity object.
	 *
	 * @return string The human ID for the activity.
	 */
	public function get_activity_human_id( $activity ) {

		// Back-compat for BuddyPress <2.8.
		if ( function_exists( 'bp_activity_get_excerpt_length' ) ) {

			$excerpt_length = bp_activity_get_excerpt_length();

		} else {

			/**
			 * Filters the excerpt length for the activity excerpt.
			 *
			 * @param int $length Character length for activity excerpts.
			 */
			$excerpt_length = (int) apply_filters( 'bp_activity_excerpt_length', 358 );
		}

		return trim(
			strip_tags( bp_create_excerpt( $activity->content, $excerpt_length ) )
		);
	}
}

// EOF
