<?php

/**
 * Config Module.
 *
 * @package   OpenEMR Module
 * @link      http://www.open-emr.org
 * @author    Jerry Padgett <sjpadgett@gmail.com>
 * @copyright Copyright (c) 2023 Jerry Padgett <sjpadgett@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

$sessionAllowWrite = true;
require_once(__DIR__ . "/../../../../globals.php");

use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Core\Header;


// Get the categories list.
$categories = array();
getKittens(0, '', $categories);

// Get the users list.
$ures = sqlStatement("SELECT username, fname, lname FROM users " .
    "WHERE active = 1 AND ( info IS NULL OR info NOT LIKE '%Inactive%' ) " .
    "ORDER BY lname, fname");
if ($_POST['form_save'] ?? null) {
    if (!CsrfUtils::verifyCsrfToken($_POST["csrf_token_form"])) {
        CsrfUtils::csrfNotVerified();
    }
}

?>
<!DOCTYPE HTML>
<html lang="eng">
<head>
    <title>><?php echo xlt("Enable Vendors") ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php

    Header::setupHeader();
    ?>
    <script>

    </script>
</head>
<body>
    <div class="w-100">
        <div class="col-6">

        </div>
        <div class="col-6" id="set-dispose">
            <form id="set_form" name="set_form" class="form" role="form" method="post" action="">
                <input type="hidden" name="csrf_token_form" id="csrf_token_form" value="<?php echo attr(CsrfUtils::collectCsrfToken()); ?>" />
                <div class="form-row mt-2">
                    <label class="col-3 col-form-label font-weight-bold"><?php echo xlt('Category'); ?></label>
                    <div class="col-3">
                        <select name='form_category' class='form-control'>
                            <?php
                            foreach ($categories as $catkey => $catname) {
                                echo "<option value='" . attr($catkey) . "'";
                                echo ">" . text($catname) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

            </form>
        </div>
    </div>
</body>
</html>
