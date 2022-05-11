<!-- Everyone create the same schema and password.. -->
<?php
$conn = oci_connect('tapbasket', 'tapbasket', 'localhost/XE');

if (!$conn) {
	$e = oci_error();
	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
?>