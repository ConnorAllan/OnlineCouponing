<?php
include 'includes/top.php';
include 'includes/nav.php';
$data = array('false');
if (isset($_POST['Filter'])) {
    $query = 'SELECT fldCouponName, fldValid, fldCouponDescription, fldCategory, '
            . 'fldCompanyName, pmkCouponID '
            . 'FROM tblCoupons JOIN tblCompany ON pmkCompanyID = fnkCompanyID '
            . 'WHERE fldExpired = ? AND ';
    if (isset($_POST['Grocery'])) {
        $value = htmlentities($_POST['Grocery'], ENT_QUOTES, "UTF-8");
        array_push($data, $value);
        if (isset($and)) {
            $query .= 'OR fldCategory = ? ';
        } else {
            $and = true;
            $query .= 'fldCategory = ? ';
        }
    }
    if (isset($_POST['Technology'])) {
        $value = htmlentities($_POST['Technology'], ENT_QUOTES, "UTF-8");
        array_push($data, $value);
        if (isset($and)) {
            $query .= 'OR fldCategory = ? ';
        } else {
            $and = true;
            $query .= 'fldCategory = ? ';
        }
    }
    if (isset($_POST['Concert'])) {
        $value = htmlentities($_POST['Concert'], ENT_QUOTES, "UTF-8");
        array_push($data, $value);
        if (isset($and)) {
            $query .= 'OR fldCategory = ? ';
        } else {
            $and = true;
            $query .= 'fldCategory = ? ';
        }
    }
    if (isset($_POST['Music/Art'])) {
        $value = htmlentities($_POST['Music/Art'], ENT_QUOTES, "UTF-8");
        array_push($data, $value);
        if (isset($and)) {
            $query .= 'OR fldCategory = ? ';
        } else {
            $and = true;
            $query .= 'fldCategory = ? ';
        }
    }
    if (isset($_POST['Food'])) {
        $value = htmlentities($_POST['Food'], ENT_QUOTES, "UTF-8");
        array_push($data, $value);
        if (isset($and)) {
            $query .= 'OR fldCategory = ? ';
        } else {
            $and = true;
            $query .= 'fldCategory = ? ';
        }
    }
    if (isset($_POST['Clothing'])) {
        $value = htmlentities($_POST['Clothing'], ENT_QUOTES, "UTF-8");
        array_push($data, $value);
        if (isset($and)) {
            $query .= 'OR fldCategory = ? ';
        } else {
            $and = true;
            $query .= 'fldCategory = ? ';
        }
    }
    $count = count($data);
} else {
    $count = 1;
    $query = 'SELECT fldCouponName, fldValid, fldCouponDescription, fldCategory, '
            . 'fldCompanyName, pmkCouponID '
            . 'FROM tblCoupons JOIN tblCompany ON pmkCompanyID = fnkCompanyID '
            . 'WHERE fldExpired = ? ';
}
?>
<article id="mainContent">
    <form class="browse" action="browse.php" method="post">
        <fieldset>
            <legend>Filters</legend>
            <?php
            if (isset($_POST['Grocery'])) {
                echo '<input type = "checkbox" name = "Grocery" value = "Grocery" checked> Grocery';
            } else {
                echo '<input type = "checkbox" name = "Grocery" value = "Grocery"> Grocery';
            }
            if (isset($_POST['Technology'])) {
                echo '<input type = "checkbox" name = "Technology" value = "Technology" checked> Technology';
            } else {
                echo '<input type = "checkbox" name = "Technology" value = "Technology"> Technology';
            }
            if (isset($_POST['Concert'])) {
                echo '<input type = "checkbox" name = "Concert" value = "Concert" checked> Concert';
            } else {
                echo '<input type = "checkbox" name = "Concert" value = "Concert"> Concert';
            }
            if (isset($_POST['Music/Art'])) {
                echo '<input type = "checkbox" name = "Music/Art" value = "Music Art" checked> Music/Art';
            } else {
                echo '<input type = "checkbox" name = "Music/Art" value = "Music Art"> Music/Art';
            }
            if (isset($_POST['Food'])) {
                echo '<input type = "checkbox" name = "Food" value = "Food" checked> Food';
            } else {
                echo '<input type = "checkbox" name = "Food" value = "Food"> Food';
            }
            if (isset($_POST['Clothing'])) {
                echo '<input type = "checkbox" name = "Clothing" value = "Clothing" checked> Clothing';
            } else {
                echo '<input type = "checkbox" name = "Clothing" value = "Clothing"> Clothing';
            }
            ?>
        </fieldset>
        <input type="submit" name="Filter" value="Filter">
    </form>
    <article>
        <?php
        include 'results.php';
        ?>
    </article>
</article>