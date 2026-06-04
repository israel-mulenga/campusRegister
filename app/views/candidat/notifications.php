<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - CampusRegister</title>
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

        /* Sidebar Style */
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

        /* Main Content Style */
        .main-content {
            flex: 1;
            padding: 40px;
        }

        .main-content h1 {
            color: #0d3b66;
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 2rem;
        }

        /* Notifications Container */
        .notifications-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .notification-item {
            background-color: white;
            border-left: 5px solid #0d3b66;
            padding: 20px;
            border-radius: 0 8px 8px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s;
        }

        .notification-item:hover {
            transform: translateX(4px);
        }

        .notification-item.unread {
            border-left-color: #ff9f1c;
            background-color: #fffbeb;
        }

        .notification-content {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .notification-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 1.05rem;
        }

        .notification-text {
            color: #64748b;
            font-size: 0.95rem;
        }

        .notification-time {
            color: #94a3b8;
            font-size: 0.8rem;
            margin-top: 2px;
        }

        /* Badge unread */
        .unread-badge {
            background-color: #ff9f1c;
            color: #0d3b66;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .read-badge {
            background-color: #e2e8f0;
            color: #64748b;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="dashboard-wrapper">
        
        <aside class="sidebar">
            <h3>UDBL Admin</h3>
            <nav>
                <a href="liste.php"> Registered Candidates</a>
                <a href="notifications.php" class="active"> Notifications</a>
                <a href="chatbot-config.php"> Chatbot Config</a>
                <a href="../../logout.php" class="logout-btn"> Log Out</a>
            </nav>
        </aside>

        <main class="main-content">
            <h1>System Notifications</h1>

            <div class="notifications-list">
                
                <div class="notification-item unread">
                    <div class="notification-content">
                        <div class="notification-title">
New Candidate Registration</div>
                        <div class="notification-text">A new student, <strong>Mpo Marie</strong>, has just submitted an application for MSI stream.</div>
                        <div class="notification-time">5 minutes ago</div>
                    </div>
                    <span class="unread-badge">New</span>
                </div>

                <div class="notification-item unread">
                    <div class="notification-content">
                        <div class="notification-title">
New Candidate Registration</div>
                        <div class="notification-text">A new student, <strong>Kaf Jean</strong>, has registered for MSI stream.</div>
                        <div class="notification-time">1 hour ago</div>
                    </div>
                    <span class="unread-badge">New</span>
                </div>

                <div class="notification-item">
                    <div class="notification-content">
                        <div class="notification-title">
Document Update</div>
                        <div class="notification-text">Candidate <strong>Kabamba Christian</strong> updated their profile files.</div>
                        <div class="notification-time">Yesterday</div>
                    </div>
                    <span class="read-badge">Read</span>
                </div>

            </div>
        </main>

    </div>

</body>
</html>