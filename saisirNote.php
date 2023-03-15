<?

if (isset($_POST["username"])) {
	$username = $_POST["username"];
} else if (isset($_GET["username"])) {
	$username = $_GET["username"];
} else {
	$username = "Inconnu";
}

//Ouverture du fichier
$fichier = file("matiere.txt");
$page = "";
//Parcours du fichier
for ($i = 0; $i < count($fichier); $i++) {

	$key = explode(";", $fichier[$i])[0];
	$value = explode(";", $fichier[$i])[1];

	$page .= "<input id=\"mat$key\" type=\"radio\" name=\"matiere\" value=\"" . $value . "\"> ";
	$page .=  "<label for=\"mat$key\">$value</label><br/>";
}


?>
<!DOCTYPE html>
<html>

<head>
	<title>Bienvenue dans Pardanotes</title>

	<head>
		<meta charset="utf-8">
		<!-- importer le fichier de style -->
		<link rel="stylesheet" href="style.css" media="screen" type="text/css" />
		<link rel="stylesheet" href="tp9.css" media="screen" type="text/css" />
	</head>
</head>

<body>
	<div id="header">
		<img src="logo.png" alt="logo"><br />
		<span>La gestion des notes du lycée Pardailhan</span>
	</div>
	<div id="menu">
		<div><a href="afficherNote.php?username=<?= $username ?>">Afficher les notes</a></div>
		<div><a href="saisirNote.php?username=<?= $username ?>">Saisir les notes</a></div>
		<div><a href="afficherEtudiant.php?username=<?= $username ?>">Afficher les étudiants</a></div>
		<div><a href="saisirEtudiant.php?username=<?= $username ?>">Saisir les étudiants</a></div>
		<div><a href="login.html">Se déconnecter</a></a></div>
	</div>
	<form action="enregistrerNote.php?username=<?= $username ?>" method="post"> Nom Etudiant <select name="nomEtudiant"
			size="1">
			<option value="20230001">Emma Snowshill</option>
			<option value="20230002">Tom Richard</option>
			<option selected value="20230003">Jawad Abdelmoula</option>
			<option value="20230004">Jan Frodeno</option>
		</select><br>
		<fieldset>
			<legend>Matière</legend> <?= $page ?>
		</fieldset>
		<br><br /> Note : <input type="number" name="note" step="0.5" min="0" max="20" />
		<br><br />
		<fieldset>
			<legend>Bonus</legend>
			<input type="checkbox" name="bonus[]" value="orthographe" checked /> +1 pour l'orthographe <br />
			<input type="checkbox" name="bonus[]" value="vocabulaire" checked /> +1 pour le vocabulaire <br />
			<input type="checkbox" name="bonus[]" value="reflexion" /> +1 pour la réflexion <br />
		</fieldset>
		<br>
		<input type="reset" value="Annuler" /> <input type="submit" value='Valider' />
	</form>
	<footer>
		<p>Copyright 2023 - Tous droits réservés <br>Mentions légales - CGU - Nous contacter</p>
	</footer>
</body>

</html>