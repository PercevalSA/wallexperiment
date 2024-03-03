<?php
session_start();
if (isset($_SESSION['login'])) {
	header ('Location: comptes.php');
	exit();
}
// Cette page est l'accueil et la page de connexion
// elle traite le login directement et le renvoie vers l'espace membre
// on regarde si c'est une première connexion ou une tentative de connexion
if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) {

		// connnexion à la base
		require "mysql_connect.php";
	
		// on vérifie que le couple login/mdp est valide
		// mysql escape string permet de conserver les caractère spéciaux tels quels
		$requete = 'SELECT count(*) FROM users WHERE login="'.mysql_escape_string($_POST['login']).'" AND password="'.mysql_escape_string(md5($_POST['pass'])).'"';
		$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
		$data = mysql_fetch_array($result);
		mysql_free_result($result);
		mysql_close();

		// connexion valide
		if ($data[0] == 1) {
			//création d'un cookie
			session_start();
			$_SESSION['login'] = $_POST['login'];
			// redirection vers l'espace membre
			header('Location: comptes.php');
			exit();
		}
		// pas de user ou mauvais mot de passe
		elseif ($data[0] == 0) {
			$erreur = 'Identifiant ou mot de passe invalide';
		}
		// plusieurs résultats : impossible
		else {
			$erreur = 'DataBase error multiple data values';
		}
	}
	else {
	$erreur = 'Identifiant ou mot de passe vide...';
	}
}
?>


<html lang="fr">
<!-- 
  the cake is a lie
-->
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
	<h1>Bienvenue sur WallExperiment</h1>
	<h2>gérez simplement votre argent pendant l'experiment</h2>
	<img src="media/money.jpg" alt="banner">
	
	<form method=post action="index.php">
	<fieldset>
	<legend>
		<?php
			if (isset($erreur)) {
				echo "<div class=erreur>$erreur</div>";
			}
			else {
				echo "connexion";
			}
		?>
	</legend>
		<center><table>
			<tr><td>Identifiant : </td><td><input type="text" name="login" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>"></td></tr>
			<tr><td>Mot de passe : </td><td><input type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>"></td></tr>
		</table></center>
		<input type="submit" name="connexion" value="Connexion">
	</fieldset>
	</form>

	<br />
	<a href="inscription.php">vous inscrire</a>

</body>
</html>

