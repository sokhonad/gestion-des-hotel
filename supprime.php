  <?php
  include "affiche.php";
 echo "<div class='contenu contenu-form'>";
  include "connex.php";
  $strConnex = "host=$dbHost dbname=$dbName user=$dbUser password=$dbPassword";
  $ptrDB = pg_connect($strConnex);

  if (!$ptrDB) {
    print "<p>Erreur lors de la connexion ...</p>";
    exit;
  }

  if ($_GET['table']=="hotel")
      $reqSupprime = "DELETE FROM hotel WHERE id_hotel =". $_GET['ligne'];
  else if ($_GET['table']=="client")
      $reqSupprime = "DELETE FROM client WHERE id_client =". $_GET['ligne'];
  else if($_GET['table']=="note")
      $reqSupprime = "DELETE FROM note WHERE id_client =". $_GET['ligne'];
  // echo "$reqSupprime";

   $ptrQuerySupprime = pg_query($ptrDB, $reqSupprime);
   if ($ptrQuerySupprime) {
       echo "<p>Suppression réussie</p>
       <a href='affiche.php?table=".$_GET['table']."&motCle=afficheTable'>Actualiser la page pour constater le résultat</a>";
       myFooter();
   }
    else {
      print "<p>Echec de l'opération</p>";
      $erreur = pg_last_error($ptrDB);
      if (strpos($erreur, "violates foreign key constraint") !== false) {
        echo "<h4>Violation des contraintes de clé étrangères</h4>
        <p><i>l'identifiant de la ligne que vous essayé de supprimer est utilisé
        comme clé étrangère dans une autre table. Vous devez donc supprimer d'abord
        toutes les lignes des autres tables associées à cet identifiant.<i></p>
        <h5>Erreur sql retournée : </h5>
        <p><i>$erreur</i></p>";
      }

    }

   echo "</div></div>"

  ?>
