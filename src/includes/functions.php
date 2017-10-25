<?php

/**
 * Functions of the extension.
 *
 * @package WordPoints_BuddyPress
 * @since 1.0.0
 */

//
// Messages Component.
//

/**
 * Register entities for the Messages component when the entities app is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-apps-entities
 *
 * @param WordPoints_App_Registry $entities The entities app.
 */
function wordpoints_bp_messages_entities_init( $entities ) {

	$children = $entities->get_sub_app( 'children' );

	$entities->register( 'bp_message', 'WordPoints_BP_Entity_Message' );
	$children->register( 'bp_message', 'content', 'WordPoints_BP_Entity_Message_Content' );
	$children->register( 'bp_message', 'date_sent', 'WordPoints_BP_Entity_Message_Date_Sent' );
	$children->register( 'bp_message', 'recipients', 'WordPoints_BP_Entity_Message_Recipients' );
	$children->register( 'bp_message', 'sender', 'WordPoints_BP_Entity_Message_Sender' );
	$children->register( 'bp_message', 'subject', 'WordPoints_BP_Entity_Message_Subject' );
}

/**
 * Register entity "know" restrictions for the Messages component.
 *
 * These are entities that are totally restricted, so that when the restriction
 * applies, the user is not even allowed to know that such an object exists.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-entities-restrictions-know
 *
 * @param WordPoints_Class_Registry_Deep_Multilevel $restrictions The restrictions
 *                                                                registry.
 */
function wordpoints_bp_messages_entity_restrictions_know_init( $restrictions ) {

	$restrictions->register(
		'thread_accessible'
		, array( 'bp_message' )
		, 'WordPoints_BP_Entity_Restriction_Message_Thread_Accessible'
	);
}

/**
 * Register hook actions for the Messages component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-actions
 *
 * @param WordPoints_Hook_Actions $actions The action registry.
 */
function wordpoints_bp_messages_hook_actions_init( $actions ) {

	$actions->register(
		'bp_message_send'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'messages_message_sent',
			'data'   => array(
				'arg_index' => array( 'bp_message' => 0 ),
			),
		)
	);
}

/**
 * Register hook events for the Messages component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-events
 *
 * @param WordPoints_Hook_Events $events The event registry.
 */
function wordpoints_bp_messages_hook_events_init( $events ) {

	$events->register(
		'bp_message_send'
		, 'WordPoints_BP_Hook_Event_Message_Send'
		, array(
			'actions' => array(
				// There is no "unsend" feature at present, so we don't register any
				// toggle_off actions. Unsending is different than deleting a sent
				// message, since the message won't be deleted for the recipient, so
				// the original action isn't really reversed.
				'toggle_on' => 'bp_message_send',
			),
			'args' => array(
				'bp_message' => 'WordPoints_Hook_Arg',
			),
		)
	);
}

//
// Friends Component.
//

/**
 * Register entities for the Friends component when the entities app is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-apps-entities
 *
 * @param WordPoints_App_Registry $entities The entities app.
 */
function wordpoints_bp_friends_entities_init( $entities ) {

	$children = $entities->get_sub_app( 'children' );

	$entities->register( 'bp_friendship', 'WordPoints_BP_Entity_Friendship' );
	$children->register( 'bp_friendship', 'date_created', 'WordPoints_BP_Entity_Friendship_Date_Created' );
	$children->register( 'bp_friendship', 'friend', 'WordPoints_BP_Entity_Friendship_Friend' );
	$children->register( 'bp_friendship', 'initiator', 'WordPoints_BP_Entity_Friendship_Initiator' );
}

/**
 * Register hook actions for the Friends component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-actions
 *
 * @param WordPoints_Hook_Actions $actions The action registry.
 */
function wordpoints_bp_friends_hook_actions_init( $actions ) {

	$actions->register(
		'bp_friendship_request'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'friends_friendship_requested',
			'data'   => array(
				// 0 is the ID, but 3 gives us the object itself.
				'arg_index' => array( 'bp_friendship' => 3 ),
			),
		)
	);

	$actions->register(
		'bp_friendship_withdraw'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'friends_friendship_withdrawn',
			'data'   => array(
				// 0 is the ID, but 1 gives us the object itself.
				'arg_index' => array( 'bp_friendship' => 1 ),
			),
		)
	);

	$actions->register(
		'bp_friendship_accept'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'friends_friendship_accepted',
			'data'   => array(
				// 0 is the ID, but 3 gives us the object itself.
				'arg_index' => array( 'bp_friendship' => 3 ),
			),
		)
	);

	$actions->register(
		'bp_friendship_delete'
		, 'WordPoints_Hook_Action'
		, array(
			// Despite the name, it fires before delete.
			'action' => 'friends_friendship_deleted',
			'data'   => array(
				'arg_index' => array( 'bp_friendship' => 0 ),
			),
		)
	);
}

