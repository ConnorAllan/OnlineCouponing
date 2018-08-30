<?php
include 'includes/top.php';
include 'includes/nav.php';
if (isset($_POST['save'])) {
    $data = array($email, 'false');
    $query = 'SELECT pmkEmail, pmkCouponID, fldCouponName, fldValid, fldCategory, fldCompanyName, fldCouponDescription '
            . 'FROM tblUserCoupon '
            . 'JOIN tblUsers ON fnkEmail = pmkEmail '
            . 'JOIN tblCoupons ON fnkCouponID = pmkCouponID '
            . 'JOIN tblCompany ON fnkCompanyID = pmkCompanyID '
            . 'WHERE pmkEmail = ? '
            . 'AND fldExpired = ? ';

    if (isset($_POST['filter'])) {
        if ($_POST['filter'] == 'ASC') {
            $asc = $_POST['filter'];
            $value = htmlentities($_POST['filter'], ENT_QUOTES, "UTF-8");
            $query .= 'ORDER BY fldCouponName asc';
        }
    }
    if (isset($_POST['filter'])) {
        if ($_POST['filter'] == 'DSC') {
            $dsc = $_POST['filter'];
            $value = htmlentities($_POST['filter'], ENT_QUOTES, "UTF-8");
            $query .= 'ORDER BY fldCouponName desc ';
        }
    }
    if (isset($_POST['filter'])) {
        if ($_POST['filter'] == 'AGE') {
            $age = $_POST['filter'];
            $value = htmlentities($_POST['filter'], ENT_QUOTES, "UTF-8");
            $query .= 'ORDER BY pmkCouponID ';
        }
    }

    $count = count($data)+1;
} else {

    $data = array($email, 'false');
    $query = 'SELECT pmkEmail, pmkCouponID, fldCouponName, fldValid, fldCategory, fldCompanyName, fldCouponDescription '
            . 'FROM tblUserCoupon '
            . 'JOIN tblUsers ON fnkEmail = pmkEmail '
            . 'JOIN tblCoupons ON fnkCouponID = pmkCouponID '
            . 'JOIN tblCompany ON fnkCompanyID = pmkCompanyID '
            . 'WHERE pmkEmail = ? AND fldExpired = ?';
    $count = 2;
}
?>
<article id="mainContent">
    <form class="favFilter" action="favorite.php" method="post">
        <fieldset>
            <legend>Sort By</legend>
            <?php
            if (isset($asc)) {
                echo '<input type = "radio" name = "filter" value = "ASC" checked> ASC';
            } else {
                echo '<input type = "radio" name = "filter" value = "ASC"> ASC';
            }
            if (isset($dsc)) {
                echo '<input type = "radio" name = "filter" value = "DSC" checked> DSC';
            } else {
                echo '<input type = "radio" name = "filter" value = "DSC"> DSC';
            }
            if (isset($age)) {
                echo '<input type = "radio" name = "filter" value = "AGE" checked> AGE';
            } else {
                echo '<input type = "radio" name = "filter" value = "AGE"> AGE';
            }
            ?>
        </fieldset>
        <input type="submit" name="Filter" value="Filter">
    </form>
    <article>

        <?php
        include('results.php');
        ?>

    </article>
</article>
