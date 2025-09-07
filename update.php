<?php
$hostname = escapeshellarg($_POST['hostname']);
$description = escapeshellarg($_POST['description']);
$device_ip        = "192.168.147.222";
$iface_name = escapeshellarg($_POST['interface']);
$unit_filter      = escapeshellarg($_POST['unit']);
$existing_input_policer = escapeshellarg($_POST['input_policer']);
$existing_output_policer = escapeshellarg($_POST['output_policer']);
$bod_input_policer = escapeshellarg($_POST['bod_input_policer']);
$bod_output_policer = escapeshellarg($_POST['bod_output_policer']);
$timeku = escapeshellarg($_POST['bod_time']);
$bod_time = str_replace("T"," ",$timeku).":00";


$command = "python bod.py $device_ip $iface_name $unit_filter  $bod_input_policer $bod_output_policer $hostname $description $existing_input_policer $existing_output_policer $bod_time";
$output  = shell_exec($command);

    header("Location: index.php");
    exit;
?>