/**
 * Register hook events for the Friends component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-events
 *
 * @param WordPoints_Hook_Events $events The event registry.
 */
function wordpoints_bp_friends_hook_events_init( $events ) {

	$events->register(
		'bp_friendship_request'
		, 'WordPoints_BP_Hook_Event_Friendship_Request'
		, array(
			'actions' => array(
				'toggle_on'  => 'bp_friendship_request',
				'toggle_off' => 'bp_friendship_withdraw',
			),
			'args' => array(
				'bp_friendship' => 'WordPoints_Hook_Arg',
			),
		)
	);

	$events->register(
		'bp_friendship_accept'
		, 'WordPoints_BP_Hook_Event_Friendship_Accept'
		, array(
			'actions' => array(
				'toggle_on'  => 'bp_friendship_accept',
				'toggle_off' => 'bp_friendship_delete',
			),
			'args' => array(
				'bp_friendship' => 'WordPoints_Hook_Arg',
			),
		)
	);
}

//
// Groups Component.
//

/**
 * Register entities for the Groups component when the entities app is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-apps-entities
 *
 * @param WordPoints_App_Registry $entities The entities app.
 */
function wordpoints_bp_groups_entities_init( $entities ) {

	$children = $entities->get_sub_app( 'children' );

	$entities->register( 'bp_group', 'WordPoints_BP_Entity_Group' );
	$children->register( 'bp_group', 'creator', 'WordPoints_BP_Entity_Group_Creator' );
	$children->register( 'bp_group', 'date_created', 'WordPoints_BP_Entity_Group_Date_Created' );
	$children->register( 'bp_group', 'description', 'WordPoints_BP_Entity_Group_Description' );
	$children->register( 'bp_group', 'name', 'WordPoints_BP_Entity_Group_Name' );
	$children->register( 'bp_group', 'parent', 'WordPoints_BP_Entity_Group_Parent' );
	$children->register( 'bp_group', 'slug', 'WordPoints_BP_Entity_Group_Slug' );
	$children->register( 'bp_group', 'status', 'WordPoints_BP_Entity_Group_Status' );

	if ( bp_is_active( 'activity' ) ) {
		$entities->register( 'bp_group_activity_update', 'WordPoints_BP_Entity_Activity_Update' );
		$children->register( 'bp_group_activity_update', 'author', 'WordPoints_BP_Entity_Activity_Update_Author' );
		$children->register( 'bp_group_activity_update', 'content', 'WordPoints_BP_Entity_Activity_Update_Content' );
		$children->register( 'bp_group_activity_update', 'date_posted', 'WordPoints_BP_Entity_Activity_Update_Date_Posted' );
		$children->register( 'bp_group_activity_update', 'group', 'WordPoints_BP_Entity_Group_Activity_Update_Group' );
	}
}

/**
 * Register entity "know" restrictions for the Groups component.
 *
 * These are entities that are totally restricted, so that when the restriction
 * applies, the user is not even allowed to know that such an object exists.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-entities-restrictions-know
 *
 * @param WordPoints_Class_Registry_Deep_Multilevel $restrictions The restrictions
 *                                                                registry.
 */
function wordpoints_bp_groups_entity_restrictions_know_init( $restrictions ) {

	$restrictions->register(
		'status_nonpublic'
		, array( 'bp_group' )
		, 'WordPoints_BP_Entity_Restriction_Group_Status_Nonpublic'
	);

	if ( bp_is_active( 'activity' ) ) {
		$restrictions->register(
			'hidden'
			, array( 'bp_group_activity_update' )
			, 'WordPoints_BP_Entity_Restriction_Activity_Hidden'
		);

		$restrictions->register(
			'spam'
			, array( 'bp_group_activity_update' )
			, 'WordPoints_BP_Entity_Restriction_Activity_Spam'
		);
	}
}

/**
 * Register hook actions for the Groups component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-actions
 *
 * @param WordPoints_Hook_Actions $actions The action registry.
 */
