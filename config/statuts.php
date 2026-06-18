<?php

/**
 * Single source of truth for candidate statuses.
 *
 * Every controller, view, and service that needs status labels, colors,
 * or the list of valid statuses should reference these constants
 * instead of maintaining their own copy.
 */

const STATUT_LABELS = [
    'en_attente'      => 'En attente',
    'dossier_complet' => 'Dossier complet',
    'admis'           => 'Admis',
    'refuse'          => 'Refusé',
];

const STATUT_COLORS = [
    'en_attente'      => ['bg' => '#fff3cd', 'txt' => '#7d5a00', 'icon' => 'clock'],
    'dossier_complet' => ['bg' => '#cfe2ff', 'txt' => '#084298', 'icon' => 'folder-open'],
    'admis'           => ['bg' => '#d1e7dd', 'txt' => '#0a3622', 'icon' => 'check-circle'],
    'refuse'          => ['bg' => '#f8d7da', 'txt' => '#58151c', 'icon' => 'times-circle'],
];

const VALID_STATUTS = ['en_attente', 'dossier_complet', 'admis', 'refuse'];

function statutLabel(string $statut): string {
    return STATUT_LABELS[$statut] ?? $statut;
}

function statutBadgeHtml(string $statut): string {
    return match($statut) {
        'en_attente'      => '<span style="color:#e67e22">&#9203; En attente</span>',
        'dossier_complet' => '<span style="color:#2980b9">&#128203; Dossier complet</span>',
        'admis'           => '<span style="color:#27ae60">&#9989; Admis(e)</span>',
        'refuse'          => '<span style="color:#e74c3c">&#10060; Refus&eacute;(e)</span>',
        default           => htmlspecialchars($statut),
    };
}
