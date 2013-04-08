<?php
// Connect to DB
include 'init.php';

if (isset($_POST['username'], $_POST['p'])) {

    sec_session_start();

    $v = $_POST['username'];
    $password = $_POST['p']; // The hashed password.

    $atempts_login = login($v, $password, $bdd);
    switch ($atempts_login) {
        case "locked":
            $clientMessage = "Trop de connexions ratées en si peu de temps, c'est louche ! Revenez plus tard...";
            break;
        case "failed":
            $clientMessage = "Mauvais mot de passe, attention. Si cela se reproduit trop souvent, vous serez bloqué...";
            break;
        case "no_user":
            $clientMessage = "On a bien cherché, mais on n'a trouvé personne qui s'appelait comme ça. Vous êtes sûr de vous ?";
            break;
    }
    if ($atempts_login == "ok") {
        // Login success
        header('Location: ./?page=wishlist');
    }
}
?>