function wordpoints_bp_groups_hook_actions_init( $actions ) {

	$actions->register(
		'bp_group_create'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_create_group',
			'data'   => array(
				// 0 is the ID, but 2 gives us the object itself.
				'arg_index' => array( 'bp_group' => 2 ),
			),
		)
	);

	$actions->register(
		'bp_group_delete'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_before_delete_group',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_group_join'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_join_group',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0, 'user' => 1 ),
			),
		)
	);

	$actions->register(
		'bp_group_leave'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_leave_group',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0, 'user' => 1 ),
			),
		)
	);

	$actions->register(
		'bp_group_member_ban'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_ban_member',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0, 'user' => 1 ),
			),
		)
	);

	$actions->register(
		'bp_group_member_unban'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_unban_member',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0, 'user' => 1 ),
			),
		)
	);

	$actions->register(
		'bp_group_member_remove'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_remove_member',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0, 'user' => 1 ),
			),
		)
	);

	$actions->register(
		'bp_group_delete_member_remove'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'wordpoints_bp_groups_delete_group_remove_member',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0, 'user' => 1 ),
			),
		)
	);

	$actions->register(
		'bp_group_member_promote_to_mod'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_promote_member',
			'data'   => array(
				'arg_index'    => array( 'bp_group' => 0, 'user' => 1 ),
				'requirements' => array( 2 => 'mod' ),
			),
		)
	);

	$actions->register(
		'bp_group_member_promote_to_admin'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_promote_member',
			'data'   => array(
				'arg_index'    => array( 'bp_group' => 0, 'user' => 1 ),
				'requirements' => array( 2 => 'admin' ),
			),
		)
	);

	$actions->register(
		'bp_group_member_demote'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_demote_member',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0, 'user' => 1 ),
			),
		)
	);

	$actions->register(
		'bp_group_invite_user'
		, 'WordPoints_BP_Hook_Action_Group_Invite_User'
		, array(
			'action' => 'groups_invite_user',
		)
	);

	$actions->register(
		'bp_group_uninvite_user'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_uninvite_user',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0, 'user' => 1 ),
			),
		)
	);

	$actions->register(
		'bp_group_invite_accept'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_accept_invite',
			'data'   => array(
				'arg_index' => array( 'user' => 0, 'bp_group' => 1, 'inviter:user' => 2 ),
			),
		)
	);

	$actions->register(
		'bp_group_invite_delete'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_delete_invite',
			'data'   => array(
				'arg_index' => array( 'user' => 0, 'bp_group' => 1 ),
			),
		)
	);

	$actions->register(
		'bp_group_membership_request_send'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_membership_requested',
			'data'   => array(
				'arg_index' => array( 'user' => 0, 'bp_group' => 2 ),
			),
		)
	);

	$actions->register(
		'bp_group_membership_request_accept'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_membership_accepted',
			'data'   => array(
				'arg_index' => array( 'user' => 0, 'bp_group' => 1 ),
			),
		)
	);

	// Not currently used, but still registered for the benefit of custom events.
	$actions->register(
		'bp_group_avatar_upload'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_avatar_uploaded',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_group_avatar_set'
		, 'WordPoints_BP_Hook_Action_Avatar_Set'
		, array(
			'action' => 'groups_avatar_uploaded',
			'data'   => array(
				'arg_index'             => array( 'bp_group' => 0 ),
				'bp_avatar_object_type' => 'bp_group',
			),
		)
	);

	$actions->register(
		'bp_group_avatar_delete'
		, 'WordPoints_BP_Hook_Action_Avatar_Delete'
		, array(
			'action' => 'bp_core_delete_existing_avatar',
			'data'   => array(
				'bp_avatar_object_type' => 'bp_group',
			),
		)
	);

	$actions->register(
		'bp_group_cover_image_upload'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_cover_image_uploaded',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_group_cover_image_delete'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'groups_cover_image_deleted',
			'data'   => array(
				'arg_index' => array( 'bp_group' => 0 ),
			),
		)
	);

	if ( bp_is_active( 'activity' ) ) {

		$actions->register(
			'bp_group_activity_update_post'
			, 'WordPoints_Hook_Action'
			, array(
				'action' => 'bp_groups_posted_update',
				'data'   => array(
					'arg_index' => array( 'bp_group_activity_update' => 3 ),
				),
			)
		);

		$actions->register(
			'bp_group_activity_update_ham'
			, 'WordPoints_BP_Hook_Action_Group_Activity_Update'
			, array(
				'action' => 'bp_activity_mark_as_ham',
				'data'   => array(
					'arg_index' => array( 'bp_group_activity_update' => 0 ),
				),
			)
		);

		$actions->register(
			'bp_group_activity_update_spam'
			, 'WordPoints_BP_Hook_Action_Group_Activity_Update'
			, array(
				'action' => 'bp_activity_mark_as_spam',
				'data'   => array(
					'arg_index' => array( 'bp_group_activity_update' => 0 ),
				),
			)
		);

		$actions->register(
			'bp_group_activity_update_delete'
			, 'WordPoints_BP_Hook_Action_Group_Activity_Update'
			, array(
				'action' => 'wordpoints_bp_activity_before_delete_activity_update',
				'data'   => array(
					'arg_index' => array( 'bp_group_activity_update' => 0 ),
				),
			)
		);

	} // End if ( BuddyPress activity component is active ).
}

