<?php 

	$lib_urgence = array(1=>'Normal', 2=>'Urgent', 3=>'Prioritaire', 4=>'Ultra prioritaire');

	if( !empty( $_POST ) ) {

		$nom  					= $_POST['nom'];
		$prenom  				= $_POST['prenom'];
		$message_utilisateur 	= $_POST['message'];

		if( !empty( $_POST['destinataire'] ) ) {
		
			// $flag = true;

			// foreach( $_POST['destinataire'] as $destinataire )

			// 	if( $flag ) {
			// 		$liste_destinataires .= $destinataire; 
			// 		$flag = false;
			// 	} else {
			// 		$liste_destinataires .= ','.$destinataire; 
			// 	}

			// } // foreach

			$liste_destinataires = implode( $_POST['destinataire'], ', ' ); 



		}


		if( empty( $nom ) || empty( $prenom ) ) {
			$message = "Les champs sont obligatoires";


			if( isset( $_POST['accord'] ) ) {
				echo 'la case est cochée : ';
			} else {
				echo 'la case n\'est pas cochée';
			}

		} else {
			
			$message = "Bonjour $prenom $nom";

			$filename = './data-files/visiteurs.csv';
			$handler = fopen( $filename, 'a' );  // a= append


			// fputcsv( $handler, array( $date, $nom, $prenom ), ';'  );
			fclose( $handler );

			

			$date = date( 'Ymd-His', time() );

			$ext = 	explode( '.', $_FILES['fichier']['name'] );

			$fichier = $date . '-' . $nom . '-' . $prenom.'.'.$ext[1];

			if(!empty($_FILES)) :
				move_uploaded_file($_FILES['fichier']['tmp_name'], './telechargements/'.$fichier );
			endif;
		}


		if( !empty( $_FILES ) ) {


			$types = array( 'image/jpg', 'image/png' );

			if( in_array( $_FILES['fichier']['type'], $types ) ) {

				if( $_FILES['fichier']['size'] < 1024*1024 ) {

					$destination = './upload/'.date( 'Y-m-d-H-i-s', time() ).'-'.$nom.'-'.$prenom.'.ext';
				
					move_uploaded_file($_FILES['fichier']['tmp_name'], $destination);

				}

			}



			// if( $_FILES['fichier']['type'] == 'image/jpg' || 
			// 	$_FILES['fichier']['type'] == 'image/png'
			// 	 ) {
			// 	move_uploaded_file(filename, destination);
			// }





		}

	}

?>
<?php require './template-parts/header.php'; ?>

<div id="page">
	
	<div class="content">
		<section>
			
				<?php if( !empty($message) ) { ?>
					<div class="message"><?php echo $message; ?></div>'
				<?php } ?>

				<?php if( !empty($_POST['sujet'] ) ) { ?>
					<div class="">Sujet : <?php echo $_POST['sujet']; ?><br></div>'
				<?php } ?>

				<?php if( !empty($_POST['priorite'] ) ) { ?>
					<div class="">Urgence : <?php echo $lib_urgence[ $_POST['priorite'] ]; ?><br></div>'
				<?php } ?>
				
				<?php if( !empty($liste_destinataires ) ) { ?>
					<?php
						if( count( $_POST['destinataire'] ) > 1 ) {
							$pluriel = 's';
						} else {
							$pluriel = '';
 						}
					?>
					<div class="">
						Destinataire<?php echo $pluriel; ?> : <?php echo $liste_destinataires; ?><br>
					</div>
				<?php } ?>


				<?php if( !empty($message_utilisateur) ) { ?>
					<p>Votre message : </p>
					<div class="message"><?php echo nl2br($message_utilisateur); ?></div>
				<?php } ?>

			<form action="" method="POST" enctype="multipart/form-data">
				
				
				<label for="nom">
					<input type="text" name="nom" id="nom" value="" placeholder="Votre nom" />
				</label>
				<label for="prenom">
					<input type="text" name="prenom" id="prenom" value="" placeholder="Votre prenom" />
				</label>

				<label for="priorite">Priorité
					<select name="priorite" id="priorite">
						<?php 
							// foreach($lib_urgence as $key=>$valeur) {
							// 	echo '<option value="'.$key.'">'.$valeur.'</option>';
							// }
						?>
						<option value="1">Normal</option>
						<option value="2">Urgent</option>
						<option value="3">Prioritaire</option>
					</select>
				</label>

				<label for="destinataire">Destinataire(s)
					<select name="destinataire[]" id="destinataire" size="5" multiple>
						<option value="1">Secrétariat</option>
						<option value="2">SAV</option>
						<option value="3">Comptabilité</option>
						<option value="4">Choix 4</option>
						<option value="5">Choix 5</option>
					</select>
				</label>

				<label for="sujet">
					<input type="text" name="sujet" id="sujet" value="" placeholder="Objet de votre message" />
				</label>

				<label for="message">Message
					<textarea name="message" id="message" cols="30" rows="10"></textarea>
				</label>

				<label for="accord">
					<input type="checkbox" name="accord" id="accord" value="ma-valeur" />&nbsp;J'accepte d'être recontacté
				</label>
				
				<label for="fichier">Pièce jointe
					<input type="file" name="fichier" id="fichier">
				</label>

				<input type="submit" name="validation" value="Valider" id="" />
			
			</form>
		</section>
	</div>
	

	<div class="sidebar">
		<aside><?php include './template-parts/sidebar.php'; ?></aside>
	</div>


</div>


<?php include './template-parts/footer.php'; ?>