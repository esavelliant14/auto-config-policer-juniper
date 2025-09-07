<?php
$device_ip        = escapeshellarg($_POST['ip']);
$iface_name = escapeshellarg($_POST['interface']);
$unit_filter      = escapeshellarg($_POST['unit']);

$command = "python test.py $device_ip $iface_name $unit_filter";
$output  = shell_exec($command);

    header("Location: index.php");
    exit;
?>
