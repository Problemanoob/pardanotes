<?php

if (isset($_POST["username"])) {
	$username = $_POST["username"];
} else if (isset($_GET["username"])) {
	$username = $_GET["username"];
} else {
	$username = "Inconnu";
}

$noteMaths = 16;
$tabnotes = array(
	'Emma Snowsill' => 12,
	'Tom Richard' => 8,
	'Jawad Abdelmoula' => 18,
	'Jan Frodeno' => 16,
	'Cassandre Beaugrand' => 6,
	'Taylor Spivey' => 11,
	'Sam Long' => 18,
	'Lionel Sanders' => 16,
	'Gustav Iden' => 20,
	'Flora Duffy' => 20,
	'Taylor Knibb' => 7,
	'Nathan Qherbeur' => 9,
	'Alex Yee' => 12,
	'Lucy Charles' => 19,
	'Ellie Salthouse' => 18,
	'Heather Jackson' => 14,
	'Joe Skipper' => 5,
	'Manon Genêt' => 10,
	'Antony Costes' => 1
);

//Moyenne
$sum = 0;
$i = 0;
foreach ($tabnotes as $note) {
	$sum += $note;
	$i++;
}
$avg = $sum / $i;

//Ellie Salthouse
//echo "<br/>La note d'Ellie Salthouse est :" . $tabnotes["Ellie Salthouse"] . "/20";

//initiales
//echo "<br>Les initiales de la classe : ";
foreach ($tabnotes as $cle => $valeur) {
	$initiale[$cle] = $cle[0];
	//	echo  $cle[0] . " ";
}

//On crée le numéro étudiant $etu auquel on affecte une valeur de départ
$etu = 20230001;
$listeEtu[$etu] = 'Emma Snowshill';
$listeEtu[] = 'Tom Richard';
$listeEtu[] = 'Jawad Abdelmoula';
$listeEtu[] = 'Jan Frodeno';
$listeEtu[] = 'Cassandre Beaugrand';
$listeEtu[] = 'Taylor Spivey';
$listeEtu[] = 'Sam Long';
$listeEtu[] = 'Lionel Sanders';
$listeEtu[] = 'Gustav Iden';
$listeEtu[] = 'Flora Duffy';
$listeEtu[] = 'Taylor Knibb';
$listeEtu[] = 'Nathan Qherbeur';
$listeEtu[] = 'Alex Yee';
$listeEtu[] = 'Lucy Charles';
$listeEtu[] = 'Ellie Salthouse';
$listeEtu[] = 'Heather Jackson';
$listeEtu[] = 'Joe Skipper';
$listeEtu[] = 'Manon Genêt';
$listeEtu[] = 'Antony Costes';

$message = "";
if (isset($_GET["action"]) && $_GET["action"] == "export") {

	# Chemin vers fichier texte
	$file = "file.txt";
	# Ouverture en mode écriture
	$fileopen = (fopen("$file", "w+"));
	# Ecriture de "Début du fichier" dansle fichier texte
	fwrite($fileopen, "nom;note\n");
	foreach ($tabnotes as $cle => $valeur) {
		fwrite($fileopen, "$cle;$valeur\n");
	}
	# On ferme le fichier proprement
	fclose($fileopen);
	$message =  "La liste des notes a été correctement exportée dans le fichier <a target=\"_blank\" href=\"$file\">$file</a>";
}

if (isset($_GET["action"]) && $_GET["action"] == "chatgpt") {
	$dTemperature = 0.9;
	$question = "Donne-moi des commentaires pour chaque étudiants en coréalation avec leur note sur 20. " . trim(json_encode($tabnotes) . " Le format attendu est un JSON avec le nom en String et le commentaire en String. Les commentaires doivent s'adresser aux étudiants et doivent être durs pour ceux qui ont moins de 10, encourager ceux qui ont entre 10 et 14 et féliciter ceux qui ont plus de 14 mais ne doivent pas reprendre la note obtenue.");
	$iMaxTokens = 1000;
	$top_p = 1;
	$frequency_penalty = 0.0;
	$presence_penalty = 0.0;
	$OPENAI_API_KEY = "A COMPLETER ICI LA KEY DE L'API";
	$sModel = "text-davinci-003";
	$prompt = $question;
	$ch = curl_init();
	$headers  = [
		'Accept: application/json',
		'Content-Type: application/json',
		'Authorization: Bearer ' . $OPENAI_API_KEY . ''
	];

	$postData = [
		'model' => $sModel,
		'prompt' => str_replace('"', '', $prompt),
		'temperature' => $dTemperature,
		'max_tokens' => $iMaxTokens,
		'top_p' => $top_p,
		'frequency_penalty' => $frequency_penalty,
		'presence_penalty' => $presence_penalty,
		'stop' => '[" Human:", " AI:"]',
	];

	curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

	$result = curl_exec($ch);
	$decoded_json = json_decode($result, true);
	//print_r($decoded_json);
	$reponse = str_replace("```", "", trim($decoded_json['choices'][0]['text']));
	$reponse = str_replace("json", "", $reponse);
	save($reponse);
}

function save($texte)
{
	# Chemin vers fichier texte
	$file = "appreciations.txt";
	$fileopen = file_put_contents("$file", $texte);
}

if (file_exists("appreciations.txt")) {
	$contenu = file_get_contents("appreciations.txt");
	$appreciations = json_decode($contenu, true);
} else {
	$appreciations = array();
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
		<h1>Bonjour <?= $username ?>, bienvenue sur Pardanotes</h1>
		<p class="message"><?= $message ?></p>
		<h2>Note de maths : <?= $noteMaths ?></h2>
		<br>
		<br>
		<table>
			<tr>
				<th>Nom de l'étudiant</th>
				<th>Notes</th>
				<th>Appréciations</th>
			</tr> <?php
					foreach ($tabnotes as $Nom => $note) { ?> <tr>
				<td><?= $Nom ?></td>
				<?
						if ($note < 10) {
							$couleur = "red";
						} else {
							$couleur = "black";
						}
					?>
				<td><span class="<?= $couleur ?>"><?= $note ?></span></td>
				<td><span
						class="<?= $couleur ?>"><?= (isset($appreciations[$Nom]) ? $appreciations[$Nom] : "") ?></span>
				</td>
			</tr>
			<?
					} ?>
			<tr>
				<th>Moyenne de la classe</th>
				<th><?= round($avg, 2) ?></th>
				<th></th>
		</table>
		<br>
		<br>
		<div id="export">
			<a class="bouton" href="?username=<?= $username ?>&action=export">Exporter les notes</a>&nbsp;
		</div>
		<br>
		<br>
	</div>
	<footer>
		<p>Copyright 2023 - Tous droits réservés <br>Mentions légales - CGU - Nous contacter</p>
	</footer>
</body>

</html>