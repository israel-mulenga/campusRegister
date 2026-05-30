<?php
/**
 * Vue du tableau de bord admin
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin - Campus Register</title>
    <link rel="stylesheet" href="<?php echo 'public/css/style.css'; ?>">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            margin: 0;
        }
        .navbar .user-info {
            text-align: right;
        }
        .navbar .user-info p {
            margin: 0;
            font-size: 14px;
        }
        .btn-logout {
            background: #d32f2f;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-logout:hover {
            background: #b71c1c;
        }
        .container {
            padding: 30px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .stat-card h3 {
            color: #667eea;
            font-size: 14px;
            text-transform: uppercase;
            margin: 0 0 10px 0;
        }
        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <h1>Campus Register - Admin</h1>
        </div>
        <div class="user-info">
            <p><strong><?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?></strong></p>
            <p><?php echo htmlspecialchars($_SESSION['admin_email'] ?? ''); ?></p>
            <form method="POST" action="?action=logout" style="margin: 0;">
                <button type="submit" class="btn-logout">Déconnexion</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h2>Tableau de bord</h2>

        <div class="stats">
            <div class="stat-card">
                <h3>Total Candidats</h3>
                <div class="number"><?php echo $totalCandidats ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>En Attente</h3>
                <div class="number" style="color: #ff9800;"><?php echo $candidatsEnAttente ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Approuvés</h3>
                <div class="number" style="color: #4caf50;"><?php echo $candidatsApprouves ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Rejetés</h3>
                <div class="number" style="color: #d32f2f;"><?php echo $candidatsRejetes ?? 0; ?></div>
            </div>
        </div>

        <div class="actions">
            <a href="?page=admin&action=listeCandidats" class="btn">Gérer les candidats</a>
        </div>
    </div>
</body>
</html>
