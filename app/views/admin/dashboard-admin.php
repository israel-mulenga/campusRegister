<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - CampusRegister</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <div class="dashboard-wrapper">
        <aside>
            <h3>UDBL Admin</h3>
            <nav>
                <a href="dashboard-admin.php">Tableau de bord</a>
                <a href="candidat/liste.php">Candidats inscrits</a>
                <a href="#">Configuration</a>
                <a href="../logout.php" style="margin-top: 50px; color: #ff9f1c;">Déconnexion</a>
            </nav>
        </aside>

        <main>
            <h1>Tableau de Bord</h1>
            
            <div class="kpi-container">
                <div class="kpi-card">
                    <h4>Total Candidats</h4>
                    <p>142</p>
                </div>
                <div class="kpi-card">
                    <h4>En attente</h4>
                    <p>35</p>
                </div>
                <div class="kpi-card">
                    <h4>Validés</h4>
                    <p>107</p>
                </div>
            </div>

            <h2>Liste des récents candidats</h2>
            <table border="1" style="border-collapse: collapse; width: 100%; margin-top: 20px;">
                <thead>
                    <tr>
                        <th>Nom & Prénom</th>
                        <th>Filière demandée</th>
                        <th>Date d'inscription</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ilunga Kazadi Jean</td>
                        <td>Management des Systèmes d'Information (MSI)</td>
                        <td>02/06/2026</td>
                        <td style="color: #ff9f1c; font-weight: bold;">En attente</td>
                        <td>
                            <button class="btn btn-validate">Valider</button>
                            <button class="btn btn-reject">Rejeter</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Kabange Mwamba Sarah</td>
                        <td>Sciences Informatiques</td>
                        <td>01/06/2026</td>
                        <td style="color: #2ec4b6; font-weight: bold;">Validé</td>
                        <td>
                            <button class="btn btn-reject">Annuler</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>

</body>
</html>