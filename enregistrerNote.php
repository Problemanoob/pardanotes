<?

if (isset($_POST["username"])) {
	$username = $_POST["username"];
} else if (isset($_GET["username"])) {
	$username = $_GET["username"];
} else {
	$username = "Inconnu";
}
if (isset($_POST["bonus"])) {
	$tabBonus = $_POST["bonus"];
} else {
	$tabBonus = array();
}


$message = "";
if (isset($_POST["nomEtudiant"])) {

	# Chemin vers fichier texte
	$file = "notes.txt";
	# Ouverture en mode écriture
	$fileopen = (fopen("$file", "a+"));

	if (filesize($file) == 0) {
		$entete = "nomEtudiant;matiere;note;bonus\n";
		fwrite($fileopen, $entete);
	}
	fwrite($fileopen, $_POST["nomEtudiant"] . ";" . $_POST["matiere"] . ";" . $_POST["note"] . ";");
	foreach ($tabBonus as $bonus1) {
		fwrite($fileopen, $bonus1 . ";");
	}
	fwrite($fileopen, "\n");

	# On ferme le fichier proprement
	fclose($fileopen);
	$message =  "La note a été enregistrée dans le fichier <a target=\"_blank\" href=\"$file\">$file</a>";
}

?>
<!DOCTYPE html>

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
	<div id="contenu">
		<p class="message"><?= $message ?></p>
		<p>L'étudiant selectionné a pour identifiant : <?= $_POST["nomEtudiant"] ?> </p>
		<p>La matière selectionnée est : <?= $_POST["matiere"] ?></p>
		<p>La note saisie est : <?= $_POST["note"] ?> </p>
		<? foreach ($tabBonus as $bonus1) { ?>
		<p>Le bonus <?= $bonus1 ?> a été selectionné </p>
		<? } ?>
	</div>
	<footer>
		<p>Copyright 2023 - Tous droits réservés <br>Mentions légales - CGU - Nous contacter</p>
	</footer>
</body>

</html>