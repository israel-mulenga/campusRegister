<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Candidats - CampusRegister</title>
    <link rel="stylesheet" href="../../style.css"> 
</head>
<body>
    <div class="dashboard-wrapper">
        <aside>
            <h3>UDBL Admin</h3>
            <nav>
                <a href="../dashboard-admin.php">Tableau de bord</a>
                <a href="liste.php">Candidats inscrits</a>
                <a href="#">Configuration</a>
                <a href="../../logout.php" style="margin-top: 50px; color: #ff9f1c;">Déconnexion</a>
            </nav>
        </aside>

        <main>
            <h1>Liste des Candidats Inscrits</h1>

            <table border="1" style="border-collapse: collapse; width: 100%; margin-top: 20px;">
                <thead>
                    <tr style="background-color: #0d3b66; color: white;">
                        <th style="padding: 10px;">ID</th>
                        <th>Nom & Prénom</th>
                        <th>Filière</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 10px; text-align: center;">1</td>
                        <td>Exemple Candidat</td>
                        <td>MSI</td>
                        <td>03/06/2026</td>
                        <td style="color: #ff9f1c; font-weight: bold;">En attente</td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>