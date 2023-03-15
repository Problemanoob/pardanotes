<?

if (isset($_POST["username"])) {
	$username = $_POST["username"];
} else if (isset($_GET["username"])) {
	$username = $_GET["username"];
} else {
	$username = "Inconnu";
}

$message = "";

$file = "help.txt";
if (isset($_GET["help"])) {

	# Chemin vers fichier texte
	# Ouverture en mode écriture
	$fileopen = (fopen("$file", "a+"));

	if (filesize($file) == 0) {
		$entete = "Date;nomEtudiant;\n";
		fwrite($fileopen, $entete);
	}

	$date = new DateTime('now');
	fwrite($fileopen, $date->format('Y-m-d H:i:s') . ";" . $username);
	fwrite($fileopen, "\n");

	# On ferme le fichier proprement
	fclose($fileopen);
	$message =  "La demande d'aide a été enregistrée dans le fichier  <a target=\"_blank\" href=\"$file\">$file</a>";
}

function sensInverse($file)
{
	$fichier = file($file);
	$total = count($fichier) - 1;
	$page = "";
	for ($i = $total; $i >= 0; $i--) {
		$page .= "<tr><td>" . explode(";", $fichier[$i])[0] . "</td><td>" . explode(";", $fichier[$i])[1] . "</td></tr>";
	}
	return $page;
}

function compteLigne($file)
{
	$fichier = file($file);
	return  "Le fichier <a target=\"_blank\" href=\"$file\">" . $file . "</a> compte " . count($fichier) . " lignes";
}


$page = sensInverse($file);
$message = compteLigne($file);

?>
<!DOCTYPE html>

<head>
	<title>Bienvenue dans Pardanotes</title>

	<head>
		<meta charset="utf-8">
		<!-- importer le fichier de style -->
		<link rel="stylesheet" href="style.css" media="screen" type="text/css" />
		<link rel="stylesheet" href="tp9.css" media="screen" type="text/css" />
		<META HTTP-EQUIV="Refresh" CONTENT="5">
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
		<div id="help"><a class="bouton" href="enregistrerAide.php?username=<?= $username ?>">J'ai besoin d'aide</a>
		</div>
		<br>
		<br>
		<p class="message"><?= $message ?></p>
		<table> <?= $page ?> </table>
		<br>
		<br>
		<br>
		<br>
	</div>
	</div>
	<footer>
		<p>Copyright 2023 - Tous droits réservés <br>Mentions légales - CGU - Nous contacter</p>
	</footer>
</body>

</html>