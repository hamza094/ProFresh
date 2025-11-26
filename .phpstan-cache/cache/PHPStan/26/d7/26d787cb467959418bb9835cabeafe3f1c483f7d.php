<?php declare(strict_types = 1);

// odsl-D:\apps\profresh\tests
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v1',
   'data' => 
  array (
    'D:\\apps\\profresh\\tests\\CreatesApplication.php' => 
    array (
      0 => '2775c0216b5ae4e1eaaafa4ead322c18ad450131',
      1 => 
      array (
        0 => 'tests\\createsapplication',
      ),
      2 => 
      array (
        0 => 'tests\\createapplication',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Actions\\ZoomActionTest.php' => 
    array (
      0 => '6f06aa8ac579f0b7359444bb3a705cd67654cfa6',
      1 => 
      array (
        0 => 'tests\\feature\\api\\actions\\zoomactiontest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\actions\\setup',
        1 => 'tests\\feature\\api\\actions\\it_generates_a_valid_jwt_token',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Auth\\AuthenticationTest.php' => 
    array (
      0 => '87c56e92a68b9a31a05c4466fa1c2034a137882e',
      1 => 
      array (
        0 => 'tests\\feature\\api\\auth\\authenticationtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\auth\\setup',
        1 => 'tests\\feature\\api\\auth\\register_new_user',
        2 => 'tests\\feature\\api\\auth\\return_user_and_access_token_after_successful_login',
        3 => 'tests\\feature\\api\\auth\\show_validation_email_error',
        4 => 'tests\\feature\\api\\auth\\show_validation_password_errors',
        5 => 'tests\\feature\\api\\auth\\authenticated_user_can_logout',
        6 => 'tests\\feature\\api\\auth\\registration_with_existing_email_not_allowed',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Auth\\OAuthTest.php' => 
    array (
      0 => '52b7219e32306541548c52a0899814b2496db5db',
      1 => 
      array (
        0 => 'tests\\feature\\api\\auth\\oauthtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\auth\\test_o_auth_redirect',
        1 => 'tests\\feature\\api\\auth\\give_old_user_if_its_present',
        2 => 'tests\\feature\\api\\auth\\test_o_auth_callback',
        3 => 'tests\\feature\\api\\auth\\mocksocialite',
        4 => 'tests\\feature\\api\\auth\\performoauthcallback',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Auth\\ResetPasswordTest.php' => 
    array (
      0 => '70b6ce5c24ded19830f28b2d70d1a10dd01a99fa',
      1 => 
      array (
        0 => 'tests\\feature\\api\\auth\\resetpasswordtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\auth\\can_sends_password_reset_email',
        1 => 'tests\\feature\\api\\auth\\user_reset_their_password',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Auth\\TwoFactorAuthenticationTest.php' => 
    array (
      0 => '7e02d0b7aefe8124a3578ab4a263df051b4cb823',
      1 => 
      array (
        0 => 'tests\\feature\\api\\auth\\twofactorauthenticationtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\auth\\setup',
        1 => 'tests\\feature\\api\\auth\\teardown',
        2 => 'tests\\feature\\api\\auth\\it_returns_2fa_status_disabled_by_default',
        3 => 'tests\\feature\\api\\auth\\it_can_prepare_two_factor',
        4 => 'tests\\feature\\api\\auth\\it_can_confirm_two_factor',
        5 => 'tests\\feature\\api\\auth\\it_can_show_and_regenerate_recovery_codes',
        6 => 'tests\\feature\\api\\auth\\it_can_disable_two_factor',
        7 => 'tests\\feature\\api\\auth\\it_shows_2fa_required_message_during_login_when_enabled',
        8 => 'tests\\feature\\api\\auth\\it_fails_two_factor_login_with_missing_session',
        9 => 'tests\\feature\\api\\auth\\it_fails_two_factor_login_with_expired_session',
        10 => 'tests\\feature\\api\\auth\\createtestuser',
        11 => 'tests\\feature\\api\\auth\\enabletwofactorforuser',
        12 => 'tests\\feature\\api\\auth\\createmockeduser',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Auth\\VerificationTest.php' => 
    array (
      0 => 'e25008cd102c64586344f29f804115c80b8f5450',
      1 => 
      array (
        0 => 'tests\\feature\\api\\auth\\verificationtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\auth\\can_verify_email',
        1 => 'tests\\feature\\api\\auth\\can_not_verify_if_already_verified',
        2 => 'tests\\feature\\api\\auth\\can_resend_verification_notification',
        3 => 'tests\\feature\\api\\auth\\can_not_resend_verification_notification_if_email_already_verified',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Controllers\\OAuth\\ZoomController\\CallbackTest.php' => 
    array (
      0 => '1dc407b1d75abad59f0589755eda7b19be37a30f',
      1 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\oauth\\zoomcontroller\\callbacktest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\oauth\\zoomcontroller\\user_can_complete_connection_to_zoom',
        1 => 'tests\\feature\\api\\controllers\\oauth\\zoomcontroller\\error_is_returned_if_the_authorization_fails',
        2 => 'tests\\feature\\api\\controllers\\oauth\\zoomcontroller\\error_is_returned_if_the_code_is_missing_from_the_request',
        3 => 'tests\\feature\\api\\controllers\\oauth\\zoomcontroller\\assertuserwasnotupdated',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Controllers\\OAuth\\ZoomController\\RedirectTest.php' => 
    array (
      0 => '02b447248497533f670d03674f18228a6e32fda8',
      1 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\oauth\\zoomcontroller\\redirecttest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\oauth\\zoomcontroller\\user_is_redirected_to_zoom',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Controllers\\Paddle\\SubscriptionTest.php' => 
    array (
      0 => '2c408bf22007b547b876c4f1adfe727a7c0e1bb3',
      1 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\paddle\\subscriptiontest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\paddle\\setup',
        1 => 'tests\\feature\\api\\controllers\\paddle\\it_creates_a_paylink_for_subscription',
        2 => 'tests\\feature\\api\\controllers\\paddle\\it_swaps_a_subscription_plan',
        3 => 'tests\\feature\\api\\controllers\\paddle\\it_cancels_a_subscription',
        4 => 'tests\\feature\\api\\controllers\\paddle\\it_denies_access_for_non_subscribed_users',
        5 => 'tests\\feature\\api\\controllers\\paddle\\it_fails_validation_for_invalid_plan',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Controllers\\Webhooks\\ZoomWebhookControllerTest.php' => 
    array (
      0 => 'a3926da48e0351e3622b892f8ad36599ce23a0d4',
      1 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\webhooks\\zoomwebhookcontrollertest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\webhooks\\setup',
        1 => 'tests\\feature\\api\\controllers\\webhooks\\meeting_can_be_updated_via_webhook',
        2 => 'tests\\feature\\api\\controllers\\webhooks\\meeting_can_be_deleted',
        3 => 'tests\\feature\\api\\controllers\\webhooks\\zoom_meeting_can_be_started',
        4 => 'tests\\feature\\api\\controllers\\webhooks\\zoom_meeting_can_be_ended',
        5 => 'tests\\feature\\api\\controllers\\webhooks\\error_is_returned_if_the_request_was_not_sent_from_zoom',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Controllers\\Zoom\\DeleteMeetingTest.php' => 
    array (
      0 => 'e50d5216cd9aa49eea087b322239ce35fcf39bf1',
      1 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\zoom\\deletemeetingtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\zoom\\meeting_can_be_deleted',
        1 => 'tests\\feature\\api\\controllers\\zoom\\database_changes_are_rolled_back_if_meeting_delete_fails',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Controllers\\Zoom\\GetZakTokenTest.php' => 
    array (
      0 => 'eef68df123a5a648ce662b306c03c5b968087e80',
      1 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\zoom\\getzaktokentest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\zoom\\successfully_get_zak_token',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Controllers\\Zoom\\StoreMeetingTest.php' => 
    array (
      0 => '8bbb30bea232029b0954d2de47262ecd4a8a9311',
      1 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\zoom\\storemeetingtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\zoom\\meeting_can_be_created_successfully',
        1 => 'tests\\feature\\api\\controllers\\zoom\\user_get_exception_if_error_occurs',
        2 => 'tests\\feature\\api\\controllers\\zoom\\it_validates_meeting_creation_request',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Controllers\\Zoom\\UpdateMeetingTest.php' => 
    array (
      0 => '331191ce57345150e1a8e4cb9303d6b59a67c511',
      1 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\zoom\\updatemeetingtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\controllers\\zoom\\meeting_in_database_can_be_updated',
        1 => 'tests\\feature\\api\\controllers\\zoom\\database_changes_are_rolled_back_if_zoom_update_fails',
        2 => 'tests\\feature\\api\\controllers\\zoom\\it_validates_update_request',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Jobs\\Webhooks\\Zoom\\EndedMeetingWebhookTest.php' => 
    array (
      0 => '20bc305c0ec452918d5b466cf819560d453ac4e2',
      1 => 
      array (
        0 => 'tests\\feature\\api\\jobs\\webhooks\\zoom\\endedmeetingwebhooktest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\jobs\\webhooks\\zoom\\notifies_project_members_on_meeting_ended',
        1 => 'tests\\feature\\api\\jobs\\webhooks\\zoom\\inviteandactivateuser',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Jobs\\Webhooks\\Zoom\\ProcessMeetingDeleteTest.php' => 
    array (
      0 => '98837e592a1f6a274fd6fdb092743710fb1e17ce',
      1 => 
      array (
        0 => 'tests\\feature\\api\\jobs\\webhooks\\zoom\\processmeetingdeletetest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\jobs\\webhooks\\zoom\\zoom_meeting_can_be_deleted',
        1 => 'tests\\feature\\api\\jobs\\webhooks\\zoom\\throw_exception_if_meeting_not_found',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Jobs\\Webhooks\\Zoom\\ProcessMeetingUpdateWebhookTest.php' => 
    array (
      0 => 'f6243c435d4f502d6923dd346345f3cbfa6c4a7f',
      1 => 
      array (
        0 => 'tests\\feature\\api\\jobs\\webhooks\\zoom\\processmeetingupdatewebhooktest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\jobs\\webhooks\\zoom\\zoom_meeting_can_be_updated',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Jobs\\Webhooks\\Zoom\\StartMeetingWebhookTest.php' => 
    array (
      0 => '71849daee39c94b0dfe41b063f7e1dc5c0b60ee7',
      1 => 
      array (
        0 => 'tests\\feature\\api\\jobs\\webhooks\\zoom\\startmeetingwebhooktest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\jobs\\webhooks\\zoom\\notifies_project_members_on_meeting_start',
        1 => 'tests\\feature\\api\\jobs\\webhooks\\zoom\\inviteandactivateuser',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Middleware\\Zoom\\VerifyWebhookTest.php' => 
    array (
      0 => '160899cbbb25c0811ba7913dcb0a60247402f6ef',
      1 => 
      array (
        0 => 'tests\\feature\\api\\middleware\\zoom\\verifywebhooktest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\middleware\\zoom\\setup',
        1 => 'tests\\feature\\api\\middleware\\zoom\\it_aborts_with_an_invalid_signature',
        2 => 'tests\\feature\\api\\middleware\\zoom\\it_passes_with_a_valid_signature',
        3 => 'tests\\feature\\api\\middleware\\zoom\\it_fails_with_an_old_timestamp',
        4 => 'tests\\feature\\api\\middleware\\zoom\\buildsignature',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Services\\Paddle\\SubscriptionTest.php' => 
    array (
      0 => '535d52ca9c0b285fbf00bb5bbc7230d7487d6f07',
      1 => 
      array (
        0 => 'tests\\feature\\api\\services\\paddle\\subscriptiontest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\services\\paddle\\it_throws_exception_for_already_subscribed_user',
        1 => 'tests\\feature\\api\\services\\paddle\\it_throws_error_while_swapping_to_the_same_plan',
        2 => 'tests\\feature\\api\\services\\paddle\\it_throws_exception_for_canceling_a_non_subscribed_plan',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Services\\Zoom\\ZoomService\\AuthorizeTest.php' => 
    array (
      0 => '1ec06cad5058611159e1f6323c5ba0c459215125',
      1 => 
      array (
        0 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\authorizetest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\access_details_are_returned',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Services\\Zoom\\ZoomService\\GetAuthRedirectDetailsTest.php' => 
    array (
      0 => '619f434543bdc8ae203157fecb1b8d4653a72937',
      1 => 
      array (
        0 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\getauthredirectdetailstest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\auth_redirect_details_can_be_returned',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Services\\Zoom\\ZoomService\\GetZakTokenTest.php' => 
    array (
      0 => '537d6769308ee9bbdc9a31aa6baf005bb7875a48',
      1 => 
      array (
        0 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\getzaktokentest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\auth_user_can_get_his_zak_token',
        1 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\usercreate',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Services\\Zoom\\ZoomService\\MeetingCreateTest.php' => 
    array (
      0 => '48569bd00c875fa1e0d00080f47d6e36572b4cb0',
      1 => 
      array (
        0 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\meetingcreatetest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\setup',
        1 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\it_refreshes_token_and_updates_user_if_expired',
        2 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\it_creates_meeting_in_zoom_with_valid_data',
        3 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\it_applies_rate_limit_when_creating_meetings',
        4 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\usercreate',
        5 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\mockmeetingresponse',
        6 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\createandassertmeeting',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Services\\Zoom\\ZoomService\\MeetingDeleteTest.php' => 
    array (
      0 => 'bfa5c09c236ea6ba212dfc2457a08a8da6c4fe65',
      1 => 
      array (
        0 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\meetingdeletetest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\meeting_can_be_deleted_in_zoom',
        1 => 'tests\\feature\\api\\services\\zoom\\zoomservice\\usercreate',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\Services\\Zoom\\ZoomService\\MeetingUpdateTest.php' => 
    array (
      0 => '25390b36706d603619c57c3137fa6c70061e0bff',
      1 => 
      array (
        0 => 'tests\\feature\\v1\\services\\zoom\\zoomservice\\meetingupdatetest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\v1\\services\\zoom\\zoomservice\\meeting_can_be_updated_in_zoom',
        1 => 'tests\\feature\\v1\\services\\zoom\\zoomservice\\usercreate',
        2 => 'tests\\feature\\v1\\services\\zoom\\zoomservice\\meetingdata',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ActivityTest.php' => 
    array (
      0 => '9ed683caee612a515d55a713270173b4cb5789bd',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\activitytest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\it_filters_activities_by_project_specified',
        1 => 'tests\\feature\\api\\v1\\it_filters_activities_by_tasks',
        2 => 'tests\\feature\\api\\v1\\it_filters_activities_by_authenticated_user',
        3 => 'tests\\feature\\api\\v1\\it_shows_error_when_no_related_activities_are_found',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\Admin\\UsersTest.php' => 
    array (
      0 => '362e40d612d15bc9d6938cada78ec618d6ec02cf',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\admin\\userstest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\admin\\record_user_last_activity',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ApplicationTest.php' => 
    array (
      0 => '34958686f7ce207a66c463a2b9d93b982591f4e4',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\applicationtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\only_allowed_users_can_access_project_features',
        1 => 'tests\\feature\\api\\v1\\auth_user_can_export_project_file',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ConversationTest.php' => 
    array (
      0 => 'b02b59d3655a2ea4a0565f9ad0709e3028969d95',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\conversationtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\allowed_user_can_see_project_conversations',
        1 => 'tests\\feature\\api\\v1\\allowed_user_participates_in_project_chat',
        2 => 'tests\\feature\\api\\v1\\chat_validation_check',
        3 => 'tests\\feature\\api\\v1\\allowed_user_store_file_in_chat',
        4 => 'tests\\feature\\api\\v1\\allowed_user_can_delete_conversation',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\FileUploadTest.php' => 
    array (
      0 => '076f49dc3e83807db4498a7c3430b288074534bc',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\fileuploadtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\setup',
        1 => 'tests\\feature\\api\\v1\\store_method_when_file_missing',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\InvitationTest.php' => 
    array (
      0 => '7a7d607329af8d401b1de7aeb271ce84e1b3dbe6',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\invitationtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\project_owner_can_invite_user',
        1 => 'tests\\feature\\api\\v1\\project_owner_can_not_reinvite_user_and_himself',
        2 => 'tests\\feature\\api\\v1\\it_allows_valid_email',
        3 => 'tests\\feature\\api\\v1\\auth_user_accept_project_invitation_sent_to_him',
        4 => 'tests\\feature\\api\\v1\\uninvited_user_cannot_accept_invitation',
        5 => 'tests\\feature\\api\\v1\\authorized_user_can_reject_project_invitation',
        6 => 'tests\\feature\\api\\v1\\project_owner_can_cancel_project_invitation',
        7 => 'tests\\feature\\api\\v1\\project_owner_can_remove_member',
        8 => 'tests\\feature\\api\\v1\\project_owner_can_view_pending_member_invitations',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\JobsTest.php' => 
    array (
      0 => 'd1e1c9246c5f5f5fbd71f981e2f3330c1548037a',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\jobstest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\send_mail_job',
        1 => 'tests\\feature\\api\\v1\\mock_send_sms_job',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\MeetingTest.php' => 
    array (
      0 => '4fad3d8829b00feb9c087105dcb14b16b86f9167',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\meetingtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\it_can_show_a_meeting',
        1 => 'tests\\feature\\api\\v1\\it_can_list_meetings_for_a_project',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\MessageTest.php' => 
    array (
      0 => 'c6aeee83446187e7fbb3b071d0bc6ce6521fc4c5',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\messagetest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\operation_on_send_message',
        1 => 'tests\\feature\\api\\v1\\message_option_must_be_selected',
        2 => 'tests\\feature\\api\\v1\\check_schedule_command_working',
        3 => 'tests\\feature\\api\\v1\\get_project_scheduled_messages',
        4 => 'tests\\feature\\api\\v1\\project_message_can_be_deleted',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\MessageValidationTest.php' => 
    array (
      0 => 'f5491b5ad836df40d78d475df36a557fa0f308aa',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\messagevalidationtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\validate_message_errors',
        1 => 'tests\\feature\\api\\v1\\check_message_option_select',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\NotificationsTest.php' => 
    array (
      0 => '8d0a47035cb7d652077e32db499f66612d9d7e5d',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\notificationstest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\invited_user_can_get_project_invitation',
        1 => 'tests\\feature\\api\\v1\\project_owner_get_notified_by_member',
        2 => 'tests\\feature\\api\\v1\\allowed_user_notified_on_project_update',
        3 => 'tests\\feature\\api\\v1\\project_member_notified_when_task_added',
        4 => 'tests\\feature\\api\\v1\\mentioned_user_in_a_chat_are_notified',
        5 => 'tests\\feature\\api\\v1\\user_should_not_receive_task_notification_when_adding_a_task',
        6 => 'tests\\feature\\api\\v1\\sendinvitationtouser',
        7 => 'tests\\feature\\api\\v1\\addmember',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ProjectDashBoard\\DashboardTest.php' => 
    array (
      0 => 'c2b5ae9ad9d79d014cd1b617fb07b417bd79f9ad',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\dashboardtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\auth_user_can_view_dashboard_projects',
        1 => 'tests\\feature\\api\\v1\\dashboard_projects_returns_empty_message_when_no_projects',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ProjectDashBoard\\ProjectChartTests.php' => 
    array (
      0 => 'ccd6d73d872c6c6ade2e6e605fb56f66b80ce9f7',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectdashboard\\projectcharttests',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectdashboard\\auth_user_can_get_chart_data',
        1 => 'tests\\feature\\api\\v1\\projectdashboard\\chart_data_respects_year_month_filters',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ProjectDashBoard\\UserActivitiesTest.php' => 
    array (
      0 => '14c9c490dcff05f180e9600a1266ed91c758d111',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectdashboard\\useractivitiestest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectdashboard\\activities_endpoint_validates_date_parameters',
        1 => 'tests\\feature\\api\\v1\\projectdashboard\\user_can_view_activities_within_date_range',
        2 => 'tests\\feature\\api\\v1\\projectdashboard\\activities_include_soft_deleted_projects',
        3 => 'tests\\feature\\api\\v1\\projectdashboard\\it_returns_empty_array_when_no_activities_in_range',
        4 => 'tests\\feature\\api\\v1\\projectdashboard\\test_get_user_activities_is_cached',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ProjectDashBoard\\UserKpiMetricesTest.php' => 
    array (
      0 => '37906029a4995b891113212866a6b7bf22f37633',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectdashboard\\userkpimetricestest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectdashboard\\it_returns_dashboard_kpis_and_insights_for_authenticated_user',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ProjectDashBoard\\UserProjectsPageTest.php' => 
    array (
      0 => '6f410390f6e7dd0b13fc88566e0c713a8f180e57',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectdashboard\\userprojectspagetest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectdashboard\\it_validates_sort_parameter',
        1 => 'tests\\feature\\api\\v1\\projectdashboard\\it_validates_member_parameter',
        2 => 'tests\\feature\\api\\v1\\projectdashboard\\it_validates_page_parameter',
        3 => 'tests\\feature\\api\\v1\\projectdashboard\\it_accepts_valid_parameters',
        4 => 'tests\\feature\\api\\v1\\projectdashboard\\auth_user_can_filter_projects_by_search',
        5 => 'tests\\feature\\api\\v1\\projectdashboard\\auth_user_can_sort_projects_by_latest',
        6 => 'tests\\feature\\api\\v1\\projectdashboard\\auth_user_can_sort_projects_by_oldest',
        7 => 'tests\\feature\\api\\v1\\projectdashboard\\auth_user_can_view_member_projects',
        8 => 'tests\\feature\\api\\v1\\projectdashboard\\auth_user_can_view_trashed_projects',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ProjectDashBoard\\UserTasksDataTest.php' => 
    array (
      0 => '9c18ffbd64d35f8f71907b7750849e2f675117ce',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectdashboard\\usertasksdatatest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectdashboard\\setup',
        1 => 'tests\\feature\\api\\v1\\projectdashboard\\auth_user_can_view_tasks_with_user_created_and_task_assigned_filters',
        2 => 'tests\\feature\\api\\v1\\projectdashboard\\auth_user_can_filter_tasks_by_user_created_only',
        3 => 'tests\\feature\\api\\v1\\projectdashboard\\auth_user_can_filter_tasks_by_task_assigned_only',
        4 => 'tests\\feature\\api\\v1\\projectdashboard\\auth_user_can_filter_tasks_by_completed_status',
        5 => 'tests\\feature\\api\\v1\\projectdashboard\\auth_user_can_filter_tasks_by_overdue_status',
        6 => 'tests\\feature\\api\\v1\\projectdashboard\\auth_user_can_filter_tasks_by_remaining_status',
        7 => 'tests\\feature\\api\\v1\\projectdashboard\\request_requires_at_least_one_filter',
        8 => 'tests\\feature\\api\\v1\\projectdashboard\\request_with_false_values_requires_at_least_one_filter',
        9 => 'tests\\feature\\api\\v1\\projectdashboard\\status_filters_without_user_context_default_to_user_tasks',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ProjectFeatureTest.php' => 
    array (
      0 => 'c5a0014bf4214af5aabfa2bafe1a6a26c6941f07',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectfeaturetest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\auth_user_can_create_project',
        1 => 'tests\\feature\\api\\v1\\tasks_can_be_added_when_new_project_created',
        2 => 'tests\\feature\\api\\v1\\project_requires_a_name',
        3 => 'tests\\feature\\api\\v1\\tasks_validated_on_creating_a_new_project',
        4 => 'tests\\feature\\api\\v1\\project_cannot_have_more_than_three_tasks',
        5 => 'tests\\feature\\api\\v1\\auth_user_can_get_project_resource',
        6 => 'tests\\feature\\api\\v1\\allowed_user_can_update_project',
        7 => 'tests\\feature\\api\\v1\\updated_project_requires_a_name',
        8 => 'tests\\feature\\api\\v1\\it_does_not_update_with_invalid_fields',
        9 => 'tests\\feature\\api\\v1\\it_does_not_update_field_with_same_data',
        10 => 'tests\\feature\\api\\v1\\project_owner_can_get_abandoned_project',
        11 => 'tests\\feature\\api\\v1\\project_owner_can_restore_project',
        12 => 'tests\\feature\\api\\v1\\project_owner_can_delete_project',
        13 => 'tests\\feature\\api\\v1\\delete_abandon_projects_after_limit_past',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ProjectHealthScoreFeatureTest.php' => 
    array (
      0 => '0a4fed5991e4d064e78eae8bf2e31e774daeeb6f',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projecthealthscorefeaturetest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\test_dispatches_job_when_health_section_requested_and_sets_broadcast_flag',
        1 => 'tests\\feature\\api\\v1\\test_does_not_dispatch_when_health_not_requested',
        2 => 'tests\\feature\\api\\v1\\test_throttles_duplicate_dispatches_within_decay_window',
        3 => 'tests\\feature\\api\\v1\\test_job_persists_health_score_and_timestamp_and_broadcasts_when_flag_true',
        4 => 'tests\\feature\\api\\v1\\test_job_does_not_broadcast_when_flag_false',
        5 => 'tests\\feature\\api\\v1\\test_job_computes_score_via_action_when_no_precomputed_score_and_persists_without_broadcast',
        6 => 'tests\\feature\\api\\v1\\test_project_health_status_accessor_maps_scores_to_labels',
        7 => 'tests\\feature\\api\\v1\\test_backfill_command_dispatches_jobs_for_all_projects',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ProjectInsightsApiTest.php' => 
    array (
      0 => '709f5f727c882699c6c0ec079c5c6bb75b330b80',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectinsightsapitest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\setup',
        1 => 'tests\\feature\\api\\v1\\can_get_project_insights_with_realistic_data',
        2 => 'tests\\feature\\api\\v1\\can_get_specific_sections_only',
        3 => 'tests\\feature\\api\\v1\\can_get_single_section_via_url_path',
        4 => 'tests\\feature\\api\\v1\\normalizes_sections_array_and_filters_duplicates',
        5 => 'tests\\feature\\api\\v1\\requires_authentication',
        6 => 'tests\\feature\\api\\v1\\validates_invalid_sections_parameter',
        7 => 'tests\\feature\\api\\v1\\handles_empty_project_gracefully',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\ProjectMailableTest.php' => 
    array (
      0 => '8da04dc1fb15819c723f7b090ca83d0490e62235',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\projectmailabletest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\project_message_maialable_content',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\RecordActivityTest.php' => 
    array (
      0 => 'f4007da939d43714aa3ff6e4400f960e48131091',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\recordactivitytest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\creating_a_project',
        1 => 'tests\\feature\\api\\v1\\record_activity_on_updating_a_project',
        2 => 'tests\\feature\\api\\v1\\it_removes_project_activities_when_deleted',
        3 => 'tests\\feature\\api\\v1\\record_on_restoring_project',
        4 => 'tests\\feature\\api\\v1\\record_on_creating_task',
        5 => 'tests\\feature\\api\\v1\\record_on_updating_task',
        6 => 'tests\\feature\\api\\v1\\record_on_task_deletion',
        7 => 'tests\\feature\\api\\v1\\remove_project_task_activities_on_archived_task_deletion',
        8 => 'tests\\feature\\api\\v1\\records_activity_when_invitation_sent_to_user',
        9 => 'tests\\feature\\api\\v1\\records_activity_when_user_accepted_project_invitation',
        10 => 'tests\\feature\\api\\v1\\it_records_activity_when_a_project_member_is_removed',
        11 => 'tests\\feature\\api\\v1\\it_records_activity_on_creating_message',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\SearchableTest.php' => 
    array (
      0 => '72fd5b95826decbc9d7b80eb2604d32605102520',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\searchabletest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\it_returns_an_empty_collection_when_no_query_is_provided',
        1 => 'tests\\feature\\api\\v1\\it_searches_for_users_by_name_or_email',
        2 => 'tests\\feature\\api\\v1\\test_search_returns_filtered_users',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\StageTest.php' => 
    array (
      0 => 'ae324b926cbf85fbbc529bf18744d19e2c60a802',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\stagetest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\setup',
        1 => 'tests\\feature\\api\\v1\\stages_loaded_sucessfully',
        2 => 'tests\\feature\\api\\v1\\allowed_user_can_change_project_stage',
        3 => 'tests\\feature\\api\\v1\\allowed_user_can_update_postponed_reason',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\TaskFeaturesTest.php' => 
    array (
      0 => 'fd0ca311517d151ad3156c59bf71f55d7ed5c79e',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\taskfeaturestest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\members_assign_to_task_and_pervent_duplication',
        1 => 'tests\\feature\\api\\v1\\it_unassigns_a_member_from_a_task_and_handles_invalid_requests',
        2 => 'tests\\feature\\api\\v1\\allowed_user_can_archive_and_unarchive_task',
        3 => 'tests\\feature\\api\\v1\\project_members_does_not_perform_task_operations',
        4 => 'tests\\feature\\api\\v1\\auth_user_can_search_project_members',
        5 => 'tests\\feature\\api\\v1\\allowed_user_can_remove_archived_task_from_database',
        6 => 'tests\\feature\\api\\v1\\assignmemberstotask',
        7 => 'tests\\feature\\api\\v1\\unassignmemberfromtask',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\TaskNotifyTest.php' => 
    array (
      0 => 'b8ce48ade50c5af3a3f30d5048fd9ba48ac048b9',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\tasknotifytest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\test_task_notify_command_handles_notifications',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\TaskTest.php' => 
    array (
      0 => 'db86b021cbc62e039781265df40e4d0ee47d6b30',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\tasktest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\allowed_user_see_archived_tasks',
        1 => 'tests\\feature\\api\\v1\\allowed_user_see_active_tasks_and_paginate',
        2 => 'tests\\feature\\api\\v1\\task_requires_a_title',
        3 => 'tests\\feature\\api\\v1\\allowed_user_can_create_projects_task',
        4 => 'tests\\feature\\api\\v1\\duplicate_project_task_can_not_be_created',
        5 => 'tests\\feature\\api\\v1\\task_limit_per_project',
        6 => 'tests\\feature\\api\\v1\\allowed_user_can_get_task_resource',
        7 => 'tests\\feature\\api\\v1\\allowed_user_can_update_project_task',
        8 => 'tests\\feature\\api\\v1\\due_at_timezone_works_as_expected',
        9 => 'tests\\feature\\api\\v1\\task_gate_check',
        10 => 'tests\\feature\\api\\v1\\task_policy_check',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\UserAvatarTest.php' => 
    array (
      0 => 'f46b2a8699e050ce637087e83c617830fc980f9e',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\useravatartest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\setup',
        1 => 'tests\\feature\\api\\v1\\a_valid_avatar_must_be_provided',
        2 => 'tests\\feature\\api\\v1\\authorize_user_may_add_avatar_to_his_profile',
        3 => 'tests\\feature\\api\\v1\\profile_owner_can_delete_his_avatar',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\UserInvitationTest.php' => 
    array (
      0 => 'e868df00286e9d410e5aeca8ee35e70f477ed78b',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\userinvitationtest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\it_returns_pending_project_invitations_for_authenticated_user',
        1 => 'tests\\feature\\api\\v1\\it_returns_empty_array_and_message_if_no_pending_invitations',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\UserNotificationsTest.php' => 
    array (
      0 => 'be64f0fa36974740799958c0183dfed9c583e03c',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\usernotificationstest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\auth_user_can_fetch_there_notifications',
        1 => 'tests\\feature\\api\\v1\\auth_user_can_fetch_notifications_by_status',
        2 => 'tests\\feature\\api\\v1\\auth_user_can_mark_all_notifications_as_read',
        3 => 'tests\\feature\\api\\v1\\auth_user_can_delete_a_notification',
        4 => 'tests\\feature\\api\\v1\\auth_user_can_update_notification_status',
        5 => 'tests\\feature\\api\\v1\\projectupdate',
        6 => 'tests\\feature\\api\\v1\\sendinvitationtouser',
        7 => 'tests\\feature\\api\\v1\\actingasinviteduser',
        8 => 'tests\\feature\\api\\v1\\addmember',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\UserTest.php' => 
    array (
      0 => '99b1be11a42b968613daef22ad4f468f2f03ab58',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\usertest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\dataprovider',
        1 => 'tests\\feature\\api\\v1\\auth_user_see_all_users',
        2 => 'tests\\feature\\api\\v1\\auth_user_can_get_his_data',
        3 => 'tests\\feature\\api\\v1\\owner_can_update_his_data',
        4 => 'tests\\feature\\api\\v1\\it_can_update_user_password',
        5 => 'tests\\feature\\api\\v1\\password_update_mail_contains_time',
        6 => 'tests\\feature\\api\\v1\\user_can_delete_his_profile',
        7 => 'tests\\feature\\api\\v1\\it_permanently_deletes_user_and_handles_projects_after_15_days',
        8 => 'tests\\feature\\api\\v1\\test_user_profile_delete_command_runs',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Feature\\Api\\V1\\UserTokenTest.php' => 
    array (
      0 => 'ec742c74066a78578ac027bba09357d7526f2aac',
      1 => 
      array (
        0 => 'tests\\feature\\api\\v1\\usertokentest',
      ),
      2 => 
      array (
        0 => 'tests\\feature\\api\\v1\\setup',
        1 => 'tests\\feature\\api\\v1\\user_can_list_their_tokens',
        2 => 'tests\\feature\\api\\v1\\user_can_create_a_token',
        3 => 'tests\\feature\\api\\v1\\user_can_delete_a_token',
        4 => 'tests\\feature\\api\\v1\\user_cannot_delete_current_session_token_via_route',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Support\\BuildsInsightTestData.php' => 
    array (
      0 => 'fa0d1e52edc559d4d470d3b11b5c960b334f9d52',
      1 => 
      array (
        0 => 'tests\\support\\buildsinsighttestdata',
      ),
      2 => 
      array (
        0 => 'tests\\support\\seedrealisticdata',
        1 => 'tests\\support\\assertinsightvalue',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\TestCase.php' => 
    array (
      0 => 'ecb9ffe1ed43d63d58120fb5ba75839b5fe576d9',
      1 => 
      array (
        0 => 'tests\\testcase',
      ),
      2 => 
      array (
        0 => 'tests\\setup',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Traits\\InteractsWithPaddle.php' => 
    array (
      0 => 'f03f5eaa4f0e7b83d3cd8a7f81707faa843c2e7e',
      1 => 
      array (
        0 => 'tests\\traits\\interactswithpaddle',
      ),
      2 => 
      array (
        0 => 'tests\\traits\\fakesubscription',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Traits\\InteractsWithZoom.php' => 
    array (
      0 => '9866ce33c08aa32e732e56cc900e7ce4d1337f6e',
      1 => 
      array (
        0 => 'tests\\traits\\interactswithzoom',
      ),
      2 => 
      array (
        0 => 'tests\\traits\\fakezoom',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Unit\\Api\\V1\\HasSubscriptionTest.php' => 
    array (
      0 => 'c345fbfcbe88e62ffa8a968a0cbc961c23610e87',
      1 => 
      array (
        0 => 'tests\\unit\\api\\v1\\dummyuserwithsubscription',
        1 => 'tests\\unit\\api\\v1\\hassubscriptiontest',
      ),
      2 => 
      array (
        0 => 'tests\\unit\\api\\v1\\subscription',
        1 => 'tests\\unit\\api\\v1\\test_is_subscribed_returns_true_when_subscription_exists',
        2 => 'tests\\unit\\api\\v1\\test_is_subscribed_returns_false_when_no_subscription',
        3 => 'tests\\unit\\api\\v1\\test_subscribed_plan_variants',
        4 => 'tests\\unit\\api\\v1\\test_has_grace_period_true_and_false',
        5 => 'tests\\unit\\api\\v1\\ongraceperiod',
        6 => 'tests\\unit\\api\\v1\\ongraceperiod',
        7 => 'tests\\unit\\api\\v1\\test_payment_returns_next_payment_and_no_active_subscription',
        8 => 'tests\\unit\\api\\v1\\nextpayment',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Unit\\MentionedUserTest.php' => 
    array (
      0 => '163ce0799fbca1fdc9b7729e89444cacc1100756',
      1 => 
      array (
        0 => 'tests\\unit\\mentionedusertest',
      ),
      2 => 
      array (
        0 => 'tests\\unit\\it_wraps_mentioned_usernames_in_the_body_within_anchor_tag',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Unit\\ProjectInsightResponseServiceTest.php' => 
    array (
      0 => 'a90fd4dd244b573f94e620e878576ad450fa542f',
      1 => 
      array (
        0 => 'tests\\unit\\projectinsightresponseservicetest',
      ),
      2 => 
      array (
        0 => 'tests\\unit\\healththresholdsprovider',
        1 => 'tests\\unit\\taskhealthcasesprovider',
        2 => 'tests\\unit\\collaborationcasesprovider',
        3 => 'tests\\unit\\riskcasesprovider',
        4 => 'tests\\unit\\stagecasesprovider',
        5 => 'tests\\unit\\health_builder_handles_null_and_numeric',
        6 => 'tests\\unit\\health_builder_titles_and_types_at_thresholds',
        7 => 'tests\\unit\\task_health_builder_handles_no_data',
        8 => 'tests\\unit\\task_health_builder_types_and_messages',
        9 => 'tests\\unit\\task_health_builder_renders_detailed_counts_in_message',
        10 => 'tests\\unit\\collaboration_builder_handles_no_data',
        11 => 'tests\\unit\\collaboration_builder_title_and_type_cases',
        12 => 'tests\\unit\\collaboration_builder_includes_lookbacks_and_ideal_meetings_in_message',
        13 => 'tests\\unit\\risk_builder_handles_invalid_input',
        14 => 'tests\\unit\\risk_builder_title_and_type',
        15 => 'tests\\unit\\stage_builder_handles_unknown_input',
        16 => 'tests\\unit\\stage_builder_titles_and_types',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Unit\\ProjectInsightsCalculationsTest.php' => 
    array (
      0 => '94c245716a64b0c732604252f083087a1437f3f5',
      1 => 
      array (
        0 => 'tests\\unit\\projectinsightscalculationstest',
      ),
      2 => 
      array (
        0 => 'tests\\unit\\teardown',
        1 => 'tests\\unit\\calculate_project_health_combines_all_health_metrics',
        2 => 'tests\\unit\\calculate_task_health_weighted_by_completion_overdue_and_abandonment',
        3 => 'tests\\unit\\calculate_task_health_handles_empty_project',
        4 => 'tests\\unit\\calculate_collaboration_health_uses_members_meetings_and_participation',
        5 => 'tests\\unit\\stage_progress_returns_stage_data_and_preserves_enum_stage_id',
        6 => 'tests\\unit\\stage_progress_returns_correct_status_for_completed_and_postponed',
        7 => 'tests\\unit\\upcoming_risk_returns_score_and_counts',
        8 => 'tests\\unit\\communication_health_calculates_log_scaled_score_and_caps',
        9 => 'tests\\unit\\activity_health_uses_log_fraction_and_clamps',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Unit\\ProjectTest.php' => 
    array (
      0 => '089467bc78d7a49d3a8f067948201e3fae755c1e',
      1 => 
      array (
        0 => 'tests\\unit\\projecttest',
      ),
      2 => 
      array (
        0 => 'tests\\unit\\a_project_can_make_a_string_path',
        1 => 'tests\\unit\\a_project_has_a_creator',
        2 => 'tests\\unit\\project_belongs_to_stage',
        3 => 'tests\\unit\\a_project_can_add_a_task',
        4 => 'tests\\unit\\a_project_has_tasks',
        5 => 'tests\\unit\\invitation_can_be_sent_to_a_user',
        6 => 'tests\\unit\\addmember',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Unit\\Repository\\DashboardInsightsRepositoryTest.php' => 
    array (
      0 => '9bfc88f10dd042dcd984df572760a33fdb03d59e',
      1 => 
      array (
        0 => 'tests\\unit\\repository\\dashboardinsightsrepositorytest',
      ),
      2 => 
      array (
        0 => 'tests\\unit\\repository\\it_handles_no_projects',
        1 => 'tests\\unit\\repository\\it_handles_projects_with_no_tasks',
        2 => 'tests\\unit\\repository\\it_handles_all_tasks_completed',
        3 => 'tests\\unit\\repository\\it_handles_all_tasks_overdue',
        4 => 'tests\\unit\\repository\\it_handles_threshold_boundary_for_critical_projects',
        5 => 'tests\\unit\\repository\\it_handles_multiple_projects_mixed_states',
        6 => 'tests\\unit\\repository\\it_handles_user_as_active_member_not_owner',
        7 => 'tests\\unit\\repository\\it_excludes_inactive_members_from_results',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Unit\\Services\\DashboardInsightsServiceTest.php' => 
    array (
      0 => '74e3efe868a5a03454d25b5f77044e77b064b327',
      1 => 
      array (
        0 => 'tests\\unit\\services\\dashboardinsightsservicetest',
      ),
      2 => 
      array (
        0 => 'tests\\unit\\services\\it_returns_correct_kpis_for_user',
        1 => 'tests\\unit\\services\\it_returns_actionable_insights_for_various_scenarios',
        2 => 'tests\\unit\\services\\it_returns_no_active_projects_insight',
        3 => 'tests\\unit\\services\\it_returns_portfolio_healthy_insight_when_no_issues',
        4 => 'tests\\unit\\services\\it_returns_warning_insight_for_some_overdue_tasks_below_critical',
      ),
      3 => 
      array (
      ),
    ),
    'D:\\apps\\profresh\\tests\\Unit\\TaskTest.php' => 
    array (
      0 => '58bf4d907edf2d46385f36019ac498f1ec22732e',
      1 => 
      array (
        0 => 'tests\\unit\\tasktest',
      ),
      2 => 
      array (
        0 => 'tests\\unit\\it_belongs_to_a_project',
      ),
      3 => 
      array (
      ),
    ),
  ),
));