<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la recherche</title>
     <link rel="stylesheet" type="text/css" href="affichage_recherche.css">
  
</head>
<body>
    <div class="container">
        <?php
        session_start();

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION["username"])) {
            header("Location: login.php");
            exit();
        }

        // Connexion à la base de données
        $servername = "localhost";
        $username = "hocine"; // Nom d'utilisateur MySQL
        $password = "Houhou.100"; // Mot de passe MySQL
        $dbname = "formulaire"; // Nom de votre base de données
        $table = "gestion_tachess"; // Nom de votre table

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $conn->connect_error);
        }

        // Récupérer les termes de recherche
        $search_title = isset($_GET['title']) && !empty($_GET['title']) ? '%' . $_GET['title'] . '%' : null;
        $search_description = isset($_GET['description']) && !empty($_GET['description']) ? '%' . $_GET['description'] . '%' : null;
        $search_status = isset($_GET['status']) && !empty($_GET['status']) ? '%' . $_GET['status'] . '%' : null;
        $search_deadline = isset($_GET['deadline']) && !empty($_GET['deadline']) ? $_GET['deadline'] : null;
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

        // Requête SQL pour rechercher les tâches en fonction des critères de recherche
        $sql = "SELECT * FROM $table WHERE username = ?";
        $params = array("s", &$username);

        if ($search_title !== null) {
            $sql .= " AND title LIKE ?";
            $params[0] .= "s";
            $params[] = &$search_title;
        }

        if ($search_description !== null) {
            $sql .= " AND description LIKE ?";
            $params[0] .= "s";
            $params[] = &$search_description;
        }

        if ($search_status !== null) {
            $sql .= " AND statut LIKE ?";
            $params[0] .= "s";
            $params[] = &$search_status;
        }

        if ($search_deadline !== null) {
            $sql .= " AND deadline = ?";
            $params[0] .= "s";
            $params[] = &$search_deadline;
        }

        // Préparer la requête avec les paramètres
        $stmt = $conn->prepare($sql);

        // Vérifier si la préparation de la requête a échoué
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }

        // Associer les paramètres à la requête
        if (!call_user_func_array(array($stmt, 'bind_param'), $params)) {
            die("Erreur lors de l'association des paramètres : " . $stmt->error);
        }

        // Exécuter la requête
        if (!$stmt->execute()) {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }

        // Récupérer le résultat de la recherche
        $result = $stmt->get_result();

        // Afficher les résultats de la recherche
        if ($result->num_rows > 0) {
            echo "<h2>Résultats de la recherche :</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='task'>";
                echo "<ul>";
                echo "<li><strong>Titre :</strong> " . htmlspecialchars($row["title"]) . "</li>";
                echo "<li><strong>Description :</strong> " . htmlspecialchars($row["description"]) . "</li>";
                echo "<li><strong>Date Limite :</strong> " . htmlspecialchars($row["deadline"]) . "</li>";
                echo "<li><strong>Statut :</strong> " . htmlspecialchars($row["statut"]) . "</li>";
                echo "</ul>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-results'>Aucune tâche correspondant à votre recherche.</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
       <a href="lien_rechrche.php">
                <img src="retour.png" alt="lien_rechrche.php" width="20" height="20">
            </a>
</body>
</html>
