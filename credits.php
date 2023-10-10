<?php
    ini_set("session.save_path", "/home/unn_w21032320/sessionData");
    session_start();

    require_once('functions.php');
    echo makePageStart("HomePage", "css/homepage.css");
    echo makeHeader("HomePage");
    echo makeLoginForm();
    $logged = check_login();
     /*If the user is logged/administrator the menu displays a different title and different links to pages that only the admin can acess */
    if($logged) {
        echo makeNavMenu("Admin Menu", array("chooseToy.php" => "Toy List", "homepage.php" => "HomePage", "orderToysForm.php" => "Order a Toy","credits.php" => "Credits"));
    } 
    else {
        echo makeNavMenu("Menu", array("homepage.php" => "HomePage", "orderToysForm.php" => "Order a Toy", "credits.php" => "Credits"));
    } 
    echo startMain();
?>

<div class="credits">
    <h3>This assessment was made by Jose Murta </br>
    Student ID: W21032320</h3>
    <h4> Credits: </h4>
    <ul>
        <li>Module Content</li>
        <li>W3Schools (2022), Refsnes Data. Available at <a href="https://www.w3schools.com/">https://www.w3schools.com/</a> (Acessed: 05 January 2022)</li>
    </ul>

</div>

<?php    
    echo endMain();
    echo makeFooter("Made by Jose Murta");
?>