/**
 * Register hook events for the Groups component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-events
 *
 * @param WordPoints_Hook_Events $events The event registry.
 */
function wordpoints_bp_groups_hook_events_init( $events ) {

	$events->register(
		'bp_group_create'
		, 'WordPoints_BP_Hook_Event_Group_Create'
		, array(
			'actions' => array(
				'toggle_on'  => 'bp_group_create',
				'toggle_off' => 'bp_group_delete',
			),
			'args' => array(
				'bp_group' => 'WordPoints_Hook_Arg',
			),
		)
	);

	// Support for multiple signature args was added in WordPoints 2.3.0-alpha-2.
	// See https://github.com/WordPoints/wordpoints/issues/594.
	if ( version_compare( WORDPOINTS_VERSION, '2.3.0-alpha-1', '>' ) ) {

		$events->register(
			'bp_group_join'
			, 'WordPoints_BP_Hook_Event_Group_Join'
			, array(
				'actions' => array(
					'toggle_on'  => array(
						'bp_group_join',
						'bp_group_member_unban',
					),
					'toggle_off' => array(
						'bp_group_leave',
						'bp_group_member_ban',
						'bp_group_member_remove',
						'bp_group_delete_member_remove',
					),
				),
				'args'    => array(
					'bp_group' => 'WordPoints_Hook_Arg',
					'user'     => 'WordPoints_Hook_Arg',
				),
			)
		);

		$events->register(
			'bp_group_member_promote_to_admin'
			, 'WordPoints_BP_Hook_Event_Group_Member_Promote_To_Admin'
			, array(
				'actions' => array(
					'toggle_on'  => array(
						'bp_group_member_promote_to_admin',
					),
					'toggle_off' => array(
						'bp_group_member_demote',
						'bp_group_leave',
						'bp_group_member_ban',
						'bp_group_member_remove',
						'bp_group_delete_member_remove',
					),
				),
				'args'    => array(
					'bp_group'     => 'WordPoints_Hook_Arg',
					'user'         => 'WordPoints_Hook_Arg',
					'current:user' => 'WordPoints_BP_Hook_Arg_User_Promoter',
				),
			)
		);

		$events->register(
			'bp_group_member_promote_to_mod'
			, 'WordPoints_BP_Hook_Event_Group_Member_Promote_To_Mod'
			, array(
				'actions' => array(
					'toggle_on'  => array(
						'bp_group_member_promote_to_mod',
					),
					'toggle_off' => array(
						'bp_group_member_demote',
						'bp_group_leave',
						'bp_group_member_ban',
						'bp_group_member_remove',
						'bp_group_delete_member_remove',
					),
				),
				'args'    => array(
					'bp_group'     => 'WordPoints_Hook_Arg',
					'user'         => 'WordPoints_Hook_Arg',
					'current:user' => 'WordPoints_BP_Hook_Arg_User_Promoter',
				),
			)
		);

		$events->register(
			'bp_group_invite_send'
			, 'WordPoints_BP_Hook_Event_Group_Invite_Send'
			, array(
				'actions' => array(
					'toggle_on'  => array(
						'bp_group_invite_user',
					),
					'toggle_off' => array(
						'bp_group_uninvite_user',
						'bp_group_invite_delete',
					),
				),
				'args'    => array(
					'bp_group'     => 'WordPoints_Hook_Arg',
					'user'         => 'WordPoints_Hook_Arg',
					'inviter:user' => 'WordPoints_BP_Hook_Arg_User_Inviter',
				),
			)
		);

		$events->register(
			'bp_group_invite_accept'
			, 'WordPoints_BP_Hook_Event_Group_Invite_Accept'
			, array(
				'actions' => array(
					'toggle_on'  => array(
						'bp_group_invite_accept',
					),
					'toggle_off' => array(
						'bp_group_leave',
						'bp_group_member_remove',
					),
				),
				// The inviter arg wasn't added until BuddyPress 2.8.0.
				// See https://buddypress.trac.wordpress.org/ticket/7410.
				'args'    => ( version_compare( buddypress()->version, '2.8.0-alpha', '>=' )
					? array(
						'bp_group'     => 'WordPoints_Hook_Arg',
						'user'         => 'WordPoints_Hook_Arg',
						'inviter:user' => 'WordPoints_BP_Hook_Arg_User_Inviter',
					)
					: array(
						'bp_group' => 'WordPoints_Hook_Arg',
						'user'     => 'WordPoints_Hook_Arg',
					)
				),
			)
		);

		$events->register(
			'bp_group_membership_request_send'
			, 'WordPoints_BP_Hook_Event_Group_Membership_Request_Send'
			, array(
				'actions' => array(
					// Currently there is no way to withdraw a request, so there is
					// no toggle_off action.
					'toggle_on' => 'bp_group_membership_request_send',
				),
				'args'    => array(
					'bp_group' => 'WordPoints_Hook_Arg',
					'user'     => 'WordPoints_Hook_Arg',
				),
			)
		);

		$events->register(
			'bp_group_membership_request_accept'
			, 'WordPoints_BP_Hook_Event_Group_Membership_Request_Accept'
			, array(
				'actions' => array(
					'toggle_on'  => 'bp_group_membership_request_accept',
					'toggle_off' => array(
						'bp_group_leave',
						'bp_group_member_remove',
					),
				),
				'args'    => array(
					'bp_group'     => 'WordPoints_Hook_Arg',
					'user'         => 'WordPoints_Hook_Arg',
					'current:user' => 'WordPoints_BP_Hook_Arg_User_Accepting',
				),
			)
		);

	} // End if ( WordPoints 2.3.0-alpha-2+ ).

	// Group avatar uploads can be disabled.
	// The group avatar upload action was added to BuddyPress in 2.8.0.
	// See https://buddypress.trac.wordpress.org/changeset/11314.
	if ( ! bp_disable_group_avatar_uploads() && version_compare( buddypress()->version, '2.8.0-alpha', '>=' ) ) {

		$events->register(
			'bp_group_avatar_upload'
			, 'WordPoints_BP_Hook_Event_Group_Avatar_Upload'
			, array(
				'actions' => array(
					'toggle_on'  => 'bp_group_avatar_set',
					'toggle_off' => 'bp_group_avatar_delete',
				),
				'args' => array(
					'bp_group'     => 'WordPoints_Hook_Arg',
					'current:user' => 'WordPoints_BP_Hook_Arg_User_Uploading',
				),
			)
		);
	}

	// Cover image uploads can be disabled.
	// The cover image delete action was only added in BuddyPress 2.8.0.
	// See https://buddypress.trac.wordpress.org/ticket/7409.
	if ( ! bp_disable_group_cover_image_uploads() && version_compare( buddypress()->version, '2.8.0-alpha', '>=' ) ) {

		$events->register(
			'bp_group_cover_image_upload'
			, 'WordPoints_BP_Hook_Event_Group_Cover_Image_Upload'
			, array(
				'actions' => array(
					'toggle_on'  => 'bp_group_cover_image_upload',
					'toggle_off' => 'bp_group_cover_image_delete',
				),
				'args' => array(
					'bp_group'     => 'WordPoints_Hook_Arg',
					'current:user' => 'WordPoints_BP_Hook_Arg_User_Uploading',
				),
			)
		);
	}

	if ( bp_is_active( 'activity' ) ) {

		$events->register(
			'bp_group_activity_update_post'
			, 'WordPoints_BP_Hook_Event_Group_Activity_Update_Post'
			, array(
				'actions' => array(
					'toggle_on'  => array(
						'bp_group_activity_update_post',
						'bp_group_activity_update_ham',
					),
					'toggle_off' => array(
						'bp_group_activity_update_delete',
						'bp_group_activity_update_spam',
					),
				),
				'args' => array(
					'bp_group_activity_update' => 'WordPoints_Hook_Arg',
				),
			)
		);
	}
}

