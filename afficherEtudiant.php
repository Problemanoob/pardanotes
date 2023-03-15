<?php

if (isset($_POST["username"])) {
	$username = $_POST["username"];
} else if (isset($_GET["username"])) {
	$username = $_GET["username"];
} else {
	$username = "Inconnu";
}

$message = "";

try {
	//Connexion à la BDD
	$mysqlConnection = new PDO(
		'mysql:host=' . $hostname . ';dbname=' . $database,
		$user,
		$pwd
	);
	//Ecriture de la requête
	$sqlQuery = "SELECT (:nom,:prenom,:login,:mdp,:date_naissance,:access";
	//Préparation de la requête par PDO
	$statment = $mysqlConnection->prepare("*A COMPLETER*");
	//Execution de la requête
	if ($statment->execute()) {
		//le resultat est retourné sous forme de tableau
		$etudiants = $statment->fetchAll();
	}
} catch (PDOException $error) {
	echo 'Échec de la connexion : ' . $error->getMessage();
} finally {
	$mysqlConnection = null;
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
	<div id="contenu">
		<br>
		<p><?= $message ?></p>
		<br>
		<table>
			<tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Login</th>
				<th>Password</th>
				<th>Date de naissance</th>
				<th>Actif</th>
				<th>Date de création</th>
				<th>Date de modification</th>
				<!-- A COMPLETER -->
			</tr>
		</table>
		<br>
		<br>
	</div>
	<footer>
		<p>Copyright 2023 - Tous droits réservés <br>Mentions légales - CGU - Nous contacter</p>
	</footer>
</body>

</html>