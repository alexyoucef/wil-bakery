<!DOCTYPE html>
<html>
	
	<head>
		<title>PHP</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="./css/style.css">
	</head>
	
	<body>

		<header>

			Header

			<?php

				// nom prénom

				$bd = new PDO('mysql:host=localhost;dbname=tpphp', 'root', '' );

				if( $bd ) {

					$sql = "SELECT nom, prenom FROM membres WHERE identifiant= :a";

					$requete = $bd->prepare( $sql );

					$requete->execute( array( 'a' => $_SESSION['identifiant'] ) );

					$resultat = $requete->fetch( PDO::FETCH_ASSOC );

					?>
						<h3><?php echo $resultat['prenom'].' '.$resultat['nom']; ?></h3>
					<?php

				}

				

			?>
			
			<ul id="menu-principal">
				<li><a href="./index.php">Accueil</a></li>
				<li><a href="./page.php">Page</a></li>
				<li><a href="./visiteurs.php">Visiteurs</a></li>
				<li><a href="./inscription.php">Inscription</a></li>
				<li><a href="./contact.php">Contact</a></li>
				<li><a href="./deconnexion.php">Déconnexion</a></li>
			</ul>

		</header>

