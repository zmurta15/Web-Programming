<?php
    ini_set("session.save_path", "/home/unn_w21032320/sessionData");
    session_start();

    list($input, $errors) = validate_logon();
    if ($errors) {
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
        echo show_errors($errors);
        echo "<a href='homepage.php'>Back to HomePage</a>\n";
        echo endMain();
        echo makeFooter("Made by Jose Murta");
        echo makePageEnd();
    } 
    else {
        set_session('logged-in', 'true');
    }

    /*Function to validate and verify the login details */
    function validate_logon() {
        $input = array();
        $errors = array();

        $input['userName'] = filter_has_var(INPUT_POST, 'username') ? $_POST['username']: null;
        $input['userName'] = trim($input['userName']);
        if(empty($input['userName'])) {
			$errors[] = "<p>Please enter an username\n</p>";
		}
        
        $input['password'] = filter_has_var(INPUT_POST, 'password') ? $_POST['password']: null;
        $input['password'] = trim($input['password']);
        if(empty($input['password'])) {
			$errors[] = "<p>Please enter a password\n</p>";
		}
        
        try {
            require_once("functions.php");

            /*Connect to the database */
            $dbConn = getConnection();

            /*Query to select the passwordHash of the user stored in the database */
            $querySQL = "SELECT passwordHash FROM NTL_users 
                        WHERE username = :username";
            
            $stmt = $dbConn->prepare($querySQL);
            $stmt->execute(array(':username' => $input['userName']));

            $user = $stmt->fetchObject();
            if($user) {
                $passwordHash = $user->passwordHash;
                if(password_verify($input['password'], $passwordHash)) {
                    header('Location: homepage.php');
                }
                else {
                    if(!empty($input['password'])) {
                        $errors[] = "<p>The password is incorrect.\n</p>";
                    } 
                }
            }
            else {
                if(!empty($input['password'])) {
                    $errors[] = "<p>Please enter an existing Username.\n</p>";
                }
                
            }
        }
        catch (Exception $e) {
            echo "There was a problem: " . $e->getMessage();
        }
        return  array($input, $errors);
    }

    /*Function to show errors in case they have occured */
    function show_errors($errors) {
		$output ='';
		foreach($errors as $error ) {
			$output .= $error;
        }
		return $output;
	}

?>
