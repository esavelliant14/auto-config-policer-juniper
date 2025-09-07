<?php
$conn = new mysqli("localhost", "root", "", "db_bwm");

$id = $_POST['id'];

$Hostname = $_POST['Hostname'];
$Interface = $_POST['Interface'];
$Unit = $_POST['Unit'];
$Status_unit = $_POST['Status_unit'];
$Description = $_POST['Description'];
$Ip_address = $_POST['Ip_address'];
$Vlan_id = $_POST['Vlan_id'];
$Policer_status = $_POST['Policer_status'];
$Policer_input_status = $_POST['Policer_input_status'];
$Policer_output_status = $_POST['Policer_output_status'];
$Input_policer = $_POST['Input_policer'];
$Output_policer = $_POST['Output_policer'];

// update ke database
$sql = "UPDATE table_client SET 
            Hostname='$Hostname', 
            Interface='$Interface',
            Unit='$Unit',
            Status_unit='$Status_unit',
            Description='$Description',
            Ip_address='$Ip_address',
            Vlan_id='$Vlan_id',
            Policer_status='$Policer_status',
            Policer_input_status='$Policer_input_status',
            Policer_output_status='$Policer_output_status',
            Input_policer='$Input_policer',
            Output_policer='$Output_policer'
        WHERE Id=$id";

if ($conn->query($sql) === TRUE) {
    // setelah update redirect ke index
    header("Location: index.php");
    exit;
} else {
    echo "Error: " . $conn->error;
}
?>
