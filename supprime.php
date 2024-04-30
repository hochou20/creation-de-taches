<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Vérifier si l'identifiant de la tâche est passé en paramètre dans l'URL
if(isset($_GET["id"])) {
    $task_id = $_GET["id"];

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

    // Supprimer la tâche de la base de données en utilisant l'identifiant unique
    $sql = "DELETE FROM $table WHERE id = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $task_id, $_SESSION["username"]);
    if ($stmt->execute()) {
    echo '<p>Tâche supprimée avec succès. <a href="tache_affichages.php" class="register-link">Veuillez afficher les tâches restantes</a>.</p>';
} else {
        echo "Erreur lors de la suppression de la tâche : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Identifiant de la tâche non spécifié.";
}
?>
