<?php
// configuration generale 
define('APP_NAME', 'UDBL Pré-inscription');
define('APP_URL', 'http://localhost/campusRegister');
define('APP_ENV',  'development');    // 'production' en ligne

// ── Email (PHPMailer / Gmail SMTP) 
define('MAIL_HOST',     'smtp.gmail.com');
define('MAIL_PORT',     587);
define('MAIL_USERNAME', 'jiressealfred067@gmail.com');    // ← votre compte Gmail
define('MAIL_PASSWORD', 'myavfureottvcjkc');      // ← mot de passe d'application Gmail
define('MAIL_FROM',     'jiressealfred067@gmail.com');
define('MAIL_FROM_NAME','UDBL Pré-inscription');

// ── Session ───────────────────────────────────────────────────
define('SESSION_NAME',     'udbl_session');
define('SESSION_LIFETIME', 7200); // 2 heures

// ── Pagination ────────────────────────────────────────────────
define('ITEMS_PER_PAGE', 20);
