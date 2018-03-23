<?php
session_start();
$bd = "host=localhost dbname=bd_poireau user=admin  password=admin";
$connect = pg_connect($bd);
if ($connect) {
     echo "connect";
} else {
     echo "error";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous">
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
   <link rel="stylesheet" href="style.css">
   <title>Document</title>
</head>

<body>
   <!-- Menu -->
   <section class="navbar-top container-fluid">
      <div class="row">
         <div class="col-md-12 menu-logo">
            <img class="logo" src="img/logo.png" alt="Logo de FaisPasLPoireau">
         </div>
      </div>
   </section>
   <!-- Fin menu  -->


   <!-- ///////// Listes à gauche /////////////////-->
   
   <section class="div-left">
      <div class="table-items col-md-3 stock">
      
      <h5><i class="fa fa-print fa-1x"></i>&nbsp;Stock</h5>         
      
         <!-- Boutons pour sélectionner quel tableau afficher -->
         <ul class="nav nav-tabs">
            <li class="nav-item">
               <a class="nav-link active" data-toggle="tab" href="#home">Tous</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#menu1">Fruits</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#menu2">Légumes</a>
            </li>
         </ul>
         <!-- Tableaux -->
         <div class="tab-content">
         	<div class="alert alert-danger">
    <strong>Warning!</strong> Attention il vous en reste moins de 5 !
  </div>
            <!-- Tableau Tous -->
            <div class="tab-pane active table-responsive" id="home">
               <table class="table">
   				<thead>
                     <tr>
                        <th id="name-column">Nom</th>
                        <th>Qté</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<?php
    $requete=pg_query('SELECT pro_nom, sum(st) 
FROM (SELECT pro_leg,pro_nom, -sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = True
UNION
SELECT pro_leg, pro_nom, sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = False
UNION 
SELECT pro_leg, pro_nom, -con_qte as st
FROM contenu
INNER JOIN produit ON cpro_id = pro_id) as s
GROUP BY pro_leg,pro_nom
ORDER BY  pro_leg,pro_nom');
    while($result=pg_fetch_array($requete)){ 
    	echo$result ["pro_nom"];
    	echo "\n";
        echo$result ["sum"];
        echo "</br>";
        };			
    ?> 
            
                  </tbody>
               </table>
            </div>
            <!-- Tableau Fruits -->
            <div class="tab-pane table-responsive" id="menu1">
            	<table class="table">
   				<thead>
                 
                  </thead>
                  <tbody>
                              	<?php
    $requetefruits=pg_query('SELECT pro_nom, sum(st) 
FROM (SELECT pro_leg,pro_nom, -sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = True 
UNION
SELECT pro_leg, pro_nom, sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = False
UNION 
SELECT pro_leg, pro_nom, -con_qte as st
FROM contenu
INNER JOIN produit ON cpro_id = pro_id) as s
GROUP BY pro_leg,pro_nom
ORDER BY  pro_leg,pro_nom
LIMIT 44');
 while($resultat=pg_fetch_array($requetefruits) ){ 
    	echo$resultat ["pro_nom"];
    	echo "\n";
        echo$resultat ["sum"];
        echo "</br>";
        };			
    ?> 
</tbody>
</table>
    </div>
            <!-- Tableau Légumes -->
            <div class="tab-pane table-responsive" id="menu2">
<?php  
$requetelegumes=pg_query('SELECT pro_nom, sum(st) 
FROM (SELECT pro_leg,pro_nom, -sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = True 
UNION
SELECT pro_leg, pro_nom, sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = False
UNION 
SELECT pro_leg, pro_nom, -con_qte as st
FROM contenu
INNER JOIN produit ON cpro_id = pro_id) as s
GROUP BY pro_leg,pro_nom
ORDER BY  pro_leg,pro_nom
LIMIT 96  OFFSET 44');

while($resultat2=pg_fetch_array($requetelegumes) ){ 
    	echo$resultat2 ["pro_nom"];
    	echo "\n";
        echo$resultat2 ["sum"];
        echo "</br>";
        };			
?>
            </div>
         </div>
      </div>
      <!-- ///////// FIN Listes à gauche /////////////////-->


      <!-- ///////// DIVs colonne nouvelle vente et colonne ajouter/supprimer/géomarketing  /////////////////-->
      <div class="col-md-9">
         <div class="row">

            <!-- Nouvelle vente -->
            <div class="col-md-7">
               <div class="container new-sale">
                  <h5>Nouvelle vente</h5>
                  <!-- formulaire -->
                  <form action="">

                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="time">Heure</label>
                              <input type="number" class="form-control" id="" placeholder="00:00" disabled>
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <label for="villes">Ville</label>
                              <!-- Menu déroulant -->
                              <select class="form-control" name="" id="">
                              	<?php $requeteville=pg_query('SELECT com_nom FROM commune');
								while($resultat4=pg_fetch_array($requeteville)){ ?>

                                 <option value="">
                                 	<?php  
 
    	echo$resultat4 ["com_nom"];
    	echo "\n";
    	echo "</br>";
        };			
?>
	
</option>
                                 
                              </select>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="quantityToAdd">Quantité</label>
                              <input type="number" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <label for="itemToAdd">Fruit/Légume</label>
                              <!-- Menu déroulant -->
                              <select class="form-control" name="" id="">
                              	<?php $requeteall=pg_query('SELECT pro_nom, sum(st) 
FROM (SELECT pro_leg,pro_nom, -sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = True 
UNION
SELECT pro_leg, pro_nom, sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = False
UNION 
SELECT pro_leg, pro_nom, -con_qte as st
FROM contenu
INNER JOIN produit ON cpro_id = pro_id) as s
GROUP BY pro_leg,pro_nom
ORDER BY  pro_leg,pro_nom');

while($resultat3=pg_fetch_array($requeteall)){ ?>

                                 <option value="">
                                 	<?php  
 
    	echo$resultat3 ["pro_nom"];
    	echo "\n";
    	echo "</br>";
        };			
?>
	
</option>
                                 
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="" id="">
                              	<?php $requeteall=pg_query('SELECT pro_nom, sum(st) 
FROM (SELECT pro_leg,pro_nom, -sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = True 
UNION
SELECT pro_leg, pro_nom, sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = False
UNION 
SELECT pro_leg, pro_nom, -con_qte as st
FROM contenu
INNER JOIN produit ON cpro_id = pro_id) as s
GROUP BY pro_leg,pro_nom
ORDER BY  pro_leg,pro_nom');

while($resultat3=pg_fetch_array($requeteall)){ ?>

                                 <option value="">
                                 	<?php  
 
    	echo$resultat3 ["pro_nom"];
    	echo "\n";
    	echo "</br>";
        };			
?>
	
</option>
                                 
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="" id="">
                              	<?php $requeteall=pg_query('SELECT pro_nom, sum(st) 
FROM (SELECT pro_leg,pro_nom, -sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = True 
UNION
SELECT pro_leg, pro_nom, sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = False
UNION 
SELECT pro_leg, pro_nom, -con_qte as st
FROM contenu
INNER JOIN produit ON cpro_id = pro_id) as s
GROUP BY pro_leg,pro_nom
ORDER BY  pro_leg,pro_nom');

while($resultat3=pg_fetch_array($requeteall)){ ?>

                                 <option value="">
                                 	<?php  
 
    	echo$resultat3 ["pro_nom"];
    	echo "\n";
    	echo "</br>";
        };			
?>
	
</option>
                                 
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="" id="">
                              	<?php $requeteall=pg_query('SELECT pro_nom, sum(st) 
FROM (SELECT pro_leg,pro_nom, -sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = True 
UNION
SELECT pro_leg, pro_nom, sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = False
UNION 
SELECT pro_leg, pro_nom, -con_qte as st
FROM contenu
INNER JOIN produit ON cpro_id = pro_id) as s
GROUP BY pro_leg,pro_nom
ORDER BY  pro_leg,pro_nom');

while($resultat3=pg_fetch_array($requeteall)){ ?>

                                 <option value="">
                                 	<?php  
 
    	echo$resultat3 ["pro_nom"];
    	echo "\n";
    	echo "</br>";
        };			
?>
	
</option>
                                 
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="" id="">
                              	<?php $requeteall=pg_query('SELECT pro_nom, sum(st) 
FROM (SELECT pro_leg,pro_nom, -sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = True 
UNION
SELECT pro_leg, pro_nom, sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = False
UNION 
SELECT pro_leg, pro_nom, -con_qte as st
FROM contenu
INNER JOIN produit ON cpro_id = pro_id) as s
GROUP BY pro_leg,pro_nom
ORDER BY  pro_leg,pro_nom');

while($resultat3=pg_fetch_array($requeteall)){ ?>

                                 <option value="">
                                 	<?php  
 
    	echo$resultat3 ["pro_nom"];
    	echo "\n";
    	echo "</br>";
        };			
?>
	
</option>
                                 
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="" id="">
                              	<?php $requeteall=pg_query('SELECT pro_nom, sum(st) 
FROM (SELECT pro_leg,pro_nom, -sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = True 
UNION
SELECT pro_leg, pro_nom, sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = False
UNION 
SELECT pro_leg, pro_nom, -con_qte as st
FROM contenu
INNER JOIN produit ON cpro_id = pro_id) as s
GROUP BY pro_leg,pro_nom
ORDER BY  pro_leg,pro_nom');

while($resultat3=pg_fetch_array($requeteall)){ ?>

                                 <option value="">
                                 	<?php  
 
    	echo$resultat3 ["pro_nom"];
    	echo "\n";
    	echo "</br>";
        };			
?>
	
</option>
                                 
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="" id="">
                              	<?php $requeteall=pg_query('SELECT pro_nom, sum(st) 
FROM (SELECT pro_leg,pro_nom, -sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = True 
UNION
SELECT pro_leg, pro_nom, sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = False
UNION 
SELECT pro_leg, pro_nom, -con_qte as st
FROM contenu
INNER JOIN produit ON cpro_id = pro_id) as s
GROUP BY pro_leg,pro_nom
ORDER BY  pro_leg,pro_nom');

while($resultat3=pg_fetch_array($requeteall)){ ?>

                                 <option value="">
                                 	<?php  
 
    	echo$resultat3 ["pro_nom"];
    	echo "\n";
    	echo "</br>";
        };			
?>
	
</option>
                                 
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="" id="">
                              	<?php $requeteall=pg_query('SELECT pro_nom, sum(st) 
FROM (SELECT pro_leg,pro_nom, -sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = True 
UNION
SELECT pro_leg, pro_nom, sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = False
UNION 
SELECT pro_leg, pro_nom, -con_qte as st
FROM contenu
INNER JOIN produit ON cpro_id = pro_id) as s
GROUP BY pro_leg,pro_nom
ORDER BY  pro_leg,pro_nom');

while($resultat3=pg_fetch_array($requeteall)){ ?>

                                 <option value="">
                                 	<?php  
 
    	echo$resultat3 ["pro_nom"];
    	echo "\n";
    	echo "</br>";
        };			
?>
	
</option>
                                 
                              </select>
                           </div>
                        </div>
                     </div>
                     <br>
                     <div class="action-buttons">
                        <button class="btn btn-danger" type="submit">Annuler</button>
                        <button class="btn btn-success" type="submit">Valider</button>
                     </div>

                  </form>
               </div>
            </div>

            <!-- Ajouter/Supprimer/Géomarketing -->
            <div class="col-md-5 right-panel">

               <!-- Ajouter - Nouvelle entrée dans le stock -->
               <h5>Nouvelle entrée dans le stock</h5>
               <!-- formulaire -->
               <form action="">
                  <div class="container">
                     <div class="row">

                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="quantityToAdd">Quantité</label>
                              <input type="number" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="form-group">
                              <label for="itemToAdd">Fruit/Légume</label>
                              <!-- Menu déroulant -->
                                   <select class="form-control" name="" id="">
                              	<?php $requeteall=pg_query('SELECT pro_nom, sum(st) 
FROM (SELECT pro_leg,pro_nom, -sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = True 
UNION
SELECT pro_leg, pro_nom, sto_qte as st
FROM stock
INNER JOIN produit ON pro_id=spro_id
WHERE sto_pert = False
UNION 
SELECT pro_leg, pro_nom, -con_qte as st
FROM contenu
INNER JOIN produit ON cpro_id = pro_id) as s
GROUP BY pro_leg,pro_nom
ORDER BY  pro_leg,pro_nom');

while($resultat3=pg_fetch_array($requeteall)){ ?>

                                 <option value="">
                                 	<?php  
 
    	echo$resultat3 ["pro_nom"];
    	echo "\n";
    	echo "</br>";
        };			
?>
	
</option>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="action-buttons">
                     <button type="submit" class="btn btn-success">Ajouter</button>
                  </div>
               </form>

               <!-- Supprimer - Quantité perdue/jetée -->
               <h5>Quantité perdue/jetée</h5>
               <!-- formulaire -->
               <form action="">
                  <div class="container">
                     <div class="row">

                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="quantityToRemove">Quantité</label>
                              <input type="number" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="form-group">
                              <label for="itemToRemove">Fruit/Légume</label>
                              <!-- Menu déroulant -->
                              
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="action-buttons">
                     <button type="submit" class="btn btn-danger">Supprimer</button>
                  </div>
               </form>

               <!-- Geomarketing -->
               <div class="row">
                  <div class="col-md-9 geo-title">
                     <h5>
                        <i class="fa fa-print fa-1x icon-menu">&nbsp;</i>Géomarketing</h5>

                  </div>
                  <div class="col-md-3 geo">


                  </div>
               </div>
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <th scope="row">1</th>
                        <td>Pamiers City</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!-- ///////// FIN DIVs colonne nouvelle vente et colonne ajouter/supprimer/géomarketing  /////////////////-->

   </section>

<!-- Good luck -->

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"></script>
</body>

</html>