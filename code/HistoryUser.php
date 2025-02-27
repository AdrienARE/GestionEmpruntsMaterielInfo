<?php
$title = "Historique de l'utilisateur";
$erreur = "";

require_once("Controller/control-session.php");
require_once("Controller/UserController.php");
require_once("ControllerDAO/UserDAO.php");
require_once("view/head.view.php");
require_once("view/navbar.view.php");
ob_start();

?> <!-- Intro -->
    <div class="container">
        <div class="maincontent">
            <br> <br>
            <h2 class="thin"></h2>
            <p class="text-muted">

            </p>
            <!-- /Intro--><?php

if (isset($_SESSION['isAdmin_user']) && $_SESSION['isAdmin_user'] == 1 && isset($_GET['id_user_toDisplay']) || $_GET['id_user_toDisplay'] == $_SESSION['id_user'] && isset($_GET['id_user_toDisplay'])) {
    $tmpUsrCtrl = new UserController();
    if (!$tmpUsrCtrl->getUserDAO()->userExists($_GET['id_user_toDisplay'])) {
        ob_end_clean();
        header('Location: DashBoard.php');
    }
    try {
        $finalStatement = $tmpUsrCtrl->getUserDAO()->getHistory($_GET['id_user_toDisplay']);

        if (isset($finalStatement) && $finalStatement != null) {
            if ($finalStatement->rowCount() > 0) {
                while ($donnees = $finalStatement->fetch()) {
                    require "view/historyUser.view.php";

                }
            } else {
                echo "<p>L'utilisateur n'a emprunté aucun objet jusqu'à présent.</p>";
            }
        }

    } catch (Exception $e) {
        $erreur = "<p>" . $e->getMessage() . "</p>";
    }


} else {
    header('Location: DashBoard.php');
}

require_once("view/footer.view.php");

