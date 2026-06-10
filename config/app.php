<?php

/**
 * Configuration de l'application
 */

define('APP_NAME', 'UDBL Pré-inscription');
define('APP_URL', 'http://localhost:8000'); 
define('APP_ENV', 'development'); // Changez en 'production' pour la production

// Email (Gmail SMTP)
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', '23ik069si@esisalama.org');
define('MAIL_PASSWORD', 'gdzd rrou srdw fbpn');
define('MAIL_FROM', '23ik069si@esisalama.org');
define('MAIL_FROM_NAME', 'UDBL Pré-inscription');

// ── Session ───────────────────────────────────────────────────
define('SESSION_NAME',     'udbl_session');
define('SESSION_LIFETIME', 7200); // 2 heures

// pagination
define('ITEMS_PER_PAGE', 20);