<?php

return [
    // Shared status labels
    'status_active'          => 'Actif',
    'status_inactive'        => 'Inactif',
    'status_blocked'         => 'Bloqué',

    // Shared action buttons
    'action_view'            => 'Voir',
    'action_activate'        => 'Activer',
    'action_unblock'         => 'Débloquer',
    'action_block'           => 'Bloquer',

    // _cards partial
    'no_pcc_code'            => 'Pas de code PCC',

    // Index page – header
    'breadcrumb_admin'       => 'Administration',
    'page_title'             => 'Clients',
    'page_subtitle'          => "Vue d'ensemble de votre base clients, activité et points de fidélité.",

    // Index page – stat tiles
    'stat_total'             => 'Total Clients',
    'stat_total_sub'         => 'Base clients enregistrés',
    'stat_active'            => 'Clients Actifs',
    'stat_active_sub'        => ':pct% du total',
    'stat_new'               => 'Nouveaux ce mois',
    'stat_new_sub'           => 'Inscrits ce mois-ci',
    'stat_points'            => 'Points Distribués',
    'stat_points_sub'        => 'Total tous clients',

    // Index page – toolbar
    'search_placeholder'     => 'Rechercher un client…',
    'filter_all'             => 'Tous',
    'filter_active'          => 'Actifs',
    'filter_inactive'        => 'Inactifs',
    'filter_blocked'         => 'Bloqués',
    'view_grid'              => 'Grille',
    'view_list'              => 'Liste',
    'export_csv'             => 'Exporter CSV',
    'results_hint'           => 'Cliquez sur une carte pour voir le détail',
    'result_suffix'          => 'clients',

    // Index page – table headers
    'col_client'             => 'Client',
    'col_phone'              => 'Téléphone',
    'col_email'              => 'Email',
    'col_pcc_code'           => 'Code PCC',
    'col_sales_points'       => 'Ventes / Points',
    'col_status'             => 'Statut',
    'col_actions'            => 'Actions',

    // Index page – loader / empty state
    'loading'                => 'Chargement…',
    'no_results'             => 'Aucun client trouvé',
    'no_results_sub'         => 'Essayez un autre terme de recherche',
    'reset_search'           => 'Réinitialiser la recherche',

    // Index page – JS strings (SweetAlert / toasts)
    'js_confirm_title'       => 'Confirmation',
    'js_confirm_html'        => 'Voulez-vous vraiment <strong>:verb</strong> <strong>:name</strong> ?',
    'js_cancel'              => 'Annuler',
    'js_status_updated'      => 'Statut mis à jour.',
    'js_conn_error'          => 'Erreur de connexion.',
    'js_error_occurred'      => 'Une erreur est survenue.',
    'js_verb_activate'       => 'activer',
    'js_verb_block'          => 'bloquer',
    'js_verb_unblock'        => 'débloquer',

    // Show page – header / navigation
    'show_title'             => 'Détail client',
    'btn_back'               => 'Retour',

    // Show page – profile card labels
    'label_pcc_code'         => 'Code PCC',
    'label_member_since'     => 'Membre depuis',
    'label_validated_on'     => 'Compte validé le',
    'label_bonus_requests'   => 'Demandes bonus',
    'pending_validation'     => 'En attente',
    'label_points_balance'   => 'Solde de points',
    'sales_suffix'           => ':amount MAD de ventes',
    'btn_copy'               => 'Copier',

    // Show page – stat tiles
    'tile_points_sub'        => 'Total accumulé',
    'tile_sales'             => 'Total des ventes',
    'tile_sales_sub'         => 'Cumul des achats',
    'tile_status'            => 'Statut',
    'tile_status_sub'        => 'État du compte',
    'tile_member'            => 'Membre depuis',

    // Show page – charts
    'chart_points_title'     => 'Aperçu des points',
    'chart_points_sub'       => 'Gagnés · Utilisés · Solde',
    'chart_status_title'     => 'Répartition des demandes',
    'chart_no_data'          => 'Aucune donnée',
    'chart_earned'           => 'Points gagnés',
    'chart_used'             => 'Points utilisés',
    'chart_balance'          => 'Solde actuel',
    'chart_total'            => 'Total',

    // Show page – tabs
    'tab_info'               => 'Informations',
    'tab_activity'           => "Journal d'activité",
    'tab_loyalty'            => 'Fidélité & ventes',

    // Show page – info tab rows
    'info_company'           => 'Raison sociale',
    'info_contact'           => 'Personne de contact',
    'info_phone'             => 'Téléphone',
    'info_email'             => 'Email',
    'info_pcc_code'          => 'Code PCC',
    'info_member_since'      => 'Membre depuis',
    'info_status'            => 'Statut',

    // Show page – activity log
    'log_deleted_level'      => 'Niveau supprimé',
    'log_pts_required'       => 'pts requis',
    'log_no_activity'        => 'Aucune activité',
    'log_no_activity_sub'    => "Ce client n'a pas encore de demande de bonus.",

    // Show page – log status labels
    'log_pending'            => 'En attente',
    'log_approved'           => 'Approuvée',
    'log_rejected'           => 'Rejetée',
    'log_delivered'          => 'Livrée',

    // Show page – loyalty tab
    'loyalty_balance'        => 'Solde de points',
    'loyalty_sales'          => 'Total des ventes',
    'loyalty_used'           => 'Points utilisés',
    'loyalty_total_req'      => 'Demandes totales',
    'loyalty_approved'       => 'Demandes approuvées',
    'loyalty_rate'           => 'Taux de fidélité',
    'loyalty_rate_sub'       => '% du HT',
    'loyalty_note'           => 'Les points sont calculés à raison de 2 % du montant HT de chaque vente.',

    // Show page – footer
    'footer_created'         => 'Créé le',

    // Show page – JS SweetAlert strings
    'js_swal_activate_title' => 'Activer ce client ?',
    'js_swal_activate_text'  => 'Le client pourra se connecter et accéder à ses avantages.',
    'js_swal_activate_btn'   => 'Oui, activer',
    'js_swal_unblock_title'  => 'Débloquer ce client ?',
    'js_swal_unblock_text'   => 'Le compte du client sera réactivé.',
    'js_swal_unblock_btn'    => 'Oui, débloquer',
    'js_swal_block_title'    => 'Bloquer ce client ?',
    'js_swal_block_text'     => 'Le client ne pourra plus se connecter ni effectuer de demandes.',
    'js_swal_block_btn'      => 'Oui, bloquer',
    'js_swal_cancel'         => 'Annuler',
    'js_swal_confirm'        => 'Confirmer ?',
    'js_error_title'         => 'Erreur',
    'js_conn_error_title'    => 'Erreur de connexion',
    'js_conn_error_text'     => 'Impossible de contacter le serveur.',
    'js_block_client_btn'    => 'Bloquer le client',
    'js_status_ok'           => 'Statut mis à jour.',
];
