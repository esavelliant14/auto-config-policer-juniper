<?php
// Konfigurasi koneksi database
$host = "localhost";       // host MySQL
$user = "root";            // username MySQL
$pass = "";        // password MySQL
$db   = "db_bwm";            // nama database

// Koneksi ke MySQL
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query ambil data
$sql = "SELECT 
            Id, Hostname, Interface, Unit, Status_unit, Description, 
            Ip_address, Vlan_id, Policer_status,
            Policer_input_status, Policer_output_status, 
            Input_policer, Output_policer 
        FROM table_client";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Client</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h2>Data Client</h2>
<a href="tambah.php">tambah data</a><br>
<a href="list-bod.php">List Bod</a>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Hostname</th>
            <th>Interface</th>
            <th>Description</th>
            <th>Input Policer</th>
            <th>Output Policer</th>
			<th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): 
		$no = 1;?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row["Hostname"]) ?></td>
                    <td><?= htmlspecialchars($row["Interface"]) ?></td>
                    <td><?= htmlspecialchars($row["Description"]) ?></td>
                    <td><?= htmlspecialchars($row["Input_policer"]) ?></td>
                    <td><?= htmlspecialchars($row["Output_policer"]) ?></td>
					<td>
						<a href="bod.php?id=<?php echo $row['Id']; ?>">bod</a>
					</td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="13">Belum ada data</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</body>
</html>
<?php
$conn->close();
?>
