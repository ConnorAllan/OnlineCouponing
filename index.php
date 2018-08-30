<?php

include 'includes/top.php';
include 'includes/nav.php';
if (isset($_POST['search'])) {
    $search = htmlentities($_POST['search'], ENT_QUOTES, "UTF-8");
    $data = explode(" ", $search);
    $count = count($data);
    for ($i = 0; $i < $count; $i++) {
        $data[$i] = '%' . $data[$i] . '%';
    }
    array_unshift($data, $search);
    array_unshift($data, 'false');
    $count = count($data);
    $query = 'SELECT fldCouponName, fldValid, fldCouponDescription, fldCategory, '
            . 'fldCompanyName, pmkCouponID '
            . 'FROM tblCoupons JOIN tblCompany ON pmkCompanyID = fnkCompanyID '
            . 'WHERE fldExpired = ? And fldCompanyName = ? OR fldCategory LIKE ? ';
    for ($i = 1; $i < $count-2; $i++) {
        $query .= 'OR fldCategory LIKE ? ';
    }
}
echo '<!-- Search Section -->';
echo '<article id="mainContent">';
echo '<form action="index.php" method="post">';
if (isset($search)) {
    echo '<input list="search" name="search" value="' . $search . '">';
} else {
    echo '<input list="search" name="search" placeholder="Search for coupons" onfocus="this.select()">';
}
echo '<datalist id="search">';
echo '<option value="Technology">';
echo '<option value="Clothing">';
echo '<option value="Food">';
echo '<option value="Music Art">';
echo '<option value="Grocery">';
echo '</datalist>';
echo '<input type="submit" id="btnSearch" name="btnSearch" value="Search" tabindex="9" class="button">';
echo '</form>';
if (isset($_POST['search'])) {
    include 'results.php';
}
echo '</article>';
