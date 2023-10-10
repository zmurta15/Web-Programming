<?php
    ini_set("session.save_path", "/home/unn_w21032320/sessionData");
    session_start();

    require_once('functions.php');
    echo makePageStart("EditToy", "css/homepage.css");
    echo makeHeader("Editing Toy Process");
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
            /*Connect to the database */
            $dbConn = getConnection();

            /*Receive the toyID */
            $toyID = filter_has_var(INPUT_GET, 'toyID') ? $_GET['toyID']: null;
            if(empty($toyID)) {
                header('Location: chooseToy.php');
            }

            /*Query the tabase table to retrieve the details of the toy */
            $sqlQuery = "SELECT toyID, toyName, description, manID, catID, toyPrice
                        FROM NTL_toys
                        WHERE toyID = :toyID";
            $stmt = $dbConn->prepare($sqlQuery);
            $stmt->execute(array(':toyID' => $toyID));         
            $rowObj = $stmt->fetchObject();

            /*Start form to update the details of the toy */
            echo "<h3>Update $rowObj->toyName</h3>
                <form id='UpdateMovie' action='updateToy.php' method='get'>
                    <p>ToyID<input type='text' name='toyID' value='{$rowObj->toyID}' readonly>\n</p>
                    <p>Toy Name<input type='text' name='toyName' value='{$rowObj->toyName}'>\n</p>
                    <p>Description <br/><textarea name='description' cols='100' rows='5'>{$rowObj->description}</textarea>\n</p>";
            /*Query to select the details of the manufacters*/
            $sqlMan = "SELECT manID, manName from NTL_manufacturer ORDER BY manName";
            $rsMan = $dbConn->query($sqlMan);
            echo "<p>Manufacter <select name='manID'>";
            /*Loop to create the options of manufacters of the toy*/
            while($manRecord = $rsMan->fetchObject()) {
                if($rowObj->manID == $manRecord->manID) {
                    echo "<option value='{$manRecord->manID}' selected>
                    {$manRecord->manName}</option>";
                }
                else {
                    echo "<option value='{$manRecord->manID}'>{$manRecord->manName}</option>";
                }
            }
            /*Query to select the details of the categories*/
            $sqlCat = "SELECT catID, catDesc from NTL_category ORDER BY catDesc";
            $rsCat = $dbConn->query($sqlCat);
            echo "</select></p>
                <p>Category <select name='catID'>";
            /*Loop to create the options of categories of the toy*/
            while($catRecord = $rsCat->fetchObject()) {
                if($rowObj->catID == $catRecord->catID) {
                    echo "<option value='{$catRecord->catID}' selected>
                    {$catRecord->catDesc}</option>";
                }
                else {
                    echo "<option value='{$catRecord->catID}'>{$catRecord->catDesc}</option>";
                }
            }
            echo "</select></p>
                    <p>Toy Price<input type='text' name='toyPrice' value='{$rowObj->toyPrice}'>\n</p>
                        <input type='submit' value='Update Toy'>
                </form>";

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