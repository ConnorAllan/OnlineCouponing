<?php
include 'includes/top.php';
include 'includes/nav.php';

$query = 'SELECT fldName, fldGender, fldPassword, fldNewsletter FROM tblUsers WHERE pmkEmail = ?';
$data = array($email);
$results = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0, FALSE, FALSE);
$name = htmlentities($results[0]['fldName'], ENT_QUOTES, "UTF-8");
$gender = htmlentities($results[0]['fldGender'], ENT_QUOTES, "UTF-8");
$newsletter = htmlentities($results[0]['fldNewsletter'], ENT_QUOTES, "UTF-8");
$password = htmlentities($results[0]['fldPassword'], ENT_QUOTES, "UTF-8");
if (isset($_POST['save'])) {
    if (isset($_POST['newPassword']) and $_POST['newPassword'] != '') {
        if (isset($_POST['oldPassword']) and $_POST['oldPassword'] != '') {
            $oldPass = sha1(htmlentities($_POST['oldPassword'], ENT_QUOTES, "UTF-8"));
            $newPass = sha1(htmlentities($_POST['newPassword'], ENT_QUOTES, "UTF-8"));
            if ($oldPass == $password) {
                $data = array($newPass, $email);
                $query = 'UPDATE tblUsers SET fldPassword = ? WHERE pmkEmail = ?';
                $thisDatabaseWriter->insert($query, $data, 1);
            }
        }
    }
    if (isset($_POST['gender'])) {
        $gender = htmlentities($_POST['gender'], ENT_QUOTES, "UTF-8");
        $data = array($gender, $email);
        $query = 'UPDATE tblUsers SET fldGender = ? WHERE pmkEmail = ?';
        $thisDatabaseWriter->insert($query, $data, 1);
    }
    if (isset($_POST['newsLetter'])) {
        $newsletter = htmlentities($_POST['newsLetter'], ENT_QUOTES, "UTF-8");
        $data = array($newsletter, $email);
        $query = 'UPDATE tblUsers SET fldNewsletter = ? WHERE pmkEmail = ?';
        $thisDatabaseWriter->insert($query, $data, 1);
    }
}
?>
<article id="mainContent">
    <!-- Begin Form -->
    <form class="account" action="account.php" method="post">
        <div class="name"><?php echo '<h1>' . $name . '</h1>'; ?></div>
        <fieldset class="password">
            <legend>Password</legend>
            <p>Old Password</p>
            <input type="password" name="oldPassword" value="">
            <p>New Password</p>
            <input type="password" name="newPassword" value="">
        </fieldset>
        <fieldset class="gender">
            <legend>Gender</legend>
            <?php
            echo '<select name="gender">';
            if ($gender == 'Male') {
                echo '<option value = "Male" selected> Male </option>';
            } else {
                echo '<option value = "Male"> Male </option>';
            }
            if ($gender == 'Female') {
                echo '<option value = "Female" selected> Female </option>';
            } else {
                echo '<option value = "Female"> Female </option>';
            }
            if ($gender == 'Other') {
                echo '<option value = "Other" selected> Other </option>';
            } else {
                echo '<option value = "Other"> Other </option>';
            }
            echo '</select>';
            ?>
        </fieldset>
        <fieldset class="newsLetter">
            <legend>Newsletter</legend>
            <?php
            if ($newsletter == 'Yes') {
                echo '<input type = "radio" name = "newsLetter" value = "Yes" checked> Yes';
            } else {
                echo '<input type = "radio" name = "newsLetter" value = "Yes"> Yes';
            }
            if ($newsletter == 'No') {
                echo '<input type = "radio" name = "newsLetter" value = "No" checked> No';
            } else {
                echo '<input type = "radio" name = "newsLetter" value = "No"> No';
            }
            ?>
        </fieldset>
        <input type="submit" name="save" value="save">
    </form>
</article>