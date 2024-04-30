<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher des Tâches</title>
  <link rel="stylesheet" type="text/css" href="recherche.css">

</head>
<body>

    <!-- Formulaire de recherche -->
    <div class="container">
        <h2>Rechercher des tâches</h2>
        <form action="rechercher_taches.php" method="get">
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" placeholder="Entrez le titre de la tâche">
            <label for="description">Description :</label>
            <input type="text" id="description" name="description" placeholder="Entrez la description de la tâche">
            <label for="statut">Statut :</label>
            <input type="text" id="statut" name="statut" placeholder="Entrez le statut de la tâche">
            <label for="deadline">Date Limite :</label>
            <input type="date" id="deadline" name="deadline">
            <input type="submit" value="Rechercher">
        </form>
    </div>
 <a href="site_web.php">
                <img src="retour.png" alt="site_web.php" width="20" height="20">
            </a>
</body>
</html>
