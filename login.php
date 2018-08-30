<?php
session_start();
session_unset();
include "lib/constants.php";
include "lib/validation-functions.php";
include "lib/mailmessage.php";
$debug = false;
if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}
if ($debug) {
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
}
$email = htmlentities($_SESSION['email'], ENT_QUOTES, "UTF-8");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Online Couponing</title>
        <meta charset="utf-8">
        <meta name="author" content="Connor Allan">
        <meta name="description" content="Database for the UVM Registrar">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="css/custom.css" type="text/css" media="screen">

        <?php
        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // inlcude all libraries.
        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //$user = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
        print "<!-- require Database.php -->";

        require_once(BIN_PATH . '/Database.php');

        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // Set up database connection
        //
        // generally you dont need the admin on the web

        print "<!-- make Database connections -->";
        $dbUserName = 'crallan_reader';
        $whichPass = "r"; //flag for which one to use.
        $dbName = DATABASE_NAME;

        $thisDatabaseReader = new Database($dbUserName, $whichPass, $dbName);

        $dbUserName = 'crallan_writer';
        $whichPass = "w";
        $thisDatabaseWriter = new Database($dbUserName, $whichPass, $dbName);
        ?>

    </head>

    <!-- **********************     Body section      ********************** -->
    <?php
    print '<body id="' . $PATH_PARTS['filename'] . '">';
    if (isset($_POST['emailaddress'])) {
        $emailERROR = false;
        $email = htmlentities($_POST['emailaddress'], ENT_QUOTES, "UTF-8");
        if ($email == "") {
            $errorMailMsg = "Please enter your email address";
            $emailERROR = true;
        } elseif (!verifyEmail($email)) {
            $errorMailMsg = "Your email address appears to be incorrect";
            $emailERROR = true;
        }
    }
    if (isset($emailERROR)) {
        if ($emailERROR == false) {
            $pass = sha1(htmlentities($_POST['password'], ENT_QUOTES, "UTF-8"));
            $query = 'SELECT fldpassword FROM tblUsers WHERE pmkEmail= ?'; //Takes user's input for email to find matching password
            $data = array($email);
            $results = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0, FALSE, FALSE);
            $Qpass = $results[0]['fldpassword'];
            if ($pass == $Qpass) {
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $pass;
                header('Location: https://crallan.w3.uvm.edu/onlinecouponing/index.php');
            } else {
                $errorPass = 'Your email or password may be incorrect';
            }
        }
    }
    if (isset($_POST['Create'])) {
        $pass = sha1(htmlentities($_POST['password'], ENT_QUOTES, "UTF-8"));
        $name = htmlentities($_POST['name'], ENT_QUOTES, "UTF-8");
        $query = 'INSERT INTO tblUsers SET fldName= ? , fldPassword= ? , pmkEmail= ?'; //Takes user input and enters it into the database
        $data = array($name, $pass, $email);
        $thisDatabaseWriter->insert($query, $data);
        $query = 'SELECT fldpassword FROM tblUsers WHERE pmkEmail= ?'; //Takes user's input for email to find matching password
        $data = array($email);
        $results = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0, FALSE, FALSE);
        echo '<pre>';
        print_r($results);
        echo '</pre>';
        $Qpass = $results[0]['fldpassword'];
        if ($pass == $Qpass) {
            $mailed = sendMail($email, $name);
            header('Location: https://crallan.w3.uvm.edu/onlinecouponing/index.php');
        }
    }
    if (isset($_POST['Sign-Up'])) {
        $pass = htmlentities($_POST['password'], ENT_QUOTES, "UTF-8");
        print '<form action="login.php" method="post">';
        print 'Email:<br>';
        print '<input type="text" name="emailaddress" value="' . $email . '"><br>';
        print 'Password:<br>';
        print '<input type="password" name="password" value="' . $pass . '"><br>';
        print 'Name:<br>';
        print '<input type="text" name="name" placeholder="John Doe"><br><br>';
        print '<input type="submit" name="Create" value="Create">';
        print '</form>';
    } else {
        print '<form action="login.php" method="post">';
        if (isset($errorMailMsg)) {
            print '<p class="error">' . $errorMailMsg . '</p>';
        }
        if (isset($errorPass)) {
            print '<p class="error">' . $errorPass . '</p>';
        }
        print 'Email:<br>';
        if (isset($email)) {
            print '<input type="text" name="emailaddress" value ="' . $email . '"><br>';
        } else {
            print '<input type="text" name="emailaddress" placeholder="you@mail.net"><br>';
        }
        // print '<p class="error">' . $errorPassMsg . '</p>';
        print 'Password:<br>';
        print '<input type="password" name="password" placeholder="*******"><br><br>';
        print '<input type="submit" name="Login" value="Login">';
        print '<input type="submit" name="Sign-Up" value="Sign-Up">';
        print '</form>';
    }
