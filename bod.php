
<?php
// koneksi database
$conn = new mysqli("localhost", "root", "", "db_bwm");

// ambil id yang dikirim lewat URL
$id = $_GET['id'];

// ambil data berdasarkan id
$result = $conn->query("SELECT * FROM table_client WHERE Id = $id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>BOD Capacity</title>
</head>
<body>
<h2>BOD Capacity</h2>
<form method="post" action="update.php">
  <!-- kirim id sebagai hidden -->
  <input type="hidden" name="id" value="<?php echo $row['Id']; ?>">

  Hostname:<br>
  <input type="text" name="hostname" value="<?php echo $row['Hostname']; ?>" readonly><br><br>

  Description:<br>
  <input type="text" name="description" value="<?php echo $row['Description']; ?>" readonly><br><br>
  
  Interface:<br>
  <input type="text" name="interface" value="<?php echo $row['Interface']; ?>" readonly><br><br>
    
  Unit:<br>
  <input type="text" name="unit" value="<?php echo $row['Unit']; ?>" readonly><br><br>

  Input Policer Existing:<br>
  <input type="text" name="input_policer" value="<?php echo $row['Input_policer']; ?>" readonly><br><br>

  Output Policer Existing:<br>
  <input type="text" name="output_policer" value="<?php echo $row['Output_policer']; ?>" readonly><br><br>

  Input Policer BOD:<br>
  <input type="text" name="bod_input_policer" value=""><br><br>

  Output Policer BOD:<br>
  <input type="text" name="bod_output_policer" value=""><br><br>
  
  BOD Until:<br>
  <input type="datetime-local" name="bod_time" value=""><br><br>

  <input type="submit" value="Update">
</form>
</body>
</html>
