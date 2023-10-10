<?php
    ini_set("session.save_path", "/home/unn_w21032320/sessionData");
    session_start();

    require_once('functions.php');
    echo makePageStart("HomePage", "css/homepage.css");
    echo makeHeader("HomePage");
    echo makeLoginForm();
    /*If the user is logged/administrator the menu displays a different title and different links to pages that only the admin can acess */
    $logged = check_login();
    if($logged) {
        echo makeNavMenu("Admin Menu", array("chooseToy.php" => "Toy List", "homepage.php" => "HomePage", "orderToysForm.php" => "Order a Toy","credits.php" => "Credits"));
    } 
    else {
        echo makeNavMenu("Menu", array("homepage.php" => "HomePage", "orderToysForm.php" => "Order a Toy", "credits.php" => "Credits"));
    }  
    echo startMain();
?>

<h1 class="ajax">Special offer</h1>
<aside id="offers"></aside>


<?php    
    echo endMain();
    echo makeFooter("Made by Jose Murta");
    echo makePageEndWithJS("js/offers.js");
?>