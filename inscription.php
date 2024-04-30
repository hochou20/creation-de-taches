<?php
session_start();
$errorMessage = '';

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification si les champs ont été remplis
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        // Récupération des données du formulaire
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Déclaration des variables nécessaires pour établir une connexion à la base de données
        $servername = "localhost";
        $db_username = "hocine";
        $db_password = "Houhou.100";
        $dbname = "formulaire"; 
        $table = "inscription"; 

        // Création de la connexion
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        // Vérification si la connexion a échoué
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Vérification si le nom d'utilisateur est déjà utilisé
        if (check_username_exists($username, $conn, $table)) {
            $errorMessage = "Le nom d'utilisateur est déjà utilisé.";
        } else {
            // Vérification si le mot de passe répond aux critères spécifiés
            if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d.@])[A-Za-z\d.@]{8,}$/", $password)) {
                // Hash du mot de passe (vous devriez utiliser des fonctions de hachage sécurisées dans un contexte réel)
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Préparation de la requête SQL pour insérer les données dans la table des utilisateurs
                $sql = "INSERT INTO $table (username, password) VALUES ('$username', '$hashed_password')";

                // Exécution de la requête SQL
                if ($conn->query($sql) === TRUE) {
                   $successMessage = "Vous êtes inscrit avec succès. <a href='login.php'>Veuillez revenir vers l'accueil pour vous connecter</a>";
                } else {
                    echo "Erreur lors de l'inscription: " . $conn->error;
                }
            } else {
                $errorMessage = "Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre ou l'un des caractères spéciaux suivants: . @ et avoir une longueur d'au moins 8 caractères.";
            }
        }
        
        // Fermeture de la connexion
        $conn->close();
    } else {
        // Si les champs ne sont pas remplis, afficher un message d'erreur
        $errorMessage = "Veuillez remplir tous les champs du formulaire.";
    }
}

// Fonction pour vérifier si le nom d'utilisateur est déjà utilisé
function check_username_exists($username, $conn, $table) {
    // Préparation de la requête SQL
    $sql = "SELECT * FROM $table WHERE username = '$username'";
    
    // Exécution de la requête SQL
    $result = $conn->query($sql);
    
    // Vérification si le résultat contient des lignes (c'est-à-dire si le nom d'utilisateur existe déjà)
    if ($result->num_rows > 0) {
        return true; // Le nom d'utilisateur existe déjà
    } else {
        return false; // Le nom d'utilisateur n'existe pas encore
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="inscription.css">

</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form action="inscription.php" method="post">
            <div class="input-box">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-box">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <a href="login.php">Already have an account? Log in</a>
        <?php
         if (!empty($successMessage)) {
        echo '<div class="success-message">' . $successMessage . '</div>';
    }
        if (!empty($errorMessage)) {
          echo '<div class="error-message">' . $errorMessage . '</div>';
        }
        ?>
    </div>
</body>
</html>

