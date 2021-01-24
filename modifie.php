<?php
include "affiche.php";
include "connex.php";
$strConnex = "host=$dbHost dbname=$dbName user=$dbUser password=$dbPassword";
$ptrDB = pg_connect($strConnex);

if (!$ptrDB) {
  print "<p>Erreur lors de la connexion ...</p>";
  exit;
}

$formulaireHotel = "
<div class='contenu contenu-form'>
<h3 style='padding-left : 10%'> Modification de l'hôtel numero ".$_GET['ligne']."</h3>
<form action='modifie.php?table=hotel' method='post'>
<input id='ligne' name='ligne' type='hidden' value='".$_GET['ligne']."'>

<table>
<tr><th><label>nom de l'hôtel</label></th>
<td><input type='text' name='nom_hotel' placeholder='chaîne de caractères' required></td></tr>

<tr><th><label>chaine</label></th>
<td><input type='text' name='chaine' placeholder='chaîne de caractères'></td></tr>

<tr><th><label>Adresse</label></th>
<td><input type='text' name='adresse' placeholder='chaîne de caractères' required></td></tr>

<tr><th><label>code_postal</label></th>
<td><select size='1' name='code_postal' required>
<option value='76310'> Sainte-Adresse 76310</option>
<option value='76600'>Le Havre 76600</option>
<option value='76610'>Le Havre 76610</option>
<option value='76620'>Le Havre 76620</option>

</select>
</td></tr>

<tr><th><label>catégorie</label></th>
<td><input type='text' name='categorie' placeholder='chaîne de caractères'></td></tr>

<tr><th><label>nombre de chambres</label></th>
<td><input type='text' name='nbre_chambres' placeholder='Entier'></td></tr>

<tr><th><label>Site web</label></th>
<td><input type='text' name='site_web' placeholder='chaîne de caractères'></td></tr>

<tr><th><label>Téléphone</label></th>
<td><input type='text' name='tel' placeholder='chaîne de caractères' required></td></tr>

<tr><td>
<input type='submit' name='envoi' value='Envoyer'></td><td>
<input type='reset' name='efface' value='Effacer'></td></tr>
</table>
</form>
</div>";

$formulaireClient = "
<div class='contenu contenu-form'>
<h3 style='padding-left : 10%'> Modification du client numero ".$_GET['ligne']."</h3>
<form action='modifie.php?table=client' method='post'>
<input id='ligne' name='ligne' type='hidden' value='".$_GET['ligne']."'>
<table>
<tr><th><label>nom du client</label></th>
<td><input type='text' name='nom_client' placeholder='chaîne de caractères' required></td></tr>

<tr><th><label>source</label></th>
<td><input type='text' name='source' placeholder='chaîne de caractères' required></td></tr>


<tr><td>
<input type='submit' name='envoi' value='Envoyer'></td><td>
<input type='reset' name='efface' value='Effacer'></td></tr>
</table>
</form>
</div>";

$formulaireNote = "
<div class='contenu contenu-form'>
<h3 style='padding-left : 10%'> Modification de la note du client numero ".$_GET['ligne']."</h3>
<form action='modifie.php?table=note' method='POST'>

<input id='ligne' name='ligne' type='hidden' value='".$_GET['ligne']."'>

<table>
<tr><th><label>Nouvelle note </label></th>
<td><input type='text' name='note' placeholder='Entier entre 0 et 5' required></td></tr>

<tr><th><label>Nouveau commentaire</label></th>
<td><input type='text' name='commentaire' placeholder='chaîne de caractères'></td></tr>

<tr><td>
<input type='submit' name='envoi' value='Envoyer'></td><td>
<input type='reset' name='efface' value='Effacer'></td></tr>
</table>
</form>
</div>";

if ($_GET['table']=="hotel"){
  echo $formulaireHotel;
}
else if ($_GET['table']=="client"){
  echo $formulaireClient;
}
else if($_GET['table']=="note"){
  echo $formulaireNote;
}

if(isset($_POST['envoi'])) {
  if ($_GET['table']=="hotel") {
    $i = $_POST['ligne']; $n = $_POST['nom_hotel'];	$c = $_POST['chaine'];
    $a = $_POST['adresse']; $cp = $_POST['code_postal'];	$cat = $_POST['categorie'];
    $nb = $_POST['nbre_chambres']; $s = $_POST['site_web'];	$t = $_POST['tel'];
    $reqModifie = "UPDATE hotel
    SET (nom_hotel, chaine, adresse, code_postal, categorie, nbre_chambres, site_web, tel) = ('$n', '$c', '$a', $cp, '$cat', $nb, '$s', '$t') WHERE id_hotel = $i";

  }
  else if ($_GET['table']=="client") {
    $i = $_POST['ligne']; $n = $_POST['nom_client'];	$s = $_POST['source'];
    $reqModifie = "UPDATE client
    SET (nom_client, source) = ('$n', '$s') WHERE id_client = $i";
  }
  else if($_GET['table']=="note") {
    $i = $_POST['ligne']; $n = $_POST['note'];	$c = $_POST['commentaire'];
    $reqModifie = "UPDATE note
    SET (note, commentaire) = ($n, '$c') WHERE id_client = $i";
  }
  // echo $reqModifie;

  $ptrQueryModifie = pg_query($ptrDB, $reqModifie);

  if ($ptrQueryModifie) {
    echo "
    <div class='contenu contenu-form' style ='padding-top:0;'>
    <p>Enregistrement modifié avec succès!</p>
    <p><a href='affiche.php?table=".$_GET['table']."&motCle=afficheTable' title='résultat'>
    Afficher la table</a></p></div>";
  }
  else
  print "<p>Echec de l'opération</p>";
}

myFooter();
echo "</div>"
?>
