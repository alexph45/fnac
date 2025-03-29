<?php
require 'sqlconnect.php';
require 'adminco.php';
require 'inviteco.php';



$lgn = $_REQUEST["Login"];
$mdp = $_REQUEST["mdp"];

if (($lgn == $utilisateur_admin) and ($mdp == $motDePasse_admin)) {
    session_start();
    $_SESSION['user_type'] = 'admin';
    header("Location:backoffice.php");
    exit();
} elseif(($lgn == $utilisateur_invite) and ($mdp == $motDePasse_invite)) {
    session_start();
    $_SESSION['user_type'] = 'invite';
    header("Location: recherche.php");
    exit();
}else{
    echo 'impossible de se connecter';
}
?>
