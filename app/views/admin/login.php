<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration — UDBL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: linear-gradient(135deg, #001f4d 0%, #003399 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,.4); overflow: hidden; max-width: 420px; width: 100%; }
        .login-header { background: #003366; padding: 2rem; text-align: center; }
        .login-header img { width: 70px; margin-bottom: .8rem; }
        .login-header h4 { color: #fff; font-weight: 700; margin: 0; }
        .login-header small { color: rgba(255,255,255,.6); font-size: .8rem; }
        .login-body { padding: 2rem; background: #fff; }
        .btn-admin { background: #003366; color: #fff; border: none; padding: .75rem; font-weight: 600; letter-spacing: .5px; }
        .btn-admin:hover { background: #002244; color: #fff; }
        .form-control:focus { border-color: #003366; box-shadow: 0 0 0 .2rem rgba(0,51,102,.2); }
        .badge-admin { background: #ffc107; color: #003366; font-size: .65rem; padding: 3px 8px; border-radius: 20px; font-weight: 700; }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="login-card">
        <div class="login-header">
            <img src="<?= APP_URL ?>/public/images/LOGO-UDBL1.webp" alt="Logo UDBL">
            <h4>Espace Administrateur</h4>
            <small>Université Don Bosco de Lubumbashi</small><br>
            <span class="badge-admin mt-2 d-inline-block">ACCÈS RESTREINT</span>
        </div>
        <div class="login-body">
            <?php if ($error): ?>
                <div class="alert alert-danger border-0 border-start border-danger border-3 py-2 small">
                    <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="<?= APP_URL ?>/index.php?url=admin/login/post">
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">ADRESSE EMAIL</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="admin@udbl.ac.cd" required autofocus>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold small text-muted">MOT DE PASSE</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-admin w-100 rounded-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                </button>
            </form>
            <div class="text-center mt-3">
                <a href="<?= APP_URL ?>/index.php" class="text-muted small text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i>Retour au site
                </a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
