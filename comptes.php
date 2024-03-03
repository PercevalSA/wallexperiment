<?php
session_start();
if (!isset($_SESSION['login'])) {
	header ('Location: index.php');
	exit();
}

// Cette page est l'accueil et la page de connexion
// elle traite le login directement et le renvoie vers l'espace membre

// on regarde si c'est un ajout de dépense
if (isset($_POST['ajout']) && $_POST['ajout'] == 'Ajouter') {
	if (	(isset($_POST['date']) && (!empty($_POST['date']) && ($_POST['date']) != '0000-00-00'))
		&& (isset($_POST['montant']) && !empty($_POST['montant']))
		&& (isset($_POST['type']) && !empty($_POST['type']))
		&& (isset($_POST['titre']) && !empty($_POST['titre']))) {

		// check si revenu ou dépense
		if (($_POST['type'] != "autre [+]") && ($_POST['type'] != "salaire [+]") && ($_POST['type'] != "pension [+]")) {
			$_POST['montant'] = -($_POST['montant']);
		}

		// connnexion à la base
		require "mysql_connect.php";

		// insertion de la nouvelle donnée dans la base des comptes
		$requete = "INSERT INTO comptes (date, type, titre, montant, user) VALUES ('".$_POST['date']."', '".$_POST['type']."', '".$_POST['titre']."', '".$_POST['montant']."', '".$_SESSION['login']."')";
		mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
		mysql_close();

	} else {
		$erreur = 'Un des champs est vide, veuillez recommencez';
	}
}



// on regarde si c'est une suppression de ligne
// la veleur dans $_POST['supprimer'] contient l'ID de l'entrée en base de données à supprimer
if (isset($_POST['supprimer']) && $_POST['supprimer'] == 'Supprimer') {
	if (isset($_POST['entree']) && (!empty($_POST['entree']))) {
		
		// connnexion à la base
		require "mysql_connect.php";

		// suppression de l'entrée
		$requete = 'DELETE FROM comptes WHERE ID = '.$_POST['entree'];
		mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
		mysql_close();
	
	} else {
		$erreur = "Aucune entrée n'a été sélectionnée pour la suppression";
	}
}

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

	<h1>WallExperiment</h1>
	<h3>Bienvenue <?php echo htmlentities(trim($_SESSION['login'])); ?>, gérez simplement votre argent pendant l'experiment !</h3>
	<br /><a href="deconnexion.php">Déconnexion</a><br />

	<img src="media/money-travel.jpg" alt="banner">
		
	<div class=statistiques>
	<fieldset>
	<legend>Statistiques</legend>
		<?php
			require "mysql_connect.php";
			
			$requete = 'SELECT SUM(montant) AS total FROM comptes WHERE user = "'.$_SESSION['login'].'"';
			$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
			while ($data = mysql_fetch_array($result)) {
				echo '<br />Solde Actuel : '.$data['total'];
			}
			mysql_free_result($result);

			$requete = 'SELECT SUM(montant) AS total FROM comptes WHERE user = "'.$_SESSION['login'].'" AND montant < 0';
			$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
			while ($data = mysql_fetch_array($result)) {
				echo '<br />Total dépenses : '.$data['total'];
			}
			mysql_free_result($result);


			$requete = 'SELECT SUM(montant) AS total FROM comptes WHERE user = "'.$_SESSION['login'].'" AND montant > 0';
			$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
			while ($data = mysql_fetch_array($result)) {
				echo '<br />Total entrées : '.$data['total'];
			}
			mysql_free_result($result);


			$requete = 'SELECT SUM(montant) AS total FROM comptes WHERE user = "'.$_SESSION['login'].'" AND montant < 0 AND comptes.date > CURRENT_DATE - INTERVAL 6 DAY';
			$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
			while ($data = mysql_fetch_array($result)) {
				echo '<br />Dépenses de la semaine (glissante) : '.$data['total'];
			}
			mysql_free_result($result);
			

			$requete = 'SELECT SUM(montant) AS total FROM comptes WHERE user = "'.$_SESSION['login'].'" AND montant < 0 AND comptes.date > CURRENT_DATE - INTERVAL 29 DAY';
			$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
			while ($data = mysql_fetch_array($result)) {
				echo '<br />Dépenses sur le mois (glissant) : '.$data['total'];
			}
			mysql_free_result($result);

			//Dépense moyenne :<br />

			mysql_close();
		?>
	</fieldset>
	</div>

	<br />	
	<?php
		if (isset($erreur)) echo "<div class=erreur>$erreur</div>";
	?>

	<center><table border=1>
		<tr><td>date</td><td>type</td><td>intitulé</td><td>montant</td></tr>

		<tr><form method=post name=compte action="comptes.php">
			<td><input type="date" name="date"></td>
			<td><select name="type" size="1"><option>autre [-]<option>alimentation [-]<option>déplacement [-]<option>imprévu [-]<option>loisir [-]
											<option>logement [-]<option>medical [-]<option>culture [-]<option>autre [+]<option>salaire [+]<option>pension [+]</select>
			<td><input type="text" name="titre"></td>
			<td><input type="number" name="montant" step="any" min=0 value=0></td>
			<td><input type="submit" name="ajout" value="Ajouter"></td>
		</form></tr>

		<!-- formulaire pour la suppression -->
		<form method=post name=compte action="comptes.php">
		<?php
			// création recursive des lignes du tableau avec tous les résultats de la base donnés
			require "mysql_connect.php";
			$requete = 'SELECT * FROM comptes WHERE user = "'.$_SESSION['login'].'" ORDER BY date DESC';
			$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
	
			while ($data = mysql_fetch_array($result)) {
				echo '<tr><td>'.$data['date'].'</td><td>'.$data['type'].'</td><td>'.$data['titre'].'</td><td>'.$data['montant'].'</td>
				<td><input type="radio" name="entree" value="'.$data['id'].'">';

			}
			mysql_free_result($result);
			mysql_close();
		?>
		<tr><td></td><td></td><td></td><td></td><td><input type="submit" name="supprimer" value="Supprimer"></td></tr>
		</form>
	</table></center>

</body>
</html>

<!-- <td><button id="delete<?php echo $id ?>">Suppr</button></td></tr>'; -->
