<?php
include("connection.php");
if(isset($_GET['email'])){
$Temail=$_GET['email'];
//$PASS=md5('Password1');
$PASS='Password1';
$isdisable='false';
$Trole='trader';
$updateVcodeSql = "UPDATE USERS SET PASSWORD=:passwords,IS_DISABLED=:isdisable WHERE EMAIL=:email and USER_ROLE=:role_user";
$stidVcodeUpdate = oci_parse($conn,$updateVcodeSql);
oci_bind_by_name($stidVcodeUpdate, ':passwords', $PASS);
oci_bind_by_name($stidVcodeUpdate, ':email', $Temail);
oci_bind_by_name($stidVcodeUpdate, ':role_user', $Trole);
oci_bind_by_name($stidVcodeUpdate, ':isdisable', $isdisable);
oci_execute($stidVcodeUpdate, OCI_COMMIT_ON_SUCCESS);

$approved='true';
$select="select * from users where email=:email";
$stid=(oci_parse($conn,$select));
oci_bind_by_name($stid, ':email', $Temail);
oci_execute($stid,OCI_COMMIT_ON_SUCCESS);  
while (($rowname = oci_fetch_object($stid))!= false) {
    $userid= $rowname->USER_ID;   
$updateidSql = "UPDATE SHOP_REQUEST SET IS_APPROVED=:approved WHERE USER_ID=:userid";
$stididUpdate = oci_parse($conn,$updateidSql);
oci_bind_by_name($stididUpdate, ':userid', $userid);
oci_bind_by_name($stididUpdate, ':approved', $approved);
oci_execute($stididUpdate, OCI_COMMIT_ON_SUCCESS);
oci_commit($conn);
oci_free_statement($stididUpdate);
oci_close($conn);

echo "You have accepted this trader account";
}
}
?>
