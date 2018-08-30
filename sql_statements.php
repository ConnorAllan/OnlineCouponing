<?php
include 'includes/top.php';
?>
<pre>
    Login.php   
SELECT pmkEmail, fldPassword
FROM tblUsers
WHERE pmkEmail = ?


    Favorite.php (getting the favorited companies) 
SELECT tblCompanies.pmkCompanyID, tblCompanies.fldCompanyName, tblCompanies.fldCompanyDescription,
       tblFavorites.fnkCompanyID, tblFavorites.fnkEmail,
       tblUsers.pmkEmail
FROM tblUsers
JOIN tblFavorites ON tblUsers.pmkEmail = tblFavorites.fnkEmail
JOIN tblCompanies ON tblFavorites.fnkCompanyID = tblCompanies.pmkCompnayID
WHERE tblUsers.pmkEmail = ?


    Favorite.php (setting favorited companies)  
INSERT INTO tblFavorites SET fnkEmail = ?, fnkCompanyID = ?


    Account.php 
SELECT pmkEmail, fldName, fldGender, fldAvatar, fldPassword
FROM tblUsers
WHERE pmkEmail = ?


    Individual.php  
SELECT pmkCouponID, fldCouponName, fldCouponDescription
FROM tblCoupons
WHERE pmkCouponID = ?


    Print.php   
SELECT pmkCouponID, fldCouponName, fldCouponDescription, fldValid, fldBarcode
FROM tblCoupon
WHERE pmkCouponID = ?


    Results.php 

SELECT pmkCouponID, fldCouponName, fldCouponDescription,
       pmkCompanyID, fldCompanyName, fldCompanyDescription
FROM tblCoupons
JOIN tblCompany ON pmkCompanyID = fnkCompanyID
WHERE fldCouponName LIKE ?
OR fldCouponDescription LIKE ?
OR fldCompanyName LIKE ?
OR fldCompanyDescription LIKE ?
</pre>