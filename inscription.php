<?php

// Cette page est l'inscription
// elle traite le l'inscription directement et le renvoie vers l'espace membre
// on regarde si c'est une première arrivée ou une tentative d'inscription

if (isset($_POST['inscription']) && $_POST['inscription'] == 'Inscription') {
	// on teste l'existence de nos variables. On teste également si elles ne sont pas vides
	if (		(isset($_POST['login']) && !empty($_POST['login'])) 
			&& (isset($_POST['pass']) && !empty($_POST['pass'])) 
			&& (isset($_POST['pass_confirm']) && !empty($_POST['pass_confirm'])) 
			&& (isset($_POST['nom']) && !empty($_POST['nom'])) 
			&& (isset($_POST['prenom']) && !empty($_POST['prenom']))
			&& (isset($_POST['mail']) && !empty($_POST['mail']))
			&& (isset($_POST['naissance']) && !empty($_POST['naissance']))) {


		// véririfaction du pass
		if ($_POST['pass'] != $_POST['pass_confirm']) {
			$erreur = 'Les 2 mots de passe ne sont pas identiques';
		}
		else {
	
			// connexion à la base
			require "mysql_connect.php";
	
			// teste l'unicité du pseudo
			$requete = 'SELECT count(*) FROM users WHERE login="'.mysql_escape_string($_POST['login']).'"';
			$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
			$data = mysql_fetch_array($result);
	
			if ($data[0] == 0) {

				$requete = 'INSERT INTO users VALUES("", "'.mysql_escape_string($_POST['login']).'", "'
															.mysql_escape_string(md5($_POST['pass'])).'", "'
															.mysql_escape_string($_POST['nom']).'", "'
															.mysql_escape_string($_POST['prenom']).'", "'
															.mysql_escape_string($_POST['mail']).'", "'
															.mysql_escape_string($_POST['naissance']).'")';

				$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
				$data = mysql_fetch_array($result);


				// création d'un cookie
				session_start();
				$_SESSION['login'] = $_POST['login'];
				header('Location: comptes.php');
				exit();
			}
			else {
				$erreur = 'Ce pseudo est déjà utilisé';
			}
		}
	}
	else {
	$erreur = 'Tous les champs de ne sont pas remplis';
	}
}
?>

<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>WallExperiment</title>
	<meta name="description" content="a money managemnt tool for icam studnets">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<p><h1>Inscription sur WallExperiment</h1></p>
	<h4><a href="index.php">accueil</a></h4>
	<img src="media/money.jpg" alt="banner"><br /><br />

	<form method=post name=inscription action="inscription.php">
	<fieldset>
		<legend>
		<?php
			if (isset($erreur)) {
				echo "<div class=erreur>$erreur</div>";
			}
			else {
				echo "inscription";
			}
		?>
		</legend>
		
		<center><table>
		<tr><td>identifiant :		</td><td><input type="text" name="login" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>"></td></tr>
		<tr><td>mot de passe :		</td><td><input type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>"></td></tr>
		<tr><td>confirmez :			</td><td><input type="password" name="pass_confirm" value="<?php if (isset($_POST['pass_confirm'])) echo htmlentities(trim($_POST['pass_confirm'])); ?>"></td></tr>
		<tr><td>nom	:				</td><td><input type="text" name="nom"></td></tr>
		<tr><td>prenom :			</td><td><input type="text" name="prenom"></td></tr>
		<tr><td>adresse mail :		</td><td><input type="mail" name="mail"></td></tr>
		<tr><td>date de naissance : </td><td><input type="date" name="naissance" value="AAAA-MM-JJ"></td></tr>
		</table></center>
		<input type="submit" name="inscription" value="Inscription">
	</fieldset>
	</form>
</body>
</html>