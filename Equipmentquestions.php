<?php
include "top.php";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.
$debug = false;
if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}
if ($debug) {
    print "<p>DEBUG MODE IS ON</p>";
}
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf;
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form
$email = "";
$firstName = "";
$comments = "";
$position = "Teacher";
$Apple_TV = true;    // checked
$Mac_Book = false; // not checked
$iPad = false;
$Desktop = false;
$Projector = false;
$Room = "100";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$emailERROR = false;
$firstNameERROR = false;
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

$dataRecord = array();

$mailed = false;
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2a Security
    //
    if (!securityCheck(true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg .= "Security breach detected and reported</p>";
        die($msg);
    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Sanitize (clean) data
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.


    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;

    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;

    $comments = htmlentities($_POST["txtComments"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $comments;


    $position = htmlentities($_POST["radPosition"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $position;

    if (isset($_POST["chkAppleTV"])) {
        $Apple_TV = true;
    } else {
        $Apple_TV = false;
    }
    $dataRecord[] = $Apple_TV;

    if (isset($_POST["chkMacBook"])) {
        $Mac_Book = true;
    } else {
        $Mac_Book = false;
    }
    $dataRecord[] = $Mac_Book;

    if (isset($_POST["chkDesktop"])) {
        $Desktop = true;
    } else {
        $Desktop = false;
    }
    $dataRecord[] = $Desktop;

    if (isset($_POST["chkiPad"])) {
        $iPad = true;
    } else {
        $iPad = false;
    }
    $dataRecord[] = $iPad;

    if (isset($_POST["chkProjector"])) {
        $Projector = true;
    } else {
        $Projector = false;
    }
    $dataRecord[] = $Projector;

    $Room = htmlentities($_POST["RoomNum"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $Room;
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c Validation
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.

    if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have extra character.";
        $firstNameERROR = true;
    }

    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $emailERROR = true;
    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //
    if (!$errorMsg) {
        if ($debug) {
            print "<p>Form is valid</p>";
        }
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
         // SECTION: 2e Save Data
        //
        // This block saves the data to a CSV file.
        print "<p>$dataRecord[0]<p>";

        $fileExt = ".csv";
        $myFileName = "data/registration";
        $filename = $myFileName . $fileExt;
        if ($debug) {
            print "\n\n<p>filename is " . $filename;
        }
        // now we just open the file for append
        $file = fopen($filename, 'a');
        // write the forms informations
        fputcsv($file, $dataRecord);
        // close the file
        fclose($file);

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        //  SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).

        $message = '<h2>Thank You</h2>';


        //foreach ($_POST as $key => $value) {


        $message .= "<p>Thank you for completing this quick survey. </p>";

        print $message;

        /*      $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));



          foreach ($camelCase as $one) {
          $message .= $one . " ";
          }
          $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
          } */


        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built in section 2f.
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "Callan@fwsu.org";
        $from = "Fletcher IT <noreply@fwsu.org>";
        // subject of mail should make sense to your form
        $todaysDate = strftime("%x");
        $subject = "Email List Signup " . $todaysDate;
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    } // end form is valid
} // ends if form was submitted.
//#############################################################################
//
// SECTION 3 Display Form
//
?>

<article id="main">

    <?php
//####################################
//
    // SECTION 3a.
//
    //
//
//
// If its the first time coming to the form or there are errors we are going
// to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
        print "<h1>Your Request has ";

        if (!$mailed) {
            print "not ";
        }

        print "been processed</h1>";

        print "<p>A copy of this message has ";
        if (!$mailed) {
            print "not ";
        }
        print "been sent</p>";
        print "<p>To: " . $email . "</p>";
        print "<p>Mail Message:</p>";

        print $message;
    } else {
//
//
//
//
//
//####################################
//
// SECTION 3b Error Messages

        if ($errorMsg) {
            print '<div id="errors">';
            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }

//
//####################################
//
// SECTION 3c html Form
//
        /* Display the HTML form. note that the action is to this same page. $phpSelf
          is defined in top.php








         */
        ?>

        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmRegister">

            <fieldset class="wrapper">
                <legend>Equipment Survey</legend>
                <p>The information you provide will greatly improve the quality of service we are able to provide. </p>

                <fieldset class="wrapperTwo">
                    <legend>Please complete the following</legend>

                    <fieldset class="contact">
                        <legend>Valid Employee Information</legend>

                        <label for="txtFirstName" class="required">First Name
                            <input type="text" id="txtFirstName" name="txtFirstName"
                                   value="<?php print $firstName; ?>"
                                   tabindex="100" maxlength="45" placeholder="Enter your first name"
                                   <?php
                                   if ($firstNameERROR) {
                                       print 'class="mistake"';
                                   }
                                   ?>
                                   onfocus="this.select()"
                                   autofocus>
                        </label>
                        <br>
                        <label for="txtEmail" class="required">Email
                            <input type="text" id="txtEmail" name="txtEmail"
                                   value="<?php print $email; ?>"
                                   tabindex="120" maxlength="45" placeholder="Enter a valid email address"

                                   <?php
                                   if ($emailERROR) {
                                       print 'class="mistake"';
                                   }
                                   ?>
                                   onfocus="this.select()" >
                        </label>
                    </fieldset> <!-- ends contact -->
                    <fieldset class="radio">
                        <legend>What is your position?</legend>
                        <label><input type="radio" 
                                      id="radPositionTeacher" 
                                      name="radPosition" 
                                      value="Teacher"
                                      <?php if ($position == "Teacher") print 'checked' ?>
                                      tabindex="330">Teacher</label>
                        <label><input type="radio" 
                                      id="radPositionSupportStaff" 
                                      name="radPosition" 
                                      value="SupportStaff"
                                      <?php if ($position == "SupportStaff") print 'checked' ?>
                                      tabindex="340">Support Staff</label>
                        <label><input type="radio" 
                                      id="radPositionParaEducator" 
                                      name="radPosition" 
                                      value="ParaEducator"
                                      <?php if ($position == "ParaEducator") print 'checked' ?>
                                      tabindex="350">Para-Educator</label>
                        <label><input type="radio" 
                                      id="radAdministration" 
                                      name="radPosition" 
                                      value="Administration"
                                      <?php if ($position == "Administration") print 'checked' ?>
                                      tabindex="350">Administration</label>
                    </fieldset>
                    <fieldset class="checkbox">
                        <legend>Technology Assigned to you (check all that apply):</legend>
                        <label><input type="checkbox" 
                                      id="chkAppleTV" 
                                      name="chkAppleTV" 
                                      value="AppleTV"
                                      <?php if ($AppleTV) print ' checked '; ?>
                                      tabindex="420"> Apple TV</label>

                        <label><input type="checkbox" 
                                      id="chkMacBook" 
                                      name="chkMacBook" 
                                      value="Mac Book"
                                      <?php if ($Mac_Book) print ' checked '; ?>
                                      tabindex="430"> Mac Book</label>

                        <label><input type="checkbox" 
                                      id="chkiPad" 
                                      name="chkiPad" 
                                      value="iPad"
                                      <?php if ($iPad) print ' checked '; ?>
                                      tabindex="430"> iPad</label>

                        <label><input type="checkbox" 
                                      id="chkDesktop" 
                                      name="chkDesktop" 
                                      value="Desktop"
                                      <?php if ($Desktop) print ' checked '; ?>
                                      tabindex="430"> Desktop</label>

                        <label><input type="checkbox" 
                                      id="chkProjector" 
                                      name="chkProjector" 
                                      value="Projector"
                                      <?php if ($Projector) print ' checked '; ?>
                                      tabindex="430"> Projector</label>
                    </fieldset>
                    <fieldset  class="listbox">	
                        <label for="RoomNum">Room Number</label>
                        <select id="RoomNum" 
                                name="RoomNum" 
                                tabindex="520" >
                            <option <?php if ($Room == "100") print " selected "; ?>
                                value="Room 100">100</option>

                            <option <?php if ($Room == "101") print " selected "; ?>
                                value="Room 101" >101</option>

                            <option <?php if ($Room == "102") print " selected "; ?>
                                value="Room 102" >102</option>

                            <option <?php if ($Room == "103") print " selected "; ?>
                                value="Room 103">103</option>

                            <option <?php if ($Room == "104") print " selected "; ?>
                                value="Room 104">104</option>

                            <option <?php if ($Room == "105") print " selected "; ?>
                                value="Room 105" >105</option>

                            <option <?php if ($Room == "106") print " selected "; ?>
                                value="Room 106">106</option>

                            <option <?php if ($Room == "107") print " selected "; ?>
                                value="Room 107" >107</option>

                            <option <?php if ($Room == "108") print " selected "; ?>
                                value="Room 108" >108</option>

                            <option <?php if ($Room == "109") print " selected "; ?>
                                value="Room 109">109</option>

                            <option <?php if ($Room == "110") print " selected "; ?>
                                value="Room 110">110</option>

                            <option <?php if ($Room == "111") print " selected "; ?>
                                value="Room 111" >111</option>

                            <option <?php if ($Room == "112") print " selected "; ?>
                                value="Room 112" >112</option>

                            <option <?php if ($Room == "113") print " selected "; ?>
                                value="Room 113" >113</option>

                            <option <?php if ($Room == "114") print " selected "; ?>
                                value="Room 114">114</option>

                            <option <?php if ($Room == "115") print " selected "; ?>
                                value="Room 115">115</option>

                            <option <?php if ($Room == "116") print " selected "; ?>
                                value="Room 116" >116</option>

                            <option <?php if ($Room == "117") print " selected "; ?>
                                value="Room 117">117</option>

                            <option <?php if ($Room == "118") print " selected "; ?>
                                value="Room 118" >118</option>

                            <option <?php if ($Room == "119") print " selected "; ?>
                                value="Room 119" >119</option>

                            <option <?php if ($Room == "120") print " selected "; ?>
                                value="Room 120">120</option>
                        </select>
                    </fieldset>
                </fieldset> <!-- ends wrapper Two -->

                <fieldset class="buttons">
                    <legend></legend>
                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Register" tabindex="900" class="button">
                </fieldset> <!-- ends buttons -->

            </fieldset> <!-- Ends Wrapper -->
        </form>

    <?php }
    ?>

</article>

<?php include "footer.php"; ?>

</body>
</html>