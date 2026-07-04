<?php

return [
    // ── Shared breadcrumb ──
    'breadcrumb_communication' => 'Communication',

    // ══════════════════════════════════════════
    // ── Compose (index) page ──
    // ══════════════════════════════════════════
    'compose_breadcrumb'       => 'Notify clients',
    'compose_title'            => 'Notify clients',
    'compose_subtitle'         => 'Send a targeted message to your clients via push, e-mail or WhatsApp.',
    'btn_history'              => 'History',

    // Compose – stat tiles
    'stat_total_clients'       => 'Total Clients',
    'stat_with_email'          => 'With e-mail',
    'stat_with_phone'          => 'With phone',
    'stat_active_clients'      => 'Active clients',

    // Compose – recipients panel
    'label_recipients'         => 'Recipients',
    'btn_select_all'           => 'Select all',
    'btn_select_none'          => 'None',
    'placeholder_clients'      => 'Choose one or more clients…',
    'recipients_count'         => 'client(s) selected',

    // Compose – channels panel
    'label_channels'           => 'Sending channels',
    'channel_push_name'        => 'Push',
    'channel_push_sub'         => 'In-app notification',
    'channel_email_name'       => 'E-mail',
    'channel_reachable'        => ':count reachable',
    'channel_whatsapp_name'    => 'WhatsApp',

    // Compose – message panel
    'label_title'              => 'Title',
    'placeholder_title'        => 'Ex: New loyalty offer',
    'label_message'            => 'Message',
    'placeholder_message'      => 'Write your message…',

    // Compose – preview panel
    'label_preview'            => 'Preview',
    'preview_default_title'    => 'Message title',
    'preview_default_body'     => 'Your message content will appear here…',
    'preview_no_channel'       => 'No channel selected',

    // Compose – submit
    'btn_send'                 => 'Send message',
    'send_hint'                => 'Select at least one client and one channel.',

    // ══════════════════════════════════════════
    // ── History page ──
    // ══════════════════════════════════════════
    'history_breadcrumb'       => 'Message history',
    'history_title'            => 'Message history',
    'history_subtitle'         => 'Track all sent messages, their channels and delivery.',
    'btn_new_message'          => 'New message',

    // History – stat tiles
    'stat_messages_sent'       => 'Messages sent',
    'stat_delivered'           => 'Successful deliveries',
    'stat_partial'             => 'Partially delivered',
    'stat_failed'              => 'Failures',

    // History – charts
    'chart_trend_title'        => 'Activity over the last 14 days',
    'chart_trend_sub'          => 'Successful deliveries and failures per day',
    'legend_delivered'         => 'Delivered',
    'legend_failed'            => 'Failures',
    'chart_channels_title'     => 'Breakdown by channel',
    'chart_channels_sub'       => 'Messages using each channel',

    // History – chart.js dataset labels
    'dataset_delivered'        => 'Delivered',
    'dataset_failed'           => 'Failures',

    // History – grid panel
    'grid_title'               => 'Sent messages',
    'grid_subtitle'            => 'All messages with their channels, sender and delivery',
    'search_placeholder'       => 'Search a message…',
    'btn_export'               => 'Export',

    // History – AG Grid column headers
    'col_message'              => 'Message',
    'col_channels'             => 'Channels',
    'col_sent_by'              => 'Sent by',
    'col_recipients'           => 'Recipients',
    'col_delivered'            => 'Delivered',
    'col_failed'               => 'Failures',
    'col_status'               => 'Status',
    'col_date'                 => 'Date',

    // History – status labels
    'status_sent'              => 'Delivered',
    'status_partial'           => 'Partial',
    'status_failed'            => 'Failed',
    'status_queued'            => 'Queued',

    // History – fallback sender
    'sender_system'            => 'System',

    // History – actions
    'col_actions'              => 'Actions',
    'action_detail'            => 'Details',
    'action_resend'            => 'Resend',

    // Resend feedback
    'resend_none'              => 'No failed recipients to resend.',
    'resend_started'           => 'Resending to :count failed recipient(s).',
    'resend_confirm'           => 'Resend the message to failed recipients?',

    // Detail modal
    'detail_title'             => 'Message detail',
    'detail_recipients'        => 'Recipients',
    'detail_recipient'         => 'Recipient',
    'detail_channel'           => 'Channel',
    'detail_status'            => 'Status',
    'detail_error'             => 'Error',
    'detail_sent_at'           => 'Sent at',
    'detail_close'             => 'Close',
    'detail_no_recipients'     => 'No recipients.',
    'detail_loading'           => 'Loading…',
    'detail_load_error'        => 'Unable to load message detail.',
    'status_pending'           => 'Pending',
];
