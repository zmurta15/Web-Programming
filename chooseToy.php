<?php
    ini_set("session.save_path", "/home/unn_w21032320/sessionData");
    session_start();

    require_once('functions.php');
    echo makePageStart("ChooseToy", "css/homepage.css");
    echo makeHeader("Choose a Toy to Edit");
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

    if($logged) {
        try {
            /*Connect to the database*/
            $dbConn = getConnection();

            /*Query to select the details of all toys*/
            $sqlQuery = "SELECT toyID, toyName, description, catDesc, toyPrice
                        FROM NTL_toys
                        INNER JOIN NTL_category
                        ON NTL_category.catID = NTL_toys.catID
                        ORDER BY toyName";
            $queryResult = $dbConn->query($sqlQuery);
            
            /*Echo the list of toys available on the database */
            while ($rowObj = $queryResult->fetchObject()) {
                echo "<div class='toy'>\n
                <span class='name'>
                    <a href='editToy.php?toyID={$rowObj->toyID}'> {$rowObj->toyName}</a>
                </span>\n
                <p class='description'>{$rowObj->description}</p>\n
                <p class='categoryDesc'>{$rowObj->catDesc}</p>\n
                <p class='toyPrice'>£{$rowObj->toyPrice}</p\n
                </div>\n
                <hr>";
            }
        }
        catch (Exception $e){
            echo "<p>Query failed: ".$e->getMessage()."</p>\n";
        }
    }
    else {
        echo "You do not have permission to acess this page.\n";
        echo "<br><a href='homepage.php'>Back to HomePage</a>\n";
    }
    
    echo endMain();
    echo makeFooter("Made by Jose Murta");
    echo makePageEnd();
?>

