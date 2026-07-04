<?php

return [
    // Shared status labels
    'status_active'          => 'Active',
    'status_inactive'        => 'Inactive',
    'status_blocked'         => 'Blocked',

    // Shared action buttons
    'action_view'            => 'View',
    'action_activate'        => 'Activate',
    'action_unblock'         => 'Unblock',
    'action_block'           => 'Block',

    // _cards partial
    'no_pcc_code'            => 'No PCC code',

    // Index page – header
    'breadcrumb_admin'       => 'Administration',
    'page_title'             => 'Clients',
    'page_subtitle'          => 'Overview of your client base, activity and loyalty points.',

    // Index page – stat tiles
    'stat_total'             => 'Total Clients',
    'stat_total_sub'         => 'Registered client base',
    'stat_active'            => 'Active Clients',
    'stat_active_sub'        => ':pct% of total',
    'stat_new'               => 'New this month',
    'stat_new_sub'           => 'Registered this month',
    'stat_points'            => 'Distributed Points',
    'stat_points_sub'        => 'Total all clients',

    // Index page – toolbar
    'search_placeholder'     => 'Search a client…',
    'filter_all'             => 'All',
    'filter_active'          => 'Active',
    'filter_inactive'        => 'Inactive',
    'filter_blocked'         => 'Blocked',
    'view_grid'              => 'Grid',
    'view_list'              => 'List',
    'export_csv'             => 'Export CSV',
    'results_hint'           => 'Click on a card to see details',
    'result_suffix'          => 'clients',

    // Index page – table headers
    'col_client'             => 'Client',
    'col_phone'              => 'Phone',
    'col_email'              => 'Email',
    'col_pcc_code'           => 'PCC Code',
    'col_sales_points'       => 'Sales / Points',
    'col_status'             => 'Status',
    'col_actions'            => 'Actions',

    // Index page – loader / empty state
    'loading'                => 'Loading…',
    'no_results'             => 'No client found',
    'no_results_sub'         => 'Try a different search term',
    'reset_search'           => 'Reset search',

    // Index page – JS strings (SweetAlert / toasts)
    'js_confirm_title'       => 'Confirmation',
    'js_confirm_html'        => 'Do you really want to <strong>:verb</strong> <strong>:name</strong>?',
    'js_cancel'              => 'Cancel',
    'js_status_updated'      => 'Status updated.',
    'js_conn_error'          => 'Connection error.',
    'js_error_occurred'      => 'An error occurred.',
    'js_verb_activate'       => 'activate',
    'js_verb_block'          => 'block',
    'js_verb_unblock'        => 'unblock',

    // Show page – header / navigation
    'show_title'             => 'Client detail',
    'btn_back'               => 'Back',

    // Show page – profile card labels
    'label_pcc_code'         => 'PCC Code',
    'label_member_since'     => 'Member since',
    'label_validated_on'     => 'Account validated on',
    'label_bonus_requests'   => 'Bonus requests',
    'pending_validation'     => 'Pending',
    'label_points_balance'   => 'Points balance',
    'sales_suffix'           => ':amount MAD in sales',
    'btn_copy'               => 'Copy',

    // Show page – stat tiles
    'tile_points_sub'        => 'Total accumulated',
    'tile_sales'             => 'Total sales',
    'tile_sales_sub'         => 'Cumulative purchases',
    'tile_status'            => 'Status',
    'tile_status_sub'        => 'Account status',
    'tile_member'            => 'Member since',

    // Show page – charts
    'chart_points_title'     => 'Points overview',
    'chart_points_sub'       => 'Earned · Used · Balance',
    'chart_status_title'     => 'Request breakdown',
    'chart_no_data'          => 'No data',
    'chart_earned'           => 'Points earned',
    'chart_used'             => 'Points used',
    'chart_balance'          => 'Current balance',
    'chart_total'            => 'Total',

    // Show page – tabs
    'tab_info'               => 'Information',
    'tab_activity'           => 'Activity log',
    'tab_loyalty'            => 'Loyalty & sales',

    // Show page – info tab rows
    'info_company'           => 'Company name',
    'info_contact'           => 'Contact person',
    'info_phone'             => 'Phone',
    'info_email'             => 'Email',
    'info_pcc_code'          => 'PCC Code',
    'info_member_since'      => 'Member since',
    'info_status'            => 'Status',

    // Show page – activity log
    'log_deleted_level'      => 'Deleted level',
    'log_pts_required'       => 'pts required',
    'log_no_activity'        => 'No activity',
    'log_no_activity_sub'    => 'This client has no bonus request yet.',

    // Show page – log status labels
    'log_pending'            => 'Pending',
    'log_approved'           => 'Approved',
    'log_rejected'           => 'Rejected',
    'log_delivered'          => 'Delivered',

    // Show page – loyalty tab
    'loyalty_balance'        => 'Points balance',
    'loyalty_sales'          => 'Total sales',
    'loyalty_used'           => 'Points used',
    'loyalty_total_req'      => 'Total requests',
    'loyalty_approved'       => 'Approved requests',
    'loyalty_rate'           => 'Loyalty rate',
    'loyalty_rate_sub'       => '% of excl. tax',
    'loyalty_note'           => 'Points are calculated at 2% of the excl. tax amount of each sale.',

    // Show page – footer
    'footer_created'         => 'Created on',

    // Show page – JS SweetAlert strings
    'js_swal_activate_title' => 'Activate this client?',
    'js_swal_activate_text'  => 'The client will be able to log in and access their benefits.',
    'js_swal_activate_btn'   => 'Yes, activate',
    'js_swal_unblock_title'  => 'Unblock this client?',
    'js_swal_unblock_text'   => 'The client account will be reactivated.',
    'js_swal_unblock_btn'    => 'Yes, unblock',
    'js_swal_block_title'    => 'Block this client?',
    'js_swal_block_text'     => 'The client will no longer be able to log in or make requests.',
    'js_swal_block_btn'      => 'Yes, block',
    'js_swal_cancel'         => 'Cancel',
    'js_swal_confirm'        => 'Confirm?',
    'js_error_title'         => 'Error',
    'js_conn_error_title'    => 'Connection error',
    'js_conn_error_text'     => 'Unable to contact the server.',
    'js_block_client_btn'    => 'Block client',
    'js_status_ok'           => 'Status updated.',
];
