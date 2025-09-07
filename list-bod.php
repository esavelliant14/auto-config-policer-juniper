<?php
// koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_bwm";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM table_bod";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>List Table BOD</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }
    </style>
</head>
<body>
<h2>Daftar Perubahan Policer (table_bod)</h2>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Hostname</th>
            <th>Description</th>
            <th>Interface</th>
            <th>Unit</th>
            <th>Old Input Policer</th>
            <th>Old Output Policer</th>
            <th>Bod Input Policer</th>
            <th>Bod Output Policer</th>
            <th>Datetime</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($result->num_rows > 0) {
        $no = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . htmlspecialchars($row['Hostname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Interface']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Unit']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Old_input_policer']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Old_output_policer']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Bod_input_policer']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Bod_output_policer']) . "</td>";
            echo "<td>" . htmlspecialchars($row['datetime']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='10'>Tidak ada data</td></tr>";
    }
    ?>
    </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>
