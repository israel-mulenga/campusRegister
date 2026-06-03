<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Administration - campusRegister</title>
    <link rel="stylesheet" href="../style.css"> <!-- Lien vers ton style.css -->
</head>
<body>
    <div class="login-container">
        <h2>Connexion Admin</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Adresse Email :</label>
                <input type="email" id="email" name="email" required placeholder="Ex: admin@udbl.edu">
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>
            
            <button type="submit" class="btn-submit">Se connecter</button>
        </form>
    </div>
</body>
</html>