/**
 * Splits the delete group action to fire for each user that was a member.
 *
 * @since 1.0.0
 *
 * @param BP_Groups_Group $group    The group object.
 * @param int[]           $user_ids The IDs of the users.
 */
function wordpoints_bp_groups_split_delete_group_action( $group, $user_ids ) {

	foreach ( $user_ids as $user_id ) {

		/**
		 * Fires for each user that is a member of a group that is being deleted.
		 *
		 * @since 1.0.0
		 *
		 * @param BP_Groups_Group $group    The group object.
		 * @param int[]           $user_ids The IDs of the users.
		 */
		do_action( 'wordpoints_bp_groups_delete_group_remove_member', $group, $user_id );
	}
}

//
// Activity Component.
//

/**
 * Register entities for the Activity component when the entities app is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-apps-entities
 *
 * @param WordPoints_App_Registry $entities The entities app.
 */
function wordpoints_bp_activity_entities_init( $entities ) {

	$children = $entities->get_sub_app( 'children' );

	$entities->register( 'bp_activity', 'WordPoints_BP_Entity_Activity' );
	$children->register( 'bp_activity', 'date', 'WordPoints_BP_Entity_Activity_Date' );
	$children->register( 'bp_activity', 'user', 'WordPoints_BP_Entity_Activity_User' );

	$entities->register( 'bp_activity_update', 'WordPoints_BP_Entity_Activity_Update' );
	$children->register( 'bp_activity_update', 'author', 'WordPoints_BP_Entity_Activity_Update_Author' );
	$children->register( 'bp_activity_update', 'content', 'WordPoints_BP_Entity_Activity_Update_Content' );
	$children->register( 'bp_activity_update', 'date_posted', 'WordPoints_BP_Entity_Activity_Update_Date_Posted' );

	$entities->register( 'bp_activity_comment', 'WordPoints_BP_Entity_Activity_Comment' );
	$children->register( 'bp_activity_comment', 'activity', 'WordPoints_BP_Entity_Activity_Comment_Activity' );
	$children->register( 'bp_activity_comment', 'author', 'WordPoints_BP_Entity_Activity_Comment_Author' );
	$children->register( 'bp_activity_comment', 'content', 'WordPoints_BP_Entity_Activity_Update_Content' );
	$children->register( 'bp_activity_comment', 'date_posted', 'WordPoints_BP_Entity_Activity_Update_Date_Posted' );
	$children->register( 'bp_activity_comment', 'parent', 'WordPoints_BP_Entity_Activity_Comment_Parent' );
}

