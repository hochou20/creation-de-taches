<?php
session_start();


// declaration de variable nécessaires 
// pour établir une connexion a la base de données
$servername = "localhost";
$username = "hocine";
$password = "Houhou.100"; 
$dbname = "formulaire";
$table = "inscription";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification si la tentation a echouer
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérification si les champs du formulaire sont remplis
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Préparation de la requête SQL pour récupérer l'utilisateur depuis la base de données
    $sql = "SELECT * FROM $table WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // si l'utilisateur existe dans notre base, on procede a une vérification du mot de passe
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // si le Mot de passe est correct, on defini une variable de session pour l'utilisateur
            $_SESSION['username'] = $username;
            // on redige lutilisateur vers la page des tâches
            header("Location: site_web.php");
            exit();
        } else {
            // Mot de passe incorrect, afficher un message d'erreur
            $errorMessage = "Nom d'utilisateur incorrect, ou mot de passe incorrect.";
        }
    } else {
        // Utilisateur non trouvé, afficher un message d'erreur
        $errorMessage = "Nom d'utilisateur incorrect, ou mot de passe incorrect.";
    }
}
$conn->close();
?>


                  <?php
                    if (!empty($errorMessage)) {
                        echo '<div class="error-message">' . $errorMessage . '</div>';
                    }
                  ?>
