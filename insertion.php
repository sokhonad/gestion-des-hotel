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
<h3 style='padding-left : 10%'>formulaire permettant d'insérer un Hotel</h3>
<form action='insertion.php?table=hotel' method='get'>
<input id='ligne' name='table' type='hidden' value='".$_GET['table']."'>
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
<h3 style='padding-left : 10%'>formulaire permettant d'insérer un Client</h3>
<form action='insertion.php?table=client' method='get'>
<input id='ligne' name='table' type='hidden' value='".$_GET['table']."'>

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
<h3 style='padding-left : 10%'>formulaire permettant d'insérer une Note</h3>
<form action='insertion.php?table=note' method='get'>
<input id='ligne' name='table' type='hidden' value='".$_GET['table']."'>

<table>
<tr><th><label> Identifiant Client</label></th>
<td><input type='text' name='id_client' placeholder='Entier' required></td></tr>

<tr><th><label> Identifiant Hôtel</label></th>
<td><input type='text' name='id_hotel' placeholder='Entier' required></td></tr>

<tr><th><label>Note </label></th>
<td><input type='text' name='note' placeholder='Entier entre 0 et 5' required></td></tr>

<tr><th><label> Commentaire</label></th>
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
if(isset($_GET['envoi'])) {
	if ($_GET['table']=="hotel") {
		$reqAjout = "INSERT INTO hotel (nom_hotel, chaine, adresse, code_postal, categorie, nbre_chambres, site_web, tel)
		VALUES ('".$_GET['nom_hotel']."','".$_GET['chaine']."','" .$_GET['adresse']."',".$_GET['code_postal'].
			",'".$_GET['categorie']."'," .$_GET['nbre_chambres'].",'".$_GET['site_web']."',".$_GET['tel'].")";
		}
		else if ($_GET['table']=="client") {
			$reqAjout = "INSERT INTO client (nom_client, source)
			VALUES ('".$_GET['nom_client']."','" .$_GET['source']."')";
		}
		else if($_GET['table']=="note") {
			$reqAjout = "INSERT INTO note (id_client, id_hotel, note, commentaire)
			VALUES (".$_GET['id_hotel'].",".$_GET['id_hotel'].",".$_GET['note'].",'" .$_GET['commentaire']."')";
		}

		//echo $reqAjout;
		$ptrQueryAjout = pg_query($ptrDB, $reqAjout);

		if ($ptrQueryAjout) {
			echo "
			<div class='contenu contenu-form' style ='padding-top:0;'>
			<p>Ajout effectué avec succès</p>
			<p><a href='affiche.php?table=".$_GET['table']."&motCle=afficheTable' title='résultat'>
			Afficher la table</a></p></div>";
		}
		else
		print "<p>Echec de l'opération</p>";
	}
	myFooter();
	echo "</div>";
	?>
