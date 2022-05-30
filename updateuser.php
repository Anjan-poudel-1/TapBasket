<?php
include("connection.php");
if(isset($_GET['email'])){
$Temail=$_GET['email'];
$PASS=md5('Password1');
echo 'hello there';
$isdisable='false';
$Trole='Trader';
$updateVcodeSql = "UPDATE USERS SET PASSWORD=:passwords,IS_DISABLED=:isdisable WHERE EMAIL=:email and USER_ROLE=:role";
$stidVcodeUpdate = oci_parse($conn,$updateVcodeSql);
oci_bind_by_name($stidVcodeUpdate, ':passwords', $PASS);
oci_bind_by_name($stidVcodeUpdate, ':email', $Temail);
oci_bind_by_name($stidVcodeUpdate, ':role', $Trole);
oci_bind_by_name($stidVcodeUpdate, ':isdisable', $isdisable);
oci_execute($stidVcodeUpdate, OCI_COMMIT_ON_SUCCESS);

$approved='True';
$select="select * from users where email=$Temail";
$stid=(oci_parse($conn,$select));
oci_execute($stid,OCI_COMMIT_ON_SUCCESS);  
while (($rowname = oci_fetch_object($$stid))) {
    $userid= $rowname->USER_ID;   

$updateidSql = "UPDATE SHOP_REQUEST SET IS_APPROVED=:approved WHERE USER_ID=:userid";
$stididUpdate = oci_parse($conn,$updateidSql);
oci_bind_by_name($stididUpdate, ':userid', $userid);
oci_bind_by_name($stididUpdate, ':approved', $approved);
oci_execute($stididUpdate, OCI_COMMIT_ON_SUCCESS);
}
}
?>
