<?php
    /*Function used to connect to the database*/
    function getConnection () {
        try {
            $connection = new PDO("mysql:host=localhost;
                        dbname=unn_w21032320",
                        "unn_w21032320", "rv6clc8jt3");

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    return $connection;
        }
        catch(Exception $e) {
            throw new Exception("Connection error "
		    .$e->getMessage(), 0, $e);

        }
    }

    /*Function to set user session */
    function set_session($key, $value) {
        $_SESSION[$key] = $value;
        return true;
    }

    /*Function to get the user session */
    function get_session($key) {
        $value = false;
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
        }
        return $value;
    }

    /*Function to check if a user is logged in */
    function check_login() {
        if(get_session('logged-in')) {
            return true;
        }
        else {
            return false;
        }
    }

    /*Function to make the login form if the user is logged out, or a button to logout if the user is logged in */
    function makeLoginForm() {
        if(check_login()) {
            $loginForm = <<<LOGOUT
                <div class="logClass">
                    <p>If you want to log out, please click the button bellow</p>
                    <form action="logout.php" >
                        <input type="submit" value="Logout" />
                    </form>
                </div>
LOGOUT;
        }
        else {
            $loginForm = <<<LOGIN
            <form method="post" action="login.php" class="logClass">
                Username <input type="text" name="username">
                Password <input type="password" name="password">
                <input type="submit" value="Login">
            </form>
LOGIN;
        } 
        return $loginForm;
    }

    /*Function to make the the start of the page with the HTML core tags */
    function makePageStart($startText, $cssFileName) {
        $pageStartContent = <<<PAGESTART
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>$startText</title> 
            <link href=$cssFileName rel="stylesheet" type="text/css">
        </head>
        <body>
    <div id="gridContainer">
PAGESTART;
        $pageStartContent .="\n";
        return $pageStartContent;
    }

    /*Function to make the header of the page */
    function makeHeader($headerText){
        $headContent = <<<HEAD
            <header>
                <h1>$headerText</h1>
            </header>
HEAD;
        $headContent .="\n";
        return $headContent;
    }

    /*Function to make the navigation menu of the page */
    function makeNavMenu($navMenuHeader, $links) {
        $navHeaderLowerCase = strtolower($navMenuHeader);
        $output ="";
        foreach($links as $key=>$value) {
            $output .= "<li><a href='$key'>$value</a></li>";
        }
        $navMenuContent = <<<NAVMENU
            <nav id=$navHeaderLowerCase>
                <h2>$navMenuHeader</h2>
                <ul>
                    $output
                </ul>	
            </nav>
NAVMENU;
        $navMenuContent .= "\n";
        return $navMenuContent;
    
    
    }
    
    /*Function to start the main tag of the page */
    function startMain() {
        return "<main>\n";
    }
    
    /*Function to close the main tag of the page */
    function endMain() {
        return "</main>\n";
    }
    
    /*Function to make the footer of the page */
    function makeFooter($footerText) {
        $footContent = <<<FOOT
            <footer>
                <p>$footerText</p>
            </footer>
FOOT;
        $footContent .="\n";
        $footContent .= "</div>\n";
        return $footContent;
    }
    
    /*Function to close the HTML core tags of the page */
    function makePageEnd() {
        return "</body>\n</html>";
    }

    /*Function to close the HTML core tags of the page with option to include a JavaScript file*/
    function makePageEndWithJS($jsfile) {
        $pageEnd = <<<END
            <script type="text/javascript" src=$jsfile></script>\n
            </body>\n
            </html>

END;
    return $pageEnd;
    }

?>