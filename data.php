<h2>tblCompany</h2>
<table class="print">
    <tr>
        <th>Column</th>
        <th>Type</th>
        <th>Null</th>
        <th>Default</th>  
        <th>Links to</th>
        <th>Comments</th>
    </tr>
    <tr class="odd">
        <td class="nowrap">pmkCompanyID <em>(Primary)</em></td>
        <td class="nowrap" lang="en" dir="ltr">int(100)</td>
        <td>No</td>
        <td class="nowrap"></td>   
        <td></td>
        <td></td>
    </tr>
    <tr class="even">
        <td class="nowrap">fldCompanyName</td>
        <td class="nowrap" lang="en" dir="ltr">varchar(100)</td>
        <td>No</td>
        <td class="nowrap"></td>  
        <td></td>
        <td></td>
    </tr>
    <tr class="odd">
        <td class="nowrap">fldCompanyDescription</td>
        <td class="nowrap" lang="en" dir="ltr">varchar(500)</td>
        <td>No</td>
        <td class="nowrap"></td>  
        <td></td>
        <td></td>
    </tr>
</table>
<h2>tblCoupons</h2>
<table class="print">
    <tr>
        <th>Column</th>
        <th>Type</th>
        <th>Null</th>
        <th>Default</th> 
        <th>Links to</th>
        <th>Comments</th>
    </tr>
    <tr class="odd">
        <td class="nowrap">pmkCouponID <em>(Primary)</em></td>
        <td class="nowrap" lang="en" dir="ltr">int(100)</td>
        <td>No</td>
        <td class="nowrap"></td>  
        <td></td>
        <td></td>
    </tr>
    <tr class="even">
        <td class="nowrap">fnkCompanyID</td>
        <td class="nowrap" lang="en" dir="ltr">int(100)</td>
        <td>No</td><td class="nowrap"></td>  
        <td>tblCompany -&gt; pmkCompanyID</td>
        <td></td>
    </tr>
    <tr class="odd">
        <td class="nowrap">fldCouponDescription</td>
        <td class="nowrap" lang="en" dir="ltr">varchar(500)</td>
        <td>No</td>
        <td class="nowrap"></td>  
        <td></td>
        <td></td>
    </tr>
    <tr class="even">
        <td class="nowrap">fldBarcode</td>
        <td class="nowrap" lang="en" dir="ltr">varchar(200)</td>
        <td>No</td>
        <td class="nowrap"></td>  
        <td></td>
        <td></td>
    </tr>
    <tr class="odd">
        <td class="nowrap">fldValid</td>
        <td class="nowrap" lang="en" dir="ltr">varchar(50)</td>
        <td>No</td>
        <td class="nowrap"></td>   
        <td></td>
        <td></td>
    </tr>
    <tr class="even">
        <td class="nowrap">fldCouponName</td>
        <td class="nowrap" lang="en" dir="ltr">varchar(100)</td>
        <td>No</td>
        <td class="nowrap"></td>  
        <td></td>
        <td></td>
    </tr></table>
<h2>tblFavorites</h2>
<table class="print">
    <tr>
        <th>Column</th>
        <th>Type</th>
        <th>Null</th>
        <th>Default</th>  
        <th>Links to</th>
        <th>Comments</th>
    </tr><tr class="odd"><td class="nowrap">fnkCompanyID</td><td class="nowrap" lang="en" dir="ltr">int(100)</td><td>No</td><td class="nowrap"></td>    <td>tblCompany -&gt; pmkCompanyID</td>
        <td></td>
    </tr><tr class="even"><td class="nowrap">fnkEmail</td><td class="nowrap" lang="en" dir="ltr">varchar(50)</td><td>No</td><td class="nowrap"></td>    <td>tblUsers -&gt; pmkEmail</td>
        <td></td>
    </tr></table><h2>tblUserCoupon</h2>
<table class="print">
    <tr>
        <th>Column</th>
        <th>Type</th>
        <th>Null</th>
        <th>Default</th> 
        <th>Links to</th>
        <th>Comments</th>
    </tr><tr class="odd"><td class="nowrap">fnkEmail</td><td class="nowrap" lang="en" dir="ltr">varchar(50)</td><td>No</td><td class="nowrap"></td>    <td>tblUsers -&gt; pmkEmail</td>
        <td></td>
    </tr><tr class="even"><td class="nowrap">fnkCouponID</td><td class="nowrap" lang="en" dir="ltr">int(100)</td><td>No</td><td class="nowrap"></td>    <td>tblCoupons -&gt; pmkCouponID</td>
        <td></td>
    </tr></table><h2>tblUsers</h2>
<table class="print">
    <tr>
        <th>Column</th>
        <th>Type</th>
        <th>Null</th>
        <th>Default</th> 
        <th>Links to</th>
        <th>Comments</th>
    </tr><tr class="odd"><td class="nowrap">pmkEmail <em>(Primary)</em></td><td class="nowrap" lang="en" dir="ltr">varchar(20)</td><td>No</td><td class="nowrap"></td>    <td></td>
        <td></td>
    </tr><tr class="even"><td class="nowrap">fldName</td><td class="nowrap" lang="en" dir="ltr">varchar(50)</td><td>No</td><td class="nowrap"></td>    <td></td>
        <td></td>
    </tr><tr class="odd"><td class="nowrap">fldGender</td><td class="nowrap" lang="en" dir="ltr">varchar(15)</td><td>No</td><td class="nowrap"></td>    <td></td>
        <td></td>
    </tr><tr class="even"><td class="nowrap">fldAvatar</td><td class="nowrap" lang="en" dir="ltr">varchar(25)</td><td>No</td><td class="nowrap"></td>    <td></td>
        <td></td>
    </tr><tr class="odd"><td class="nowrap">fldPassword</td><td class="nowrap" lang="en" dir="ltr">varchar(25)</td><td>No</td><td class="nowrap"></td>    <td></td>
        <td></td>
    </tr>