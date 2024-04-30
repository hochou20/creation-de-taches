<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Vérifier si le formulaire de modification a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si tous les champs sont remplis
    if (isset($_POST['title'], $_POST['description'], $_POST['deadline'], $_POST['statut'])) {
        // Récupérer les données du formulaire
        $title = $_POST['title']; // Nouveau titre de la tâche
        $description = $_POST['description'];
        $deadline = $_POST['deadline'];
        $status = $_POST['statut'];
        $task_id = $_POST['task_id']; // Identifiant unique de la tâche

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

        // Vérifier si le statut soumis est valide
        $valid_statuses = array("à faire", "en cours", "terminé"); // Liste des statuts valides
        if (!in_array(strtolower($status), $valid_statuses)) {
            $error = "Le statut soumis n'est pas valide.";
        } else {
            // Mettre à jour la tâche dans la base de données
            $sql = "UPDATE $table SET title = ?, description = ?, deadline = ?, statut = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $title, $description, $deadline, $status, $task_id);
            if ($stmt->execute()) {
                $successMessage = "Tâche modifiée avec succès.";
            } else {
                echo "Erreur lors de la modification de la tâche : " . $stmt->error;
            }

            $stmt->close();
        }

        $conn->close();
    } else {
        echo "Tous les champs du formulaire ne sont pas remplis.";
    }
}

// Vérifier si l'identifiant de la tâche est passé en paramètre dans l'URL
if (isset($_GET["id"])) {
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

    // Récupérer les détails de la tâche à modifier
    $sql = "SELECT * FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si la tâche existe
    if ($result->num_rows == 1) {
        // Récupérer les détails de la tâche
        $task = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la tâche</title>
    <link rel="stylesheet" type="text/css" href="edit.css">
</head>
<body>
    <div class="container">
        <h2>Modifier la tâche</h2>
        <form action="" method="post">
            <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['id']); ?>">
            <label for="title">Titre de la tâche:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($task['description']); ?></textarea>

            <label for="deadline">Date Limite:</label>
            <input type="date" id="deadline" name="deadline" value="<?php echo htmlspecialchars($task['deadline']); ?>" required>

            <label for="statut">Statut:</label>
            <select id="statut" name="statut" required>
                <option value="à faire" <?php if ($task['statut'] == 'à faire') echo 'selected'; ?>>À faire</option>
                <option value="en cours" <?php if ($task['statut'] == 'en cours') echo 'selected'; ?>>En cours</option>
                <option value="terminé" <?php if ($task['statut'] == 'terminé') echo 'selected'; ?>>Terminé</option>
            </select>

            <button type="submit">Modifier la tâche</button>
        </form>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>

    <a href="tache_affichages.php">
        <img src="retour.png" alt="tache_affichages.php" width="20" height="20">
    </a>
</body>
</html>
<?php
        if (isset($successMessage)) {
            echo '<div class="success-message">' . $successMessage . '</div>';
        }
    } else {
        echo "Tâche non trouvée.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Identifiant de la tâche non spécifié.";
}
?>
