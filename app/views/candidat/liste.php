<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Candidates - CampusRegister</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* Sidebar Style (Tâche 31: Fixée pour 1024px) */
        .sidebar {
            width: 260px;
            background-color: #0d3b66;
            color: white;
            padding: 25px 20px;
            display: flex;
            flex-direction: column;
            gap: 25px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            flex-shrink: 0; /* Empêche la sidebar de rétrécir */
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

        /* Main Content Style */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-x: hidden;
        }

        .main-content h1 {
            color: #0d3b66;
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 2rem;
        }

        /* Analytics Section (Tâche 29) */
        .analytics-container {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .analytics-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            flex: 1;
            min-width: 280px;
        }

        .chart-card {
            flex: 1.5;
            display: flex;
            justify-content: center;
            align-items: center;
            max-height: 260px;
        }

        /* Table Style */
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 20px;
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
        }

        tr:hover {
            background-color: #f8fafc;
        }

        /* Badges */
        .status {
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.85rem;
            display: inline-block;
        }
        .status.validated { color: #15803d; background-color: #dcfce7; }
        .status.pending { color: #b45309; background-color: #fef3c7; }
        .status.refused { color: #b91c1c; background-color: #fee2e2; }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 5px;
        }

        .pagination-info {
            color: #64748b;
            font-size: 0.9rem;
        }

        .pagination-buttons {
            display: flex;
            gap: 8px;
        }

        .page-btn {
            background-color: white;
            color: #0d3b66;
            border: 1px solid #cbd5e1;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .page-btn:hover:not(:disabled) {
            background-color: #0d3b66;
            color: white;
            border-color: #0d3b66;
        }

        .page-btn:disabled {
            color: #94a3b8;
            background-color: #f1f5f9;
            cursor: not-allowed;
            border-color: #e2e8f0;
        }

        /* Responsive Check at 1024px (Tâche 31) */
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
                padding: 20px 15px;
            }
            .main-content {
                padding: 25px;
            }
        }
    </style>
</head>
<body>

    <div class="dashboard-wrapper">
        
        <aside class="sidebar">
            <h3>UDBL Admin</h3>
            <nav>
                <a href="liste.php" class="active"> Registered Candidates</a>
                <a href="notifications.php"> Notifications</a>
                <a href="chatbot-config.php">Chatbot Config</a>
                <a href="../../logout.php" class="logout-btn"> Log Out</a>
            </nav>
        </aside>

        <main class="main-content">
            <h1>Admin Dashboard</h1>

            <div class="analytics-container">
                <div class="analytics-card">
                    <h3 style="color: #0d3b66; margin-top: 0;">Quick Stats</h3>
                    <p style="color: #64748b;">Total Registrations: <strong style="color: #0d3b66; font-size: 1.2rem;">25</strong></p>
                    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 15px 0;">
                    <p style="font-size: 0.9rem; color: #64748b;">
                         <strong>MSI:</strong> 12 candidates<br>
                         <strong>Law:</strong> 6 candidates<br>
                         <strong>Polytech:</strong> 4 candidates<br>
                         <strong>Economy:</strong> 3 candidates
                    </p>
                </div>
                
                <div class="analytics-card chart-card">
                    <canvas id="streamChart" style="max-width: 220px; max-height: 220px;"></canvas>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name & First name</th>
                            <th>Stream</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mpo Marie</td>
                            <td>MSI</td>
                            <td>01/06/2026</td>
                            <td><span class="status validated">Validated</span></td>
                        </tr>
                        <tr>
                            <td>Kaf Jean</td>
                            <td>MSI</td>
                            <td>02/06/2026</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>Tshimbo Carine</td>
                            <td>Law</td>
                            <td>02/06/2026</td>
                            <td><span class="status validated">Validated</span></td>
                        </tr>
                        <tr>
                            <td>Kabamba Christian</td>
                            <td>Economy</td>
                            <td>03/06/2026</td>
                            <td><span class="status refused">Refused</span></td>
                        </tr>
                        <tr>
                            <td>Mulongo Alice</td>
                            <td>MSI</td>
                            <td>03/06/2026</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                <div class="pagination-info">
                    Showing 1 to 5 of 25 candidates
                </div>
                <div class="pagination-buttons">
                    <button class="page-btn" disabled>Previous</button>
                    <button class="page-btn">Next</button>
                </div>
            </div>
        </main>

    </div>

    <script>
        const ctx = document.getElementById('streamChart').getContext('2d');
        const streamChart = new Chart(ctx, {
            type: 'doughnut', // Type de graphique en anneau
            data: {
                labels: ['MSI', 'Law', 'Polytech', 'Economy'],
                datasets: [{
                    label: 'Candidates per Stream',
                    data: [12, 6, 4, 3], // Tes données réelles ou de test
                    backgroundColor: [
                        '#0d3b66', // Bleu UDBL pour MSI
                        '#ff9f1c', // Orange pour Law
                        '#15803d', // Vert pour Polytech
                        '#64748b'  // Gris pour Economy
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right', // Place les légendes à droite du graphique
                        labels: {
                            font: {
                                family: 'Segoe UI',
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>