<p>Modifier le profil !</p>

<?php

if ( isset($_GET['id'] ) ) {
    $identifiant = $_GET['id'];

}else {
    $identifiant = $_SESSION['identifiant'];
    //lire les infos des utilisateur connecté
    
}





    $sql = "SELECT nom, prenom, mail, identifiant FROM membres WHERE identifiant = :a OR mail = :a";
    $bdd = new PDO('mysql:host=localhost;dbname=wil-bakery', 'root', '');
    if($bdd) {
        $requete = $bdd->prepare($sql);

        if ($requete) {
            $requete->execute(array( 'a' => $identifiant));
            $membre = $requete->fetch(PDO::FETCH_ASSOC);
        }
    }

if (!empty($_POST)) {
    
    $msg_erreur = '';
    
    $obligatoire = array('nom', 'prenom', 'mail');
    foreach($obligatoire as $value) {
        if (empty( $_POST[$value] ) ) {
            $msg_erreur = 'veuillez remplir les champs obligatoires';
        } else {
            $$value = $_POST[$value];
        }
    }

    if ($_POST['mail'] != $membre['mail'] ) {

        if ($bdd) {
            $sql = "SELECT count(*) FROM membres WHERE mail = :a";
            $requete = $bdd->prepare($sql);
            if ($requete) {
                $requete->execute(array('a'=> $_POST['mail'] ) );
                $nb = $requete->fetchColumn();
                if($nb !=0) {
                    $msg_erreur = "Mail deja existant !";
                }
            }
        }
        //controle doublon
    }

    if (empty ($msg_erreur) ) {
        //mettre a jour le profil
        $sql = "UPDATE membres 
        SET nom = :nom, prenom = :prenom, mail = :mail, adresse = :adresse
        WHERE identifiant = '$identifiant' ";
        $requete = $bdd->prepare($sql);
        if($requete){
            $requete->execute(array('nom'=>$nom, 'prenom'=>$prenom, 'mail'=>$mail, 'adresse'=>$adresse));
            $msg_succes = "Données mise a jour !";
        }



    }else {
    
    echo $msg_erreur;
    }
    //controler les informations
    // mettre a jour le profil
    if (!empty($msg_succes)) { echo $msg_succes; }
} 

?>


<p> <?php echo 'Identifiant : '.$membre['identifiant']. ', Nom : '.$membre['nom'].', Prenom : '.$membre['prenom'].', Mail : '.$membre['mail']; ?></p>

<form action="" method="POST">

    <input readonly type="text" name="identifiant" id="identifiant" placeholder="Entrez le nouvel identifiant" value="<?php echo $membre['identifiant']; ?>" />
    <input type="text" name="nom" id="nom" placeholder="Entrez le nouveau Nom" value="<?php echo $membre['nom']; ?>"/>
    <input type="text" name="prenom" id="prenom" placeholder="Entrez le nouveau Prenom" value="<?php echo $membre['prenom']; ?>" />
	<input type="text" name="mail" id="mail" placeholder="Entrez le nouveau Mail" value=" <?php echo $membre['mail']; ?>"/>
    <input type="text" name="adresse" id="adresse" placeholder="Entrez la nouvelle adresse" value=" <?php echo $membre['adresse']; ?>"/>
	

    <input type="text" name="mdp" id="mdp" placeholder="Mot de passe" value=""/>
    <input type="text" name="mdp2" id="mdp2" placeholder="Confirmez le Mot de passe" value=""/>

    <input type="submit" value="Valider les changements" >


</form>