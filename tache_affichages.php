<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tâches</title>
    <link rel="stylesheet" type="text/css" href="afficahges.css">
    <?php include 'menu.php'; ?>
</head>
<body>
    <div>
        <h1 class="titre">Liste des Taches</h1>
        <div class="title">
        </div>
    </div>
    <table>
        <?php
        session_start();

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION["username"])) {
            header("Location: login.php");
            exit();
        }

        // Connexion à la base de données
        $servername = "localhost";
        $username_db = "hocine"; // Nom d'utilisateur MySQL
        $password_db = "Houhou.100"; // Mot de passe MySQL
        $dbname = "formulaire"; // Nom de votre base de données
        $table = "gestion_tachess"; // Nom de votre table

        $conn = new mysqli($servername, $username_db, $password_db, $dbname);
        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $conn->connect_error);
        }

        // Récupérer les tâches de l'utilisateur à partir de son nom d'utilisateur
        if(isset($_SESSION["username"])) {
            $username = $_SESSION["username"];
            // Modification de la requête SQL pour trier par ordre croissant des délais
            $sql = "SELECT id, title, description, deadline, statut FROM $table WHERE username = ? ORDER BY deadline ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            if (!$stmt->execute()) {
                die("Erreur lors de l'exécution de la requête : " . $stmt->error);
            }
            $result = $stmt->get_result();
            if (!$result) {
                die("Erreur lors de la récupération des résultats : " . $conn->error);
            }
        }
        ?>

        <?php
        // Afficher les tâches
        if ($result && $result->num_rows > 0) {
                  echo "<table border='1'>";
        echo "<tr><th>Titre</th><th>Description</th><th>Date Limite</th><th>Statut</th><th>Rappel</th><th colspan='2'>Action</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["deadline"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["statut"]) . "</td>";

                // Calculer le rappel
                $deadline = new DateTime($row["deadline"]);
                $current_date = new DateTime();
                if ($current_date > $deadline) {
                    $interval = $deadline->diff($current_date);
                    $days_passed = $interval->days;
                    echo "<td>La date limite est dépassée de $days_passed jour(s)</td>";
                } else {
                    $interval = $current_date->diff($deadline);
                    $days_remaining = $interval->days;
                    echo "<td>$days_remaining jour(s) restant(s)</td>";
                }

                // Vérifier si l'utilisateur est le créateur de la tâche avant d'afficher le lien "Supprimer"
                if ($_SESSION["username"] === $username) {
                    echo "<td><a href='supprime.php?id=" . urlencode($row["id"]) . "'>Supprimer</a>";
                    echo "<td><a href='modifier.php?id=" . urlencode($row["id"]) . "'>Modifier</a></td></td>";
                } else {
                    echo "<td>erreur</td>"; // Si l'utilisateur n'est pas le créateur, afficher une cellule vide
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Aucune tâche enregistrée pour cet utilisateur.</td></tr>";
        }
        ?>
    </table>
    <div class="search-link">
        <a href="site_web.php">
            <img src="retour.png" alt="Rechercher une tâche" width="20" height="20">
        </a>
    </div>
</body>
</html>
