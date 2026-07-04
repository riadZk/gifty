<?php

return [
    // ── Shared status labels ──
    'status_pending'           => 'En attente',
    'status_approved'          => 'Approuvée',
    'status_rejected'          => 'Rejetée',
    'status_delivered'         => 'Livrée',

    // ── Index page ──
    'breadcrumb_loyalty'       => 'Fidélité',
    'page_title'               => 'Demandes Bonus',
    'page_subtitle'            => 'Suivez et traitez les demandes de bonus soumises par les clients.',

    // Index – stat tiles
    'stat_total'               => 'Total Demandes',
    'stat_total_sub'           => 'Toutes demandes confondues',
    'stat_pending'             => 'En Attente',
    'stat_pending_sub'         => ':pct% du total',
    'stat_approved_delivered'  => 'Approuvées / Livrées',
    'stat_approved_sub'        => 'Taux : :rate%',
    'stat_points_pending'      => 'Points en Attente',
    'stat_rejected_sub'        => ':count demande(s) rejetée(s)',

    // Index – toolbar
    'search_placeholder'       => 'Rechercher un client, bonus…',
    'filter_placeholder'       => 'Tous les statuts',
    'btn_reset'                => 'Réinitialiser',
    'no_results'               => 'Aucune demande trouvée',
    'loading'                  => 'Chargement…',

    // Index – JS card renderer
    'js_loyalty_bonus'         => 'Bonus fidélité',
    'js_pts_required'          => 'pts requis',
    'js_view'                  => 'Voir',
    'js_counter_singular'      => 'demande',
    'js_counter_plural'        => 'demandes',

    // ── Show page ──
    'btn_back'                 => 'Retour',
    'breadcrumb_requests'      => 'Demandes Bonus',
    'show_title'               => 'Détail de la demande bonus',
    'show_subtitle'            => 'Consultez toutes les informations relatives à cette demande',

    // Show – status banner
    'current_status'           => 'Statut actuel :',
    'submitted_on'             => 'Soumise le',
    'id_label'                 => 'ID :',

    // Show – client card
    'client_active'            => 'Client actif',
    'client_blocked'           => 'Bloqué',
    'label_pcc_code'           => 'Code PCC',
    'label_email'              => 'Email',
    'label_phone'              => 'Téléphone',
    'label_member_since'       => 'Membre depuis',

    // Show – summary card
    'summary_title'            => 'Résumé de la demande',
    'summary_date'             => 'Date',
    'summary_requested_by'     => 'Demandé par',
    'summary_channel'          => 'Canal',
    'summary_channel_value'    => 'Portail client',
    'summary_notes'            => 'Notes du client',

    // Show – bonus card
    'bonus_card_title'         => 'Bonus demandé',
    'bonus_active_badge'       => 'Bonus actif',
    'bonus_pts_required'       => 'Points requis',
    'bonus_quantity'           => 'Quantité',
    'bonus_value'              => 'Valeur estimée',

    // Show – points situation
    'points_title'             => 'Situation des points du client',
    'points_current'           => 'Solde actuel',
    'points_before_label'      => 'Avant cette demande',
    'points_required_label'    => 'Points requis',
    'points_for_bonus'         => 'Pour ce bonus',
    'points_after'             => 'Solde après échange',
    'points_if_approved'       => 'Si approuvée',
    'points_remaining_svg'     => 'Restants',
    'points_insufficient'      => 'Solde insuffisant — il manque :pts pts',

    // Show – timeline
    'timeline_title'           => 'Suivi de la demande',
    'step_created'             => 'Demande créée',
    'step_pending'             => 'En attendant validation',
    'step_pending_sub'         => "Par l'administrateur",
    'step_approved'            => 'Approuvée',
    'step_preparing'           => 'Préparée pour livraison',
    'step_delivered'           => 'Livrée au client',

    // Show – actions
    'actions_title'            => 'Actions administrateur',
    'btn_approve'              => 'Approuver la demande',
    'btn_reject'               => 'Refuser la demande',
    'btn_more_info'            => "Demander plus d'informations",
    'approved_hint'            => 'Le bonus a été approuvé. Marquez-le comme livré une fois remis au client.',
    'btn_deliver'              => 'Marquer comme livré',
    'rejected_label'           => 'Demande rejetée',
    'delivered_label'          => 'Bonus livré',
    'delivered_done'           => 'Cette demande est terminée.',
    'comment_label'            => 'Commentaires (optionnel)',
    'comment_placeholder'      => 'Ajouter un commentaire...',

    // Show – transaction
    'tx_title'                 => 'Transaction de Points',
    'tx_before'                => 'Avant',
    'tx_deducted'              => 'Déduits',
    'tx_after'                 => 'Après',

    // Show – JS SweetAlert (approve)
    'js_approve_title'         => 'Approuver la demande ?',
    'js_approve_html'          => 'Cela déduira <strong style="color:#f59e0b">:pts pts</strong> du solde du client.',
    'js_approve_btn'           => '✓ Approuver',
    'js_approve_ok_title'      => 'Approuvée !',
    'js_approve_ok_text'       => 'Les points ont été déduits.',

    // Show – JS SweetAlert (reject)
    'js_reject_title'          => 'Refuser la demande ?',
    'js_reject_html_hint'      => 'Vous pouvez ajouter un motif de refus.',
    'js_reject_placeholder'    => 'Motif du refus (optionnel)…',
    'js_reject_btn'            => '✗ Refuser',
    'js_reject_ok_title'       => 'Demande refusée',
    'js_reject_ok_text'        => 'La demande a été marquée comme rejetée.',

    // Show – JS SweetAlert (deliver)
    'js_deliver_title'         => 'Confirmer la livraison ?',
    'js_deliver_text'          => 'Le bonus a bien été remis au client ?',
    'js_deliver_btn'           => '→ Confirmer',
    'js_deliver_ok_title'      => 'Bonus livré !',
    'js_deliver_ok_text'       => 'La demande est maintenant terminée.',

    // Show – JS shared
    'js_cancel'                => 'Annuler',
    'js_error_title'           => 'Erreur',
    'js_error_generic'         => 'Une erreur est survenue.',
    'js_processing'            => 'Traitement…',

    // ── Create page ──
    'create_breadcrumb'        => 'Nouvelle demande bonus',
    'create_points_label'      => 'Solde points',
    'create_choose_title'      => 'Choisir un bonus',
    'create_choose_sub'        => 'Sélectionnez le bonus que le client souhaite obtenir',
    'create_no_bonus'          => 'Aucun bonus actif configuré.',
    'create_badge_insufficient' => 'Insuffisant',
    'create_badge_available'   => 'Disponible',
    'create_pts_required'      => 'pts requis',
    'create_pts_remaining'     => 'Reste:',
    'create_pts_missing'       => 'Manque:',
    'create_notes_title'       => 'Notes',
    'create_notes_optional'    => '(optionnel)',
    'create_notes_placeholder' => 'Ajouter des informations complémentaires…',
    'create_btn_cancel'        => 'Annuler',
    'create_btn_submit'        => 'Soumettre la demande',

    // Create – how it works sidebar
    'create_how_title'         => 'Comment ça marche ?',
    'create_step1_title'       => 'Client sélectionne un bonus',
    'create_step1_desc'        => 'Le client choisit un niveau de bonus correspondant à ses points.',
    'create_step2_title'       => 'Demande soumise',
    'create_step2_desc'        => "L'administrateur crée la demande au nom du client.",
    'create_step3_title'       => 'Approbation admin',
    'create_step3_desc'        => "L'admin vérifie et approuve ou rejette la demande.",
    'create_step4_title'       => 'Points déduits',
    'create_step4_desc'        => 'Les points sont automatiquement déduits du solde client.',
    'create_step5_title'       => 'Bonus livré',
    'create_step5_desc'        => 'Le bonus physique est remis au client et la demande est clôturée.',

    // Create – pending sidebar
    'create_pending_count'     => ':count demande(s) en attente',
];
