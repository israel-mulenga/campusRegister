<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Configuration - CampusRegister</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }
        
        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Barre latérale (Sidebar) */
        .sidebar {
            width: 260px;
            background-color: #0d3b66;
            color: white;
            padding: 25px 20px;
            display: flex;
            flex-direction: column;
            gap: 25px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar h3 {
            color: #ff9f1c;
            margin: 0 0 10px 0;
            border-bottom: 2px solid #ff9f1c;
            padding-bottom: 10px;
            font-size: 1.3rem;
        }

        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sidebar nav a {
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-weight: 500;
            display: block;
        }

        .sidebar nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar nav a.active {
            color: #0d3b66;
            background-color: #ff9f1c;
            font-weight: bold;
        }

        .logout-btn {
            margin-top: auto;
            color: #fca5a5;
            border: 1px solid rgba(248, 113, 113, 0.4);
            text-align: center;
        }

        .logout-btn:hover {
            background-color: #ef4444;
            color: white;
        }

        /* Contenu principal */
        .main-content {
            flex: 1;
            padding: 40px;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .header-section h1 {
            color: #0d3b66;
            margin: 0;
            font-size: 2rem;
        }

        /* Bouton Ajouter */
        .add-btn {
            background-color: #15803d;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .add-btn:hover {
            background-color: #166534;
        }

        /* Tableau */
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background-color: #0d3b66;
            color: white;
            padding: 15px 20px;
            font-weight: 600;
        }

        td {
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            vertical-align: top;
        }

        tr:hover {
            background-color: #f8fafc;
        }

        /* Boutons d'action */
        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .edit-btn {
            background-color: #fef3c7;
            color: #d97706;
        }

        .edit-btn:hover {
            background-color: #fde68a;
        }

        .delete-btn {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .delete-btn:hover {
            background-color: #fecaca;
        }
    </style>
</head>
<body>

    <div class="dashboard-wrapper">
        
        <aside class="sidebar">
            <h3>UDBL Admin</h3>
            <nav>
                <a href="liste.php"> Candidats inscrits</a>
                <a href="notifications.php"> Notifications</a>
                <a href="chatbot-config.php" class="active">Config Chatbot</a>
                <a href="../../logout.php" class="logout-btn"> Déconnexion</a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="header-section">
                <h1>Chatbot FAQ Configuration</h1>
                <button class="add-btn"> Add New Question</button>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 35%;">Keywords / Question</th>
                            <th style="width: 45%;">Automated Answer</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><strong>Inscription, S'inscrire, Dates</strong></td>
                            <td>Les inscriptions pour l'année académique ouverte se clôturent le 30 octobre.</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn">Modifier</button>
                                    <button class="action-btn delete-btn">Supprimer</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><strong>Frais, Minerval, Coût</strong></td>
                            <td>Les frais de scolarité varient selon les facultés. Veuillez consulter la section Économat.</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn">Modifier</button>
                                    <button class="action-btn delete-btn">Supprimer</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><strong>Filières, Options, MSI</strong></td>
                            <td>L'UDBL propose les filières MSI, Sciences Juridiques, Polytechnique et Sciences Économiques.</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn">Modifier</button>
                                    <button class="action-btn delete-btn">Supprimer</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>

    </div>

</body>
</html>