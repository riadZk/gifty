<?php

return [
    // ── Shared status labels ──
    'status_pending'           => 'Pending',
    'status_approved'          => 'Approved',
    'status_rejected'          => 'Rejected',
    'status_delivered'         => 'Delivered',

    // ── Index page ──
    'breadcrumb_loyalty'       => 'Loyalty',
    'page_title'               => 'Bonus Requests',
    'page_subtitle'            => 'Track and process bonus requests submitted by clients.',

    // Index – stat tiles
    'stat_total'               => 'Total Requests',
    'stat_total_sub'           => 'All requests combined',
    'stat_pending'             => 'Pending',
    'stat_pending_sub'         => ':pct% of total',
    'stat_approved_delivered'  => 'Approved / Delivered',
    'stat_approved_sub'        => 'Rate: :rate%',
    'stat_points_pending'      => 'Pending Points',
    'stat_rejected_sub'        => ':count rejected request(s)',

    // Index – toolbar
    'search_placeholder'       => 'Search a client, bonus…',
    'filter_placeholder'       => 'All statuses',
    'btn_reset'                => 'Reset',
    'no_results'               => 'No request found',
    'loading'                  => 'Loading…',

    // Index – JS card renderer
    'js_loyalty_bonus'         => 'Loyalty bonus',
    'js_pts_required'          => 'pts required',
    'js_view'                  => 'View',
    'js_counter_singular'      => 'request',
    'js_counter_plural'        => 'requests',

    // ── Show page ──
    'btn_back'                 => 'Back',
    'breadcrumb_requests'      => 'Bonus Requests',
    'show_title'               => 'Bonus request detail',
    'show_subtitle'            => 'View all information related to this request',

    // Show – status banner
    'current_status'           => 'Current status:',
    'submitted_on'             => 'Submitted on',
    'id_label'                 => 'ID:',

    // Show – client card
    'client_active'            => 'Active client',
    'client_blocked'           => 'Blocked',
    'label_pcc_code'           => 'PCC Code',
    'label_email'              => 'Email',
    'label_phone'              => 'Phone',
    'label_member_since'       => 'Member since',

    // Show – summary card
    'summary_title'            => 'Request summary',
    'summary_date'             => 'Date',
    'summary_requested_by'     => 'Requested by',
    'summary_channel'          => 'Channel',
    'summary_channel_value'    => 'Client portal',
    'summary_notes'            => 'Client notes',

    // Show – bonus card
    'bonus_card_title'         => 'Requested bonus',
    'bonus_active_badge'       => 'Active bonus',
    'bonus_pts_required'       => 'Points required',
    'bonus_quantity'           => 'Quantity',
    'bonus_value'              => 'Estimated value',

    // Show – points situation
    'points_title'             => 'Client points situation',
    'points_current'           => 'Current balance',
    'points_before_label'      => 'Before this request',
    'points_required_label'    => 'Points required',
    'points_for_bonus'         => 'For this bonus',
    'points_after'             => 'Balance after exchange',
    'points_if_approved'       => 'If approved',
    'points_remaining_svg'     => 'Remaining',
    'points_insufficient'      => 'Insufficient balance — missing :pts pts',

    // Show – timeline
    'timeline_title'           => 'Request tracking',
    'step_created'             => 'Request created',
    'step_pending'             => 'Awaiting validation',
    'step_pending_sub'         => 'By the administrator',
    'step_approved'            => 'Approved',
    'step_preparing'           => 'Prepared for delivery',
    'step_delivered'           => 'Delivered to client',

    // Show – actions
    'actions_title'            => 'Admin actions',
    'btn_approve'              => 'Approve request',
    'btn_reject'               => 'Reject request',
    'btn_more_info'            => 'Request more information',
    'approved_hint'            => 'The bonus has been approved. Mark it as delivered once handed to the client.',
    'btn_deliver'              => 'Mark as delivered',
    'rejected_label'           => 'Request rejected',
    'delivered_label'          => 'Bonus delivered',
    'delivered_done'           => 'This request is complete.',
    'comment_label'            => 'Comments (optional)',
    'comment_placeholder'      => 'Add a comment...',

    // Show – transaction
    'tx_title'                 => 'Points Transaction',
    'tx_before'                => 'Before',
    'tx_deducted'              => 'Deducted',
    'tx_after'                 => 'After',

    // Show – JS SweetAlert (approve)
    'js_approve_title'         => 'Approve request?',
    'js_approve_html'          => 'This will deduct <strong style="color:#f59e0b">:pts pts</strong> from the client\'s balance.',
    'js_approve_btn'           => '✓ Approve',
    'js_approve_ok_title'      => 'Approved!',
    'js_approve_ok_text'       => 'Points have been deducted.',

    // Show – JS SweetAlert (reject)
    'js_reject_title'          => 'Reject request?',
    'js_reject_html_hint'      => 'You can add a reason for rejection.',
    'js_reject_placeholder'    => 'Reason for rejection (optional)…',
    'js_reject_btn'            => '✗ Reject',
    'js_reject_ok_title'       => 'Request rejected',
    'js_reject_ok_text'        => 'The request has been marked as rejected.',

    // Show – JS SweetAlert (deliver)
    'js_deliver_title'         => 'Confirm delivery?',
    'js_deliver_text'          => 'Has the bonus been handed to the client?',
    'js_deliver_btn'           => '→ Confirm',
    'js_deliver_ok_title'      => 'Bonus delivered!',
    'js_deliver_ok_text'       => 'The request is now complete.',

    // Show – JS shared
    'js_cancel'                => 'Cancel',
    'js_error_title'           => 'Error',
    'js_error_generic'         => 'An error occurred.',
    'js_processing'            => 'Processing…',

    // ── Create page ──
    'create_breadcrumb'        => 'New bonus request',
    'create_points_label'      => 'Points balance',
    'create_choose_title'      => 'Choose a bonus',
    'create_choose_sub'        => 'Select the bonus the client wishes to obtain',
    'create_no_bonus'          => 'No active bonus configured.',
    'create_badge_insufficient' => 'Insufficient',
    'create_badge_available'   => 'Available',
    'create_pts_required'      => 'pts required',
    'create_pts_remaining'     => 'Remaining:',
    'create_pts_missing'       => 'Missing:',
    'create_notes_title'       => 'Notes',
    'create_notes_optional'    => '(optional)',
    'create_notes_placeholder' => 'Add additional information…',
    'create_btn_cancel'        => 'Cancel',
    'create_btn_submit'        => 'Submit request',

    // Create – how it works sidebar
    'create_how_title'         => 'How does it work?',
    'create_step1_title'       => 'Client selects a bonus',
    'create_step1_desc'        => 'The client chooses a bonus level matching their points.',
    'create_step2_title'       => 'Request submitted',
    'create_step2_desc'        => 'The administrator creates the request on behalf of the client.',
    'create_step3_title'       => 'Admin approval',
    'create_step3_desc'        => 'The admin reviews and approves or rejects the request.',
    'create_step4_title'       => 'Points deducted',
    'create_step4_desc'        => 'Points are automatically deducted from the client\'s balance.',
    'create_step5_title'       => 'Bonus delivered',
    'create_step5_desc'        => 'The physical bonus is handed to the client and the request is closed.',

    // Create – pending sidebar
    'create_pending_count'     => ':count pending request(s)',
];
