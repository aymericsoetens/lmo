<?php
$nom=$prenom=$email=$telephone=$type_demande=$message="";
$nom_err=$prenom_err=$email_err=$type_err=$message_err=$captcha_err="";
$success_message=$error_message="";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nom=trim($_POST["nom"]);if(empty($nom)){$nom_err="Veuillez entrer votre nom.";}
    $prenom=trim($_POST["prenom"]);if(empty($prenom)){$prenom_err="Veuillez entrer votre prénom.";}
    $email=trim($_POST["email"]);if(empty($email)){$email_err="Veuillez entrer votre adresse email.";}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){$email_err="L'adresse email n'est pas valide.";}
    $telephone=trim($_POST["telephone"]);
    $type_demande=trim($_POST["type_demande"]);if(empty($type_demande)){$type_err="Veuillez sélectionner le type de demande.";}
    $message=trim($_POST["message"]);if(empty($message)){$message_err="Veuillez écrire votre message.";}
    $captcha=trim($_POST["captcha"]);$captcha_result=trim($_POST["captcha_result"]);
    if($captcha!=$captcha_result){$captcha_err="Le résultat du calcul est incorrect.";}
    if(empty($nom_err)&&empty($prenom_err)&&empty($email_err)&&empty($type_err)&&empty($message_err)&&empty($captcha_err)){
        $destinataire="asso.lmo@lamainocculte.fr";
        $type_label="";switch($type_demande){case"contact":$type_label="Contact général";break;case"recrutement-benevole":$type_label="Candidature - Bénévole";break;case"recrutement-jongleur":$type_label="Candidature - Jongleur";break;case"recrutement-communication":$type_label="Candidature - Communication";break;case"prestation":$type_label="Demande de prestation";break;case"partenariat":$type_label="Demande de partenariat";break;default:$type_label="Autre demande";}
        $sujet="[La Main Occulte] ".$type_label." - ".htmlspecialchars($prenom)." ".htmlspecialchars($nom);
        $corps_message="Nouveau message depuis le formulaire de contact.\n\n--- INFORMATIONS ---\nType de demande: ".$type_label."\nNom: ".htmlspecialchars($nom)."\nPrénom: ".htmlspecialchars($prenom)."\nEmail: ".htmlspecialchars($email)."\nTéléphone: ".(empty($telephone)?"Non renseigné":htmlspecialchars($telephone))."\n\n--- MESSAGE ---\n".htmlspecialchars($message)."\n\n--- MÉTADONNÉES ---\nIP: ".$_SERVER['REMOTE_ADDR']."\nDate: ".date('d/m/Y H:i:s');
        $headers="From: La Main Occulte <".$destinataire.">\r\nReply-To: ".htmlspecialchars($email)."\r\nX-Mailer: PHP/".phpversion()."\r\nMIME-Version: 1.0\r\nContent-Type: text/plain; charset=UTF-8\r\n";
        if(mail($destinataire,$sujet,$corps_message,$headers)){$success_message="Merci ! Votre message a été envoyé avec succès.";$nom=$prenom=$email=$telephone=$type_demande=$message="";}
        else{$error_message="Désolé, une erreur est survenue. Veuillez réessayer plus tard.";}
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,viewport-fit=cover">
<meta name="description" content="La Main Occulte : association de jonglerie en Normandie. Spectacles, ateliers d'initiation. Découvrez nos disciplines : diabolo, bâton du diable, jonglage de contact.">
<meta name="keywords" content="association jonglerie, jonglage Normandie, arts du cirque Bernay, festival Samhain, atelier diabolo, bâton du diable">
<meta property="og:title" content="La Main Occulte - Association de jonglerie">
<meta property="og:description" content="Découvrez nos spectacles et ateliers en Normandie.">
<meta property="og:image" content="https://lamainocculte.fr/img/banner/logo2.PNG">
<meta property="og:url" content="https://lamainocculte.fr">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<title>Contact - La Main Occulte </title>
<link rel="stylesheet" href="css/style.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<nav class="navbar">
<div class="logo-container"><a href="index.html"><img src="img/acceuil/logo.png" alt="La Main Occulte"></a></div>
<ul class="nav-links">
<li><a href="index.html">Accueil</a></li>
<li><a href="animations.html">Nos animations</a></li>
<li><a href="Agenda.html">Agenda</a></li>
<li><a href="galerie.html">Galerie</a></li>
<li><a href="contact.php" class="active">Adhésion & Contact</a></li>
</ul>
<div class="burger"><div class="line1"></div><div class="line2"></div><div class="line3"></div></div>
</nav>
</header>
<main>
<section class="page-header"><div class="container logo-runes"><h1>Contact & Rejoindre</h1><p>✦ Une question ? Une envie de nous rejoindre ? Écrivez-nous ! ✦</p></div></section>
<section class="pourquoi-section"><div class="container"><h2>Pourquoi nous rejoindre ?</h2><div class="pourquoi-grid"><div class="pourquoi-item"><div class="pourquoi-icon">🎭</div><h3>Une aventure humaine</h3><p>Une équipe passionnée et bienveillante où l'on partage et apprend ensemble.</p></div><div class="pourquoi-item"><div class="pourquoi-icon">🌟</div><h3>Des projets excitants</h3><p>Escape game, spectacles, festivals... Il y a toujours quelque chose à créer !</p></div><div class="pourquoi-item"><div class="pourquoi-icon">🤝</div><h3>Bienveillance et partage</h3><p>Peu importe ton niveau, tu as ta place chez nous.</p></div><div class="pourquoi-item"><div class="pourquoi-icon">🎪</div><h3>Les coulisses des festivals</h3><p>Découvre l'envers du décor et vis des moments uniques.</p></div></div><div class="offre-card"><div class="offre-icon">📝</div><h3>Devenir membre</h3><div class="back-to-home"><a href="adhesion.html" class="back-btn">Voir les formules →</a></div></div></div></section>
<section class="offres-section"><div class="container"><h2>Nos besoins du moment</h2><div class="offres-grid"><div class="offre-card"><div class="offre-icon">🎪</div><h3>Bénévoles festival</h3><p>Rejoignez-nous sur les festivals ! On a toujours besoin d'un coup de main (occulte).</p><ul><li>Accueil du public</li><li>Préparation et mise en place des ateliers et l'animation</li><li>Découvrir l'envers du décor</li></ul></div><div class="offre-card"><div class="offre-icon">🤹</div><h3>Membres jongleurs</h3><p>Tu pratiques le jonglage ou tu veux apprendre ?</p><ul><li>Jonglage de contact</li><li>Diabolo / Bâton du diable</li><li>Tous niveaux bienvenus</li></ul></div></div></div></section>
<section class="formulaire-section"><div class="container"><h2>Écrivez-nous</h2><p class="form-intro">Pour toute question, candidature ou projet, remplissez le formulaire ci-dessous.</p>
<?php if(!empty($success_message)){echo'<div class="alert alert-success">'.$success_message.'</div>';}if(!empty($error_message)){echo'<div class="alert alert-error">'.$error_message.'</div>';}?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="unified-form"><div class="form-row"><div class="form-group"><label for="nom">Nom *</label><input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($nom);?>" class="form-control <?php echo(!empty($nom_err))?'is-invalid':'';?>"><?php if(!empty($nom_err)){echo'<span class="error-feedback">'.$nom_err.'</span>';}?></div><div class="form-group"><label for="prenom">Prénom *</label><input type="text" name="prenom" id="prenom" value="<?php echo htmlspecialchars($prenom);?>" class="form-control <?php echo(!empty($prenom_err))?'is-invalid':'';?>"><?php if(!empty($prenom_err)){echo'<span class="error-feedback">'.$prenom_err.'</span>';}?></div></div>
<div class="form-row"><div class="form-group"><label for="email">Email *</label><input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email);?>" class="form-control <?php echo(!empty($email_err))?'is-invalid':'';?>"><?php if(!empty($email_err)){echo'<span class="error-feedback">'.$email_err.'</span>';}?></div><div class="form-group"><label for="telephone">Téléphone</label><input type="tel" name="telephone" id="telephone" value="<?php echo htmlspecialchars($telephone);?>" class="form-control"></div></div>
<div class="form-group"><label for="type_demande">Type de demande *</label><select name="type_demande" id="type_demande" class="form-control <?php echo(!empty($type_err))?'is-invalid':'';?>"><option value="">Sélectionnez une option</option><option value="contact" <?php echo($type_demande=="contact")?'selected':'';?>>📧 Contact général</option><option value="recrutement-benevole" <?php echo($type_demande=="recrutement-benevole")?'selected':'';?>>🎪 Candidature - Bénévole</option><option value="recrutement-jongleur" <?php echo($type_demande=="recrutement-jongleur")?'selected':'';?>>🤹 Candidature - Jongleur</option><option value="recrutement-communication" <?php echo($type_demande=="recrutement-communication")?'selected':'';?>>🎨 Candidature - Communication</option><option value="prestation" <?php echo($type_demande=="prestation")?'selected':'';?>>✨ Demande de prestation</option><option value="partenariat" <?php echo($type_demande=="partenariat")?'selected':'';?>>🤝 Demande de partenariat</option></select><?php if(!empty($type_err)){echo'<span class="error-feedback">'.$type_err.'</span>';}?></div>
<div class="form-group"><label for="message">Votre message *</label><textarea name="message" id="message" rows="6" class="form-control <?php echo(!empty($message_err))?'is-invalid':'';?>" placeholder="Dites-nous tout !"><?php echo htmlspecialchars($message);?></textarea><?php if(!empty($message_err)){echo'<span class="error-feedback">'.$message_err.'</span>';}?></div>
<div class="form-group captcha-group"><label>Question anti-spam : 3 + 4 = ?</label><input type="number" name="captcha" required class="form-control <?php echo(!empty($captcha_err))?'is-invalid':'';?>"><input type="hidden" name="captcha_result" value="7"><?php if(!empty($captcha_err)){echo'<span class="error-feedback">'.$captcha_err.'</span>';}?></div>
<button type="submit" class="btn btn-submit">Envoyer le message ✨</button><p class="form-note">* Champs obligatoires. Nous vous répondrons dans les meilleurs délais.</p></form></div></section>
</main>
<footer><div class="container"><div class="footer-content"><div class="footer-info"><a href="index.html"><h3>La Main Occulte</h3></a><p>Association de jonglerie</p><p>Mesnil-en-Ouche, Normandie</p></div><div class="footer-links"><h4>Liens rapides</h4><ul><li><a href="animations.html">Nos animations</a></li><li><a href="Agenda.html">Agenda</a></li><li><a href="galerie.html">Galerie</a></li><li><a href="contact.php">Adhésion & Contact</a></li></ul></div><div class="footer-social"><h4>Suivez-nous</h4><div class="social-icons"><a href="https://www.facebook.com/profile.php?id=61584136633572" target="_blank" class="social-icon" aria-label="Facebook"><i class="fa-brands fa-facebook"> facebook</i></a><a href="//www.tiktok.com/@la_main_occulte_" target="_blank" class="social-icon" aria-label="TikTok"><i class="fa-brands fa-tiktok"> tiktok</i></a><a href="https://www.instagram.com/" target="_blank" class="social-icon" aria-label="Instagram"><i class="fa-brands fa-instagram"> instagram</i></a></div></div></div><div class="footer-bottom"><p>&copy; 2026 La Main Occulte - Tous droits réservés <a href="mentions-legales.html" class="mentions">Mentions légales</a></p></div></div></footer>
<div class="menu-overlay" id="menuOverlay"></div>
<div class="mini-countdown">⏳ Samhain J-<span id="miniCountDays">00</span></div>
<script src="js/all.min.js"></script>
</body>
</html>