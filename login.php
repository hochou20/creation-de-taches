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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>site_moumouh</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
   <header class="header">
      <nav class="navbar">
         <a href="login.php">Home</a>
      </nav>
   </header>
   <!-- LOGIN FORM CREATION -->
   <div class="background"></div>
   <div class="container">
      <div class="it">
         <h2 class="logo"><i class='txt'></i>MED_HAMIDe</h2>
         <h2 class="logo"><i class='txt'></i>ho_houchi</h2>
         <div class="text-it">
            <h2>Welcome! <br><span>To My Website</span></h2>
            <p>Notre site web est conçu pour simplifier votre vie <br>
               en vous aidant à organiser et gérer efficacement vos<br>
               tâches quotidiennes. Que ce soit pour le travail, <br>
               les études ou la vie personnelle, notre plateforme <br>
               intuitive vous permet de planifier, suivre et accomplir<br>
               vos tâches avec facilité
            </p>
         </div>
      </div>
      <div class="login-section">
         <div class="form-box login">
            <form action="login.php" method="post" class="<?php if (!empty($errorMessage)) echo 'error-input'; ?>">
               <h2>Sign In</h2>
               <div class="input-box">
                  <input type="text" name="username" placeholder="Username" required>
               </div>
               <div class="input-box password-container">
                  <input type="password" name="password" class="password" placeholder="Password" required>
                  <span class="toggle-password" onclick="togglePasswordVisibility()">&#128065;</span>
               </div>
               <button type="submit" class="btn">Login In</button>
               <div class="create-account">
                  <p>Create A New Account? <a href="inscription.php" class="register-link">Sign Up</a></p>
                  <?php
                    if (!empty($errorMessage)) {
                        echo '<div class="error-message">' . $errorMessage . '</div>';
                    }
                  ?>
               </div>
            </form>
         </div>
      </div>
   </div>
</body>
</html>