/**
 * Register entity "know" restrictions for the Activity component.
 *
 * These are entities that are totally restricted, so that when the restriction
 * applies, the user is not even allowed to know that such an object exists.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-entities-restrictions-know
 *
 * @param WordPoints_Class_Registry_Deep_Multilevel $restrictions The restrictions
 *                                                                registry.
 */
function wordpoints_bp_activity_entity_restrictions_know_init( $restrictions ) {

	$restrictions->register(
		'hidden'
		, array( 'bp_activity' )
		, 'WordPoints_BP_Entity_Restriction_Activity_Hidden'
	);

	$restrictions->register(
		'spam'
		, array( 'bp_activity' )
		, 'WordPoints_BP_Entity_Restriction_Activity_Spam'
	);

	$restrictions->register(
		'hidden'
		, array( 'bp_activity_update' )
		, 'WordPoints_BP_Entity_Restriction_Activity_Hidden'
	);

	$restrictions->register(
		'spam'
		, array( 'bp_activity_update' )
		, 'WordPoints_BP_Entity_Restriction_Activity_Spam'
	);

	$restrictions->register(
		'hidden'
		, array( 'bp_activity_comment' )
		, 'WordPoints_BP_Entity_Restriction_Activity_Hidden'
	);

	$restrictions->register(
		'spam'
		, array( 'bp_activity_comment' )
		, 'WordPoints_BP_Entity_Restriction_Activity_Spam'
	);
}

/**
 * Register hook actions for the Activity component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-actions
 *
 * @param WordPoints_Hook_Actions $actions The action registry.
 */
