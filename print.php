<?php

include 'includes/top.php';
if (isset($_GET['id'])) {
    echo '<article id="mainContentPrint">';
    $couponID = htmlentities($_GET['id'], ENT_QUOTES, "UTF-8");
    // takes the values from the database for specific coupon and saves to an array
    $query = 'SELECT fldCouponName, fldValid, fldCouponDescription, fldCategory, fldBarcode FROM tblCoupons WHERE pmkCouponID = ?';
    $data = array($couponID);
    $results = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0, FALSE, FALSE);
// allocating values from array/database to specific variables for easier access later
    $couponName = $results[0]['fldCouponName'];
    $couponValid = $results[0]['fldValid'];
    $couponDesc = $results[0]['fldCouponDescription'];
    $couponCategory = $results[0]['fldCategory'];
    $couponBarcode = $results[0]['fldBarcode'];
    echo'<div id="couponPrint">';
    echo "<h1>" . $couponName . "</h1>";
    echo "<p> <u>Description:</u> " . $couponDesc . "</p>";
    echo '<p><u>Coupon Valid until:</u> ' . $couponValid . '</p>';
    echo '<img src="' . $couponBarcode . '" alt="Barcode">';
    echo '</div>';
    echo '</article>';
} else {
    header('Location: https://alongcha.w3.uvm.edu/cs148_develop/final/index.php');
}