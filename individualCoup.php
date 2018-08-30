<?php

include 'includes/top.php';
include 'includes/nav.php';
if (isset($_GET['id'])) {
    echo '<article id="mainContent">';
    $couponID = htmlentities($_GET['id'], ENT_QUOTES, "UTF-8");
// if button below is submitted for favoriting the coupon it is written to the database
    if (isset($_POST['btnFav'])) {
        if (isset($_POST['favorited'])) {
            $query = 'INSERT INTO tblUserCoupon SET fnkCouponID = ?, fnkEmail = ?';
            $data = array($couponID, $email);
            $thisDatabaseWriter->insert($query, $data);
        } else {
            $query = 'DELETE FROM tblUserCoupon WHERE fnkCouponID = ? AND fnkEmail = ?';
            $data = array($couponID, $email);
            $thisDatabaseWriter->insert($query, $data, 1, 1);
        }
    }
    $query = 'SELECT pmkKey FROM tblUserCoupon WHERE fnkCouponID = ? AND fnkEmail = ?';
    $data = array($couponID, $email);
    $results = $thisDatabaseReader->select($query, $data, 1, 1, 0, 0, FALSE, FALSE);
    if (isset($results[0]['pmkKey'])) {
        $favExists = TRUE;
    }

// takes the values from the database for specific coupon and saves to an array
    $query = 'SELECT fldCouponName, fldValid, fldCouponDescription, fldCategory, '
            . 'fldCompanyName, pmkCouponID '
            . 'FROM tblCoupons JOIN tblCompany ON pmkCompanyID = fnkCompanyID WHERE pmkCouponID = ?';
    $data = array($couponID);
    $results = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0, FALSE, FALSE);

// allocating values from array/database to specific variables for easier access later
    $couponName = $results[0]['fldCouponName'];
    $couponValid = $results[0]['fldValid'];
    $couponDesc = $results[0]['fldCouponDescription'];
    $couponCategory = $results[0]['fldCategory'];
    $couponCompany = $results[0]['fldCompanyName'];

    echo'<div id="coupon" class="indie">';
// print coupon name in heading
    echo '<h1>' . $couponCompany . '</h1>';
    echo '<p><strong>' . $couponName . '</strong></p>';
    echo '<p>Description: ' . $couponDesc . '</p>';
    echo '<p>Valid Until: ' . $couponValid . '</p>';
    echo '<p><a href="print.php?id=' . $couponID . '" target="_blank" class="print">Print</a></p>';
// links to print page 
    echo '</div>';
// form to ask user if they want to make this coupon a favorite
    echo '<form action="individualCoup.php?id="' . $couponID . '" method="POST">';

    //If statement needs to be written, along with adding company to favorites or not!!
    if (isset($favExists)) {
        echo '<input type="checkbox" name="favorited" value="0" checked>Favorite';
    } else {
        echo '<input type="checkbox" name="favorited" value="1">Favorite';
    }
    echo '<input type="submit" name="btnFav" value="continue">';
    echo '</form>';
    echo '</article>';
} else {
    header('Location: https://alongcha.w3.uvm.edu/cs148_develop/final/index.php');
}