<?php

define('APP_NAME', 'UDBL Pré-inscription');
define('APP_URL', getenv('APP_URL') ?: 'http://localhost:8080');
define('APP_ENV', getenv('APP_ENV') ?: 'development');

// Email (Gmail SMTP) — credentials loaded from environment variables
define('MAIL_HOST',      getenv('MAIL_HOST') ?: 'smtp.gmail.com');
define('MAIL_PORT',      (int)(getenv('MAIL_PORT') ?: 587));
define('MAIL_USERNAME',  getenv('MAIL_USERNAME') ?: '');
define('MAIL_PASSWORD',  getenv('MAIL_PASSWORD') ?: '');
define('MAIL_FROM',      getenv('MAIL_FROM') ?: '');
define('MAIL_FROM_NAME', getenv('MAIL_FROM_NAME') ?: 'UDBL Pré-inscription');

// Session
define('SESSION_NAME',     'udbl_session');
define('SESSION_LIFETIME', 7200);

// Pagination
define('ITEMS_PER_PAGE', 20);
