<html>
<head>
<title>Toitinou </title>
<center><H1>Votre compte à bien été créé</H1></center>
<hr>
</head>


<body>
<center><p><img alt="Afficher l'image d'origine" height="270" id="il_fi" src="http://cliniqueproaction.com/wp-content/uploads/2015/07/succion-pouce.gif" style="padding-right: 8px; padding-top: 8px; padding-bottom: 8px;" width="210" /></p></center>
<A HREF="form.html">S'identifier</A>
	<?php
	mysql_connect("localhost","eleve.tou","et*301");
	mysql_select_db("Gestion portefeuille experiment (mayeul et antoine)"); 
	$Nom=$_POST['Nom'];
	$Prenom=$_POST['Prenom'];
	$Adresse_mail=$_POST['Adresse_mail'];
	
	
	$_requete = "INSERT INTO eleve (Nom,Prenom,Adresse_mail) VALUES ('$Nom','$Prenom','$Adresse_mail')";
	$result =mysql_query( $_requete );
	if (!$result) {
    die('Requête invalide : ' . mysql_error());
	}
	$identifiant=$_POST['identifiant'];
	$PassWord=$_POST['PassWord'];
	
	$_Compte = "INSERT INTO Compte(identifiant,PassWord,Email) VALUES ('$identifiant','$PassWord','$Adresse_mail')";
	$result =mysql_query( $_Compte );
	if (!$result) {
    die('Requête invalide : ' . mysql_error());
	}
	?>
</body>
</html>