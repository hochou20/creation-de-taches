<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu déroulant</title>
  <style>
    /* Style du menu déroulant */
    .dropdown {
      position: relative;
      display: inline-block;
      float: right; /* Déplacer le menu vers la droite */
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
      right: 0;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: white;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .dropdown:hover .dropbtn {
      background-color: white;
    }

    /* Style du bouton avec les trois points */
    .dropbtn {
      background-color: white;
      color: black;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }
  </style>
</head>
<body>

<!-- Menu déroulant -->
<div class="dropdown">
  <button class="dropbtn">&#8942;</button>
  <div class="dropdown-content">
    <a href="site_web.php">Revenir à la page d'accueil</a>
    <a href="logout.php">deconnexion</a>
  </div>
</div>

</body>
</html>
