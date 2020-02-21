<?php 

	
	if( !empty( $_POST ) ) {

		$identifiant = !empty($_POST['identifiant']) ? $_POST['identifiant'] : '';
		$nom = !empty($_POST['nom']) ? $_POST['nom'] : '';
		$prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : '';
		$mail = !empty($_POST['mail']) ? $_POST['mail'] : '';
		$mdp = !empty($_POST['mdp']) ? $_POST['mdp'] : '';

		if( empty( $identifiant ) ) { 
			$message_identifiant = 'L\identifiant est obligatoire'; 
		}
		if( empty( $nom ) ) { 
			$message_nom = 'Le nom est obligatoire'; 
		}
		if( empty( $prenom ) ) { 
			$message_prenom = 'Le prénom est obligatoire'; 
		}
		if( empty( $mail ) ) { 
			$message_mail = 'L\adresse mail est obligatoire'; 
		}
		if( empty( $mdp ) ) { 
			$message_mdp = 'Le mot de passe est obligatoire'; 
		}

		// $handler = fopen(  './data-files/membres.csv', 'r');

		// if( $handler ) {
		// 	while( $ligne = fgetcsv( $handler, 1024, ";" ) ) {

		// 		if( $ligne[0] == $identifiant ) {
		// 			$error_msg = 'Identifiant déjà utilisé';			
		// 			break;		
		// 		}
		// 		if( $ligne[3] == $mail ) {
		// 			$error_msg = 'Mail déjà utilisé';					
		// 			break;
		// 		}
		// 	}

		// 	fclose( $handler );
		// }

		// if( empty( $error_msg ) ) {

			// $valeurs = array( $identifiant, $nom, $prenom, $mail, $mdp, 'membre' );

			$bdd = new PDO( 'mysql:host=localhost;dbname=tpphp', 'root', '' );


			$sql = "SELECT * FROM membres WHERE 
				identifiant = '$identifiant' OR mail = '$mail' ";

			$resultat = $bdd->query( $sql );

			if( $resultat ) {

				$membres = $resultat->fetchAll( PDO::FETCH_ASSOC );

				if( count( $membres ) == 0 ) {
					$success_msg = 'Votre inscription a été prise en compte';
					$sql = "INSERT INTO membres 
						(identifiant, nom, prenom, mail, mdp, role) 
					VALUES 
						( '$identifiant', '$nom', '$prenom', '$mail', '$mdp', 'Membre')";
					$resultat = $bdd->exec( $sql );
					if( $resultat ) {
						$success_msg = 'Votre inscription a été prise en compte';
					} else {
						die('Pb insertion');
					}
				} else {
					$error_msg = 'Identifiant ou mail déjà utilisé';
				}
			} // if( $resultat )

			unset( $bdd );

			// $handler = fopen(  './data-files/membres.csv', 'a');
			// if( $handler) {
			// 	fputcsv( $handler, $valeurs, ";" );
			// 	fclose($handler);
			// 	$success_msg = 'Votre inscription a été prise en compte';
			// }

		// }

	} // if( !empty( $_POST ) )

?>

<?php require './template-parts/header.php'; ?>

<div id="page">
	
	<div class="content">
		<section>

			<?php if( !empty( $success_msg ) ) { ?>
				<h2><?php echo $success_msg; ?></h2>
			<?php } else { ?>
				<form action="" method="post">

					<?php if( !empty( $error_msg ) ) { ?>
						<p><?php echo $error_msg; ?></p>
					<?php } ?>

					<?php if( !empty($message_identifiant) ) { echo($message_identifiant); } ?>
					<label for="identifiant">Identifiant : 
						<input type="text" name="identifiant" id="identifiant">
					</label>
					
					<?php if( !empty($message_nom) ) { echo($message_nom); } ?><label for="nom">Nom :
						<input type="text" name="nom" id="nom">
					</label>
					
					<?php if( !empty($message_prenom) ) { echo($message_prenom); } ?><label for="prenom">Prénom : 
						<input type="text" name="prenom" id="prenom">
					</label>

					<?php if( !empty($message_mail) ) { echo($message_mail); } ?><label for="mail">Mail :
						<input type="text" name="mail" id="mail">
					</label>

					<?php if( !empty($message_mdp) ) { echo($message_mdp); } ?><label for="mdp">Mot de passe :
						<input type="password" name="mdp" id="mdp">
					</label>
					<input type="submit" name="validation" value="Valider">
				</form>
			<?php } ?>


		</section>
	</div>
	

	<div class="sidebar">
		<aside><?php include './template-parts/sidebar.php'; ?></aside>
	</div>


</div>


<?php include './template-parts/footer.php'; ?>