<?php

return [
    // ── Shared breadcrumb ──
    'breadcrumb_communication' => 'Communication',

    // ══════════════════════════════════════════
    // ── Compose (index) page ──
    // ══════════════════════════════════════════
    'compose_breadcrumb'       => 'Notifier les clients',
    'compose_title'            => 'Notifier les clients',
    'compose_subtitle'         => 'Envoyez un message ciblé à vos clients par push, e-mail ou WhatsApp.',
    'btn_history'              => 'Historique',

    // Compose – stat tiles
    'stat_total_clients'       => 'Total Clients',
    'stat_with_email'          => 'Avec e-mail',
    'stat_with_phone'          => 'Avec téléphone',
    'stat_active_clients'      => 'Clients actifs',

    // Compose – recipients panel
    'label_recipients'         => 'Destinataires',
    'btn_select_all'           => 'Tout sélectionner',
    'btn_select_none'          => 'Aucun',
    'placeholder_clients'      => 'Choisir un ou plusieurs clients…',
    'recipients_count'         => 'client(s) sélectionné(s)',

    // Compose – channels panel
    'label_channels'           => "Canaux d'envoi",
    'channel_push_name'        => 'Push',
    'channel_push_sub'         => 'Notification in-app',
    'channel_email_name'       => 'E-mail',
    'channel_reachable'        => ':count joignables',
    'channel_whatsapp_name'    => 'WhatsApp',

    // Compose – message panel
    'label_title'              => 'Titre',
    'placeholder_title'        => 'Ex : Nouvelle offre de fidélité',
    'label_message'            => 'Message',
    'placeholder_message'      => 'Rédigez votre message…',

    // Compose – preview panel
    'label_preview'            => 'Aperçu',
    'preview_default_title'    => 'Titre du message',
    'preview_default_body'     => 'Le contenu de votre message apparaîtra ici…',
    'preview_no_channel'       => 'Aucun canal sélectionné',

    // Compose – submit
    'btn_send'                 => 'Envoyer le message',
    'send_hint'                => 'Sélectionnez au moins un client et un canal.',

    // ══════════════════════════════════════════
    // ── History page ──
    // ══════════════════════════════════════════
    'history_breadcrumb'       => 'Historique des messages',
    'history_title'            => 'Historique des messages',
    'history_subtitle'         => 'Suivez tous les messages envoyés, leurs canaux et leur livraison.',
    'btn_new_message'          => 'Nouveau message',

    // History – stat tiles
    'stat_messages_sent'       => 'Messages envoyés',
    'stat_delivered'           => 'Livraisons réussies',
    'stat_partial'             => 'Partiellement livrés',
    'stat_failed'              => 'Échecs',

    // History – charts
    'chart_trend_title'        => 'Activité des 14 derniers jours',
    'chart_trend_sub'          => 'Livraisons réussies et échecs par jour',
    'legend_delivered'         => 'Livrés',
    'legend_failed'            => 'Échecs',
    'chart_channels_title'     => 'Répartition par canal',
    'chart_channels_sub'       => 'Messages utilisant chaque canal',

    // History – chart.js dataset labels
    'dataset_delivered'        => 'Livrés',
    'dataset_failed'           => 'Échecs',

    // History – grid panel
    'grid_title'               => 'Messages envoyés',
    'grid_subtitle'            => 'Tous les messages avec leurs canaux, expéditeur et livraison',
    'search_placeholder'       => 'Rechercher un message…',
    'btn_export'               => 'Export',

    // History – AG Grid column headers
    'col_message'              => 'Message',
    'col_channels'             => 'Canaux',
    'col_sent_by'              => 'Envoyé par',
    'col_recipients'           => 'Destinataires',
    'col_delivered'            => 'Livrés',
    'col_failed'               => 'Échecs',
    'col_status'               => 'Statut',
    'col_date'                 => 'Date',

    // History – status labels
    'status_sent'              => 'Livré',
    'status_partial'           => 'Partiel',
    'status_failed'            => 'Échec',
    'status_queued'            => 'En file',

    // History – fallback sender
    'sender_system'            => 'Système',

    // History – actions
    'col_actions'              => 'Actions',
    'action_detail'            => 'Détails',
    'action_resend'            => 'Renvoyer',

    // Resend feedback
    'resend_none'              => 'Aucun destinataire en échec à renvoyer.',
    'resend_started'           => 'Renvoi en cours vers :count destinataire(s) en échec.',
    'resend_confirm'           => 'Renvoyer le message aux destinataires en échec ?',

    // Detail modal
    'detail_title'             => 'Détail du message',
    'detail_recipients'        => 'Destinataires',
    'detail_recipient'         => 'Destinataire',
    'detail_channel'           => 'Canal',
    'detail_status'            => 'Statut',
    'detail_error'             => 'Erreur',
    'detail_sent_at'           => 'Envoyé le',
    'detail_close'             => 'Fermer',
    'detail_no_recipients'     => 'Aucun destinataire.',
    'detail_loading'           => 'Chargement…',
    'detail_load_error'        => 'Impossible de charger le détail du message.',
    'status_pending'           => 'En attente',
];