function wordpoints_bp_activity_hook_actions_init( $actions ) {

	// Activity update.
	$actions->register(
		'bp_activity_update_post'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'bp_activity_posted_update',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update' => 2 ),
			),
		)
	);

	$actions->register(
		'bp_activity_update_spam'
		, 'WordPoints_BP_Hook_Action_Activity_Type'
		, array(
			'action' => 'bp_activity_mark_as_spam',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_activity_update_ham'
		, 'WordPoints_BP_Hook_Action_Activity_Type'
		, array(
			'action' => 'bp_activity_mark_as_ham',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_activity_update_delete'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'wordpoints_bp_activity_before_delete_activity_update',
			'data'   => array(
				'arg_index' => array( 'bp_activity_update' => 0 ),
			),
		)
	);

	// Activity update comment.
	$actions->register(
		'bp_activity_comment_post'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'bp_activity_comment_posted',
			'data'   => array(
				'arg_index' => array( 'bp_activity_comment' => 0 ),
			),
		)
	);

	// See https://github.com/WordPoints/wordpoints/issues/592.
	wordpoints_hooks()->get_sub_app( 'router' )->add_action(
		'bp_activity_comment_post'
		, array(
			'action' => 'bp_activity_comment_posted_notification_skipped',
			'data'   => array(
				'arg_index' => array( 'bp_activity_comment' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_activity_comment_spam'
		, 'WordPoints_BP_Hook_Action_Activity_Type'
		, array(
			'action' => 'bp_activity_mark_as_spam',
			'data'   => array(
				'arg_index'     => array( 'bp_activity_comment' => 0 ),
				'activity_type' => 'activity_comment',
			),
		)
	);

	$actions->register(
		'bp_activity_comment_ham'
		, 'WordPoints_BP_Hook_Action_Activity_Type'
		, array(
			'action' => 'bp_activity_mark_as_ham',
			'data'   => array(
				'arg_index'     => array( 'bp_activity_comment' => 0 ),
				'activity_type' => 'activity_comment',
			),
		)
	);

	$actions->register(
		'bp_activity_comment_delete'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'wordpoints_bp_activity_before_delete_activity_comment',
			'data'   => array(
				'arg_index' => array( 'bp_activity_comment' => 0 ),
			),
		)
	);

	// Favorite activity.
	$actions->register(
		'bp_activity_favorite'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'bp_activity_add_user_favorite',
			'data'   => array(
				'arg_index' => array( 'bp_activity' => 0, 'user' => 1 ),
			),
		)
	);

	$actions->register(
		'bp_activity_defavorite'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'bp_activity_remove_user_favorite',
			'data'   => array(
				'arg_index' => array( 'bp_activity' => 0, 'user' => 1 ),
			),
		)
	);
}

/**
 * Register hook events for the Activity component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-events
 *
 * @param WordPoints_Hook_Events $events The event registry.
 */
function wordpoints_bp_activity_hook_events_init( $events ) {

	$events->register(
		'bp_activity_update_post'
		, 'WordPoints_BP_Hook_Event_Activity_Update_Post'
		, array(
			'actions' => array(
				'toggle_on'  => array(
					'bp_activity_update_post',
					'bp_activity_update_ham',
				),
				'toggle_off' => array(
					'bp_activity_update_delete',
					'bp_activity_update_spam',
				),
			),
			'args' => array(
				'bp_activity_update' => 'WordPoints_Hook_Arg',
			),
		)
	);

	$events->register(
		'bp_activity_comment_post'
		, 'WordPoints_BP_Hook_Event_Activity_Comment_Post'
		, array(
			'actions' => array(
				'toggle_on'  => array(
					'bp_activity_comment_post',
					'bp_activity_comment_ham',
				),
				'toggle_off' => array(
					'bp_activity_comment_delete',
					'bp_activity_comment_spam',
				),
			),
			'args' => array(
				'bp_activity_comment' => 'WordPoints_Hook_Arg',
			),
		)
	);

	// Support for multiple signature args was added in WordPoints 2.3.0-alpha-2.
	// See https://github.com/WordPoints/wordpoints/issues/594.
	if ( version_compare( WORDPOINTS_VERSION, '2.3.0-alpha-1', '>' ) ) {

		$events->register(
			'bp_activity_favorite'
			, 'WordPoints_BP_Hook_Event_Activity_Favorite'
			, array(
				'actions' => array(
					'toggle_on'  => 'bp_activity_favorite',
					'toggle_off' => 'bp_activity_defavorite',
				),
				'args'    => array(
					'bp_activity' => 'WordPoints_Hook_Arg',
					'user'        => 'WordPoints_Hook_Arg',
				),
			)
		);
	}
}

