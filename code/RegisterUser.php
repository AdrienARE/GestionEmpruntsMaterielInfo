<?php
$title = "Creer un utilisateur";
$erreur = "";
require_once("Controller/control-session.php");
require_once("Controller/DataBase.php");
require_once("Model/User.php");
require_once("Controller/UserController.php");
ob_start();

/* catch les erreurs */
if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1) {


    //on include inscriptions.view
    require_once('view/inscription.view.php');

    /* si l'admin décide de créer un utilisateur*/
    if (isset($_POST['submitInscription'])) {
        try {
            $userController = new UserController($_SESSION['id_user']);

            $postAdmin = 0;
            if (isset($_POST['administrateur']) && $_POST['administrateur'] != null)
                $postAdmin = 1;

            if (isset($_POST['matricule']) && isset($_POST['password']) && isset($_POST['passwordrepeat']) && isset($_POST['name']) && isset($_POST['lastname'])
                && isset($_POST['phone'])) {

                if ($userController->createUser($_POST['matricule'], $_POST['password'], $_POST['passwordrepeat'], $_POST['email'], $_POST['name'], $_POST['lastname'], $_POST['phone'], $postAdmin) == true) {
                    ob_end_clean();
                    echo "<p> Creation Compte Reussie <p/>";

                    echo "<p> Vous allez etre rediriges dans 2 secondes.. <p/>";

                    header("refresh:2;url=DashBoard.php");
                }
            }

        } catch (Exception $e) {
            ob_end_clean();
            header("refresh:2;url=RegisterUser.php?createUser=");

            echo $e->getMessage();
            echo "<p> Vous allez etre rediriges dans 2 secondes.. <p/>";


        }

    }

} else {
    ob_end_clean();

    header('Location:DashBoard.php');

}
