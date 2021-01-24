<?php
menu();

if($_GET['motCle'] == "afficheTable") {
  afficheTable($_GET['table']);
  myFooter();
}
else if ($_GET['motCle'] == "afficheSources") {
  source();
  myFooter();
}

function menu(){
  echo "
  <!DOCTYPE html>
  <html><head>
  <meta http-equiv='content-type' content='text/html; charset=UTF-8'><title>Hôtels du havre</title>


  <link rel='stylesheet'href='style.css'>
  </head>
  <body class='hotel-body'>
  <header>
  <nav class='navbar navbar-shade'>
  <div class='navbar-container'>
  <a href='index.php' class='home-link'>Hôtels du Havre</a>
  <div class='navbar-elements'>
  <ul class='navbar-ul'>
  <li><a href='index.php' title='Accueil'><img src='R/home.jpeg' alt='accueil' /></a></li>
  <li><a href='affiche.php?table=hotel&motCle=afficheTable' title='Table hotel'>Hôtels</a></li>
  <li><a href='affiche.php?table=client&motCle=afficheTable' title='Table note'>Clients</a></li>
  <li><a href='affiche.php?table=note&motCle=afficheTable' title='Table client'>Avis</a></li>
  <li><a href='insertion.php?table=hotel' title='Insérer un hôtel'>Add hotel</a></li>
  <li><a href='insertion.php?table=client' title='Insérer un client'>Add client</a></li>
  <li><a href='insertion.php?table=note' title='Insérer un avis'>Add avis</a></li>
  <li><a href='affiche.php?motCle=afficheSources'>Sources</a></li>
  </ul>
  </div>
  </div>
  </nav>
  </header>
  <div style='clear:both'></div>";
}

function afficheTable($nom){
  include "connex.php";
  $strConnex = "host=$dbHost dbname=$dbName user=$dbUser password=$dbPassword";
  $ptrDB = pg_connect($strConnex);

  $clePrimaire = ($nom == 'hotel') ? 'id_hotel' : 'id_client';
  $affiche  = "select * from ".$nom." order by ".$clePrimaire ;
  //echo $afficheHotel;
  $executeRequete = pg_query($ptrDB, $affiche);

  if($executeRequete ){
    $resu = pg_fetch_all($executeRequete);
    if($nom == 'hotel'){
        $tabResu = "<div style='clear:both'></div>
        <div class='contenu'><table border='2' class='TableHotel'>
        <thead><tr><th>Hôtel</th><th>Image</th><th>Modifier</th>
        <th>Supprimer</th></tr></thead><tbody>";

      foreach ($resu as $ligne) {
        $tabResu .= "<tr><td><ul>" ;
        $i=0;
        while ($i < pg_num_fields($executeRequete)) {
          $nomChamp = pg_field_name($executeRequete, $i);
          $i = $i + 1;
          $tabResu .= "<li>".$nomChamp." : ".$ligne["$nomChamp"]."</li>";
        }

        $tabResu .= "</ul></td>";
        // Récuperation de l'id de la ligne
        $clePrimaire = ($nom == 'hotel') ? 'id_hotel' : 'id_client';
        $id_ligne = $ligne["$clePrimaire"];
        $nomPhoto = "h". $id_ligne;
        $tabResu .= "<td><img src='R/".$nomPhoto.".jpg' alt='Photo hôtel' width='200' height='260'></td>";

        $tabResu .= "<td class='align-center record-modify'><a href ='modifie.php?ligne=".$id_ligne."&table=".$_GET['table']."'>
        Modifier</a></td>";
        $tabResu .= "<td class='align-center record-delete'><a href ='supprime.php?ligne=".$id_ligne."&table=".$_GET['table']."'>
        Supprimer</a></td></tr>\n";

      }
      $tabResu .= "</tr</tbody></table></div>";
      echo $tabResu;
    } else { // les autres tables sont affichées dans un tableau normal
      if($nom == 'client'){
      $tabResu = "<div style='clear:both'></div>
      <div class='contenu'><table border='2' class='TableClient'><tbody>
      <tr><th>ID</th><th>Nom</th><th>Source</th><th>Modifier</th>
      <th>Supprimer</th></tr></thead><tbody>";
    } else {
      $tabResu = "<div style='clear:both'></div>
      <div class='contenu'><table border='2' class='TableNote'><tbody>
      <tr><th>ID Client</th><th>ID hôtel</th><th>Note</th>
      <th>Commentaire</th><th>Modifier</th>
      <th>Supprimer</th></tr></thead><tbody>";
    }
      foreach ($resu as $ligne) {
        $tabResu .= "<tr>" ;
        $i=0;
        while ($i < pg_num_fields($executeRequete)) {
          $nomChamp = pg_field_name($executeRequete, $i);
          $i = $i + 1;
          $tabResu .= "<td>".$nomChamp." : ".$ligne["$nomChamp"]."</td>";
        }

        // Récuperation de l'id de la ligne
        $clePrimaire = ($nom == 'hotel') ? 'id_hotel' : 'id_client';
        $id_ligne = $ligne["$clePrimaire"];
        $tabResu .= "<td class='align-center record-modify'><a class='btnM' href ='modifie.php?ligne=".$id_ligne."&table=".$_GET['table']."'>
        Modifier</a></td>";
        $tabResu .= "<td class='align-center record-delete'><a class='btnS' href ='supprime.php?ligne=".$id_ligne."&table=".$_GET['table']."'>
        Supprimer</a></td></tr>\n";
      }
      $tabResu .= "</table>";
      echo $tabResu;
    }
  }
}

function source() {
  echo "
  <div class='contenu contenu-form text-center'>
  <ul style='list-style-type : none;'>
  <li><a href='https://www.lehavretourisme.com' target='_blank'>Le havre tourisme</a></li>
  <li><a href='https://www.tripadvisor.com' target='_blank'>Trip advisor</a></li>
  <li><a href='https://www.booking.com' target='_blank'>Booking</a></li>
  <li><a href='https://www.expedia.com' target='_blank'>Expedia</a></li>
  </ul>
  </div>";
}

function myFooter() {
  echo "</div><div id='wrap'>
  <div id='footer-wrap'><div id='footer'>
  <p>&copy; 2019 Université Le Havre
  &nbsp;&nbsp;&nbsp;&nbsp;
  Design by<i> Ibrahima, Tayssir, Diakharou, &amp; Mamadou</i>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <a href='index.php' title='Accueil'>Home</a> |
  <a href='affiche.php?table=hotel&motCle=afficheTable' title='Table hotel'>Hôtels</a> |
  <a href='affiche.php?table=client&motCle=afficheTable' title='Table note'>Clients</a> |
  <a href='affiche.php?table=note&motCle=afficheTable' title='Table client'>Avis</a> |
  </p>
  </div></div>
  </div>";
}
