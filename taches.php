<?php
session_start();

// Définir des variables pour les messages de succès et d'erreur
$successMessage = "";
$errorMessage = "";

// Vérifier si le formulaire de création de tâche a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si tous les champs sont remplis
    if (isset($_POST['title'], $_POST['description'], $_POST['deadline'], $_POST['statut'])) {
        // Récupérer les données du formulaire
        $title = $_POST['title'];
        $description = $_POST['description'];
        $deadline = $_POST['deadline'];
        $statut = $_POST['statut'];

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

        // Récupérer le nom d'utilisateur du créateur de la tâche
        if(isset($_SESSION["username"])) {
            $creatorUsername = $_SESSION["username"];

            // Insérer les données dans la table 'gestion_tachess'
            $sql = "INSERT INTO $table (username, title, description, deadline, statut, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $creatorUsername, $title, $description, $deadline, $statut);
            if ($stmt->execute()) {
                $successMessage = "Tâche créée avec succès.";
            } else {
                $errorMessage = "Erreur lors de la création de la tâche : " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errorMessage = "Nom d'utilisateur non trouvé dans la session.";
        }

        $conn->close();
    } else {
        $errorMessage = "Tous les champs du formulaire ne sont pas remplis.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>sans titre</title>
    <meta name="generator" content="Geany 1.38" />
 <link rel="stylesheet" type="text/css" href="tache.css">
 <?php include 'menu.php'; ?>
</head>

<body>

    <!-- Formulaire de création de tâche -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <!-- Conteneur du formulaire -->
    <div class="container">
  
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" required>
            
            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="4" cols="50" required></textarea>
            
            <label for="deadline">Date Limite :</label>
            <input type="date" id="deadline" name="deadline" required>
            
            <label for="status">Statut :</label>
            <select id="status" name="statut" required>
                <option value="A faire">A faire</option>
                <option value="En cours">En cours</option>
                <option value="Terminé">Terminé</option>
            </select>
            
            <input type="submit" value="Créer la Tâche">
        </form>
    </div>

    <!-- Affichage des messages de succès ou d'erreur -->
    <?php
    if (!empty($successMessage)) {
        echo '<div class="success-message">' . $successMessage . '</div>';
    }

    if (!empty($errorMessage)) {
        echo '<div class="error-message">' . $errorMessage . '</div>';
    }
    ?>
     <div class="search-link">
            <a href="site_web.php">
                <img src="retour.png" alt="Rechercher une tâche" width="20" height="20">
            </a>
</body>

</html>
