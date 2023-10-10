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
        list($input, $errors) = validateUpdate();
        if ($errors) {
            echo show_errors($errors);
        } 
        else {
            echo processUpdate($input);
        }

    }
    else {
        echo "You do not have permission to acess this page.\n";
        echo "<br><a href='homepage.php'>Back to HomePage</a>\n";
    }

    

    /*Function to validate and verify the values inserted in the form to change the details of the selected toy */
    function validateUpdate() {
        $input = array();
        $errors = array();

        $input['toyID'] = filter_has_var(INPUT_GET, 'toyID') ? $_GET['toyID']: null;
        if(empty($input['toyID'])) {
            header('Location: chooseToy.php');
        }
        $tID = $input['toyID'];

        $input['toyName'] = filter_has_var(INPUT_GET, 'toyName') ? $_GET['toyName']: null;
        $input['toyName'] = trim($input['toyName']);
        
        if(empty($input['toyName'])) {
            $errors[] = "<p>Please enter a name for the toy. Do not leave it blank.\n</p>";
        }
    
        $input['description'] = filter_has_var(INPUT_GET, 'description') ? $_GET['description']: null;
        $input['description'] = trim($input['description']);
        if(empty($input['description'])) {
            $errors[] = "<p>Please enter a description for the toy. Do not leave it blank.\n</p>";
        }

        $input['manID'] = filter_has_var(INPUT_GET, 'manID') ? $_GET['manID']: null;

        $input['catID'] = filter_has_var(INPUT_GET, 'catID') ? $_GET['catID']: null;

        $input['toyPrice'] = filter_has_var(INPUT_GET, 'toyPrice') ? $_GET['toyPrice']: null;
        $input['toyPrice'] = trim($input['toyPrice']);
        if(empty($input['toyPrice'])) {
            $errors[] = "<p>Please enter a price for the toy. Do not leave it blank.\n</p>";
        }
        if(!filter_var($input['toyPrice'], FILTER_VALIDATE_FLOAT)) {
            $errors[] = "<p>Please enter a number value for price of the toy.\n</p>";
        }

        return array($input, $errors);
    }

    /*Function to show errors in case they have occured */
    function show_errors($errors) {
        $output ='';
        foreach($errors as $error ) {
            $output .= $error;
        }
        return $output;
    }

    /*Function to update the details of the toy */
    function processUpdate($input) {
        try {
            //Connect to the database
            $dbConn = getConnection();

            /*Query to update the values of the selected toy */
            $sqlUpdate = "UPDATE NTL_toys SET
                        toyName = :toyName,
                        description = :description,
                        manID = :manID,
                        catID = :catID,
                        toyPrice = :toyPrice
                        WHERE toyID = :toyID";

            $stmt = $dbConn->prepare($sqlUpdate); 
            $stmt->execute(array(':toyName' => $input['toyName'], 
                ':description' => $input['description'],
                ':manID' => $input['manID'], 
                ':catID' => $input['catID'],
                ':toyPrice' => $input['toyPrice'],
                ':toyID' => $input['toyID']));

            echo "Update successful";
            echo "<br><a href='chooseToy.php'>Back to the List of Toys</a>\n";
        }
        catch (Exception $e) {
            echo "<p>Query failed: ".$e->getMessage()."</p>\n";
        }
    }

    echo endMain();
    echo makeFooter("Made by Jose Murta");
    echo makePageEnd();

?>