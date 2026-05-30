<?php
/**
 * Vue de la liste des candidats
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Candidats - Campus Register</title>
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
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        .container {
            padding: 30px;
        }
        .btn-back {
            background: #667eea;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }
        .btn-back:hover {
            background: #5568d3;
        }
        .alert {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background: #667eea;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background: #f9f9f9;
        }
        .status {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }
        .status.en_attente {
            background: #fff3cd;
            color: #856404;
        }
        .status.approuvé {
            background: #d4edda;
            color: #155724;
        }
        .status.rejeté {
            background: #f8d7da;
            color: #721c24;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .btn-edit, .btn-delete {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
        }
        .btn-edit {
            background: #2196F3;
            color: white;
        }
        .btn-edit:hover {
            background: #0b7dda;
        }
        .btn-delete {
            background: #d32f2f;
            color: white;
        }
        .btn-delete:hover {
            background: #b71c1c;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a {
            background: #667eea;
            color: white;
            padding: 8px 12px;
            margin: 0 5px;
            border-radius: 5px;
            text-decoration: none;
        }
        .pagination a:hover {
            background: #5568d3;
        }
        .pagination .current {
            background: #764ba2;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 10px;
            width: 400px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: black;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group button {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .form-group button:hover {
            background: #5568d3;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Gestion des Candidats</h1>
        <a href="?page=admin&action=dashboard">← Retour au tableau de bord</a>
    </div>
    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <h2>Liste des candidats (<?php echo $totalCandidats ?? 0; ?> total)</h2>

        <?php if (empty($candidats)): ?>
            <p>Aucun candidat trouvé.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidats as $candidat): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($candidat['id']); ?></td>
                            <td><?php echo htmlspecialchars(trim(($candidat['nom'] ?? '') . ' ' . ($candidat['prenom'] ?? ''))); ?></td>
                            <td><?php echo htmlspecialchars($candidat['email'] ?? ''); ?></td>
                            <td>
                                <span class="status <?php echo htmlspecialchars($candidat['statut'] ?? 'en_attente', ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($candidat['statut'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($candidat['created_at'] ?? 'now')); ?></td>
                            <td>
                                <div class="actions">
                                    <button class="btn-edit" onclick="openUpdateModal(<?php echo $candidat['id']; ?>, '<?php echo htmlspecialchars($candidat['statut'] ?? '', ENT_QUOTES, 'UTF-8'); ?>')">
                                        Modifier
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=admin&action=listeCandidats&page=<?php echo $i; ?>" 
                           class="<?php echo $i == ($page ?? 1) ? 'current' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Modal de mise à jour du statut -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeUpdateModal()">&times;</span>
            <h2>Mettre à jour le statut</h2>
            <form method="POST" action="?page=admin&action=updateStatut">
                <input type="hidden" id="candidatId" name="candidat_id" value="">
                <div class="form-group">
                    <label for="status">Nouveau statut</label>
                    <select id="status" name="status" required>
                        <option value="">-- Sélectionnez un statut --</option>
                        <option value="en_attente">En attente</option>
                        <option value="approuvé">Approuvé</option>
                        <option value="rejeté">Rejeté</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit">Valider</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openUpdateModal(candidatId, currentStatus) {
            document.getElementById('candidatId').value = candidatId;
            document.getElementById('status').value = currentStatus;
            document.getElementById('updateModal').style.display = 'block';
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('updateModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
