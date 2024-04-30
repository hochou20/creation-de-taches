<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>site_web</title>
<meta name="generator" content="Geany 1.38" />
<link rel="stylesheet" type="text/css" href="site_web.css">
<?php include 'menu.php'; ?>
<style>
.header {
        position: relative;
            }

.search-link {
      position: absolute; 
      top: 0px; 
      right: 35px; 
     background:  white;
     padding: 14px 10px
     
    }

.menu-dots {
        position: absolute; 
        top: 10px;
        right: 40px; 
  }
</style>
</head>
<body>
   
    <div class="header">
        <div class="search-link">
            <a href="lien_rechrche.php">
                <img src="loope.png" alt="Rechercher une tâche" width="20" height="20">
            </a>
        </div>
        <div class="menu-dots">
         
        </div>
    </div>


    <table>
        <tr>
            <th> <p><a href="taches.php" class="register-link">Créer une nouvelle Tache</a></p></th>
            <th> <p><a href="tache_affichages.php" class="register-link">Liste des taches enregistrées</a></p></th>
        </tr>
    </table>
    
</body>
</html>