/**
 * Splits the 'bp_activity_before_delete' action by for each activity individually.
 *
 * @since 1.0.0
 *
 * @WordPress\action bp_activity_before_delete
 *
 * @param object[] $activities The activities being deleted.
 */
function wordpoints_bp_activity_split_before_delete_action( $activities ) {

	foreach ( $activities as $activity ) {

		if ( 'activity_update' === $activity->type ) {

			/**
			 * Fires for an activity update before it is deleted.
			 *
			 * @since 1.0.0
			 *
			 * @param object $activity The activity object.
			 */
			do_action(
				'wordpoints_bp_activity_before_delete_activity_update'
				, $activity
			);

		} elseif ( 'activity_comment' === $activity->type ) {

			/**
			 * Fires for an activity comment before it is deleted.
			 *
			 * @since 1.0.0
			 *
			 * @param object $activity The activity object.
			 */
			do_action(
				'wordpoints_bp_activity_before_delete_activity_comment'
				, $activity
			);
		}
	}
}

//
// xProfile Component
//

/**
 * Register hook actions for the xProfile component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-actions
 *
 * @param WordPoints_Hook_Actions $actions The action registry.
 */
function wordpoints_bp_xprofile_hook_actions_init( $actions ) {

	// This is not currently used, but is here for back-compat for custom events.
	$actions->register(
		'bp_xprofile_avatar_upload'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'xprofile_avatar_uploaded',
			'data'   => array(
				'arg_index' => array( 'user' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_xprofile_avatar_set'
		, 'WordPoints_BP_Hook_Action_Avatar_Set'
		, array(
			'action' => 'xprofile_avatar_uploaded',
			'data'   => array(
				'arg_index' => array( 'user' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_xprofile_avatar_delete'
		, 'WordPoints_BP_Hook_Action_Avatar_Delete'
		, array(
			'action' => 'bp_core_delete_existing_avatar',
		)
	);

	// This is not currently used, but is here for back-compat for custom events.
	$actions->register(
		'bp_xprofile_cover_image_upload'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'xprofile_cover_image_uploaded',
			'data'   => array(
				'arg_index' => array( 'user' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_xprofile_cover_image_set'
		, 'WordPoints_BP_Hook_Action_Cover_Image_Set'
		, array(
			'action' => 'xprofile_cover_image_uploaded',
			'data'   => array(
				'arg_index' => array( 'user' => 0 ),
			),
		)
	);

	$actions->register(
		'bp_xprofile_cover_image_delete'
		, 'WordPoints_Hook_Action'
		, array(
			'action' => 'xprofile_cover_image_deleted',
			'data'   => array(
				'arg_index' => array( 'user' => 0 ),
			),
		)
	);
}

/**
 * Register hook events for the xProfile component when the registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-events
 *
 * @param WordPoints_Hook_Events $events The event registry.
 */
function wordpoints_bp_xprofile_hook_events_init( $events ) {

	// xProfile avatar uploads can be disabled.
	if ( ! bp_disable_avatar_uploads() ) {

		$events->register(
			'bp_xprofile_avatar_upload'
			, 'WordPoints_BP_Hook_Event_XProfile_Avatar_Upload'
			, array(
				'actions' => array(
					'toggle_on'  => 'bp_xprofile_avatar_set',
					'toggle_off' => 'bp_xprofile_avatar_delete',
				),
				'args' => array(
					'user' => 'WordPoints_Hook_Arg',
				),
			)
		);
	}

	// Cover image uploads can be disabled.
	// The cover image delete action was only added in BuddyPress 2.8.0.
	// See https://buddypress.trac.wordpress.org/ticket/7409.
	if ( ! bp_disable_cover_image_uploads() && version_compare( buddypress()->version, '2.8.0-alpha', '>=' ) ) {

		$events->register(
			'bp_xprofile_cover_image_upload'
			, 'WordPoints_BP_Hook_Event_XProfile_Cover_Image_Upload'
			, array(
				'actions' => array(
					'toggle_on'  => 'bp_xprofile_cover_image_set',
					'toggle_off' => 'bp_xprofile_cover_image_delete',
				),
				'args' => array(
					'user' => 'WordPoints_Hook_Arg',
				),
			)
		);
	}
}

// EOF
