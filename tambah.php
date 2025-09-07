<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Form Input Client</title>
    <style>
        label {
            display: block;
            margin-top: 10px;
        }
        input[type=text] {
            width: 300px;
            padding: 5px;
        }
        input[type=submit] {
            margin-top: 15px;
            padding: 6px 12px;
        }
    </style>
</head>
<body>
    <h2>Form Input Client</h2>
    <form method="post" action="action.php">
        <label for="ip">IP Router:</label>
        <input type="text" name="ip" id="ip" placeholder="misal 192.168.147.222" required>

        <label for="interface">Interface:</label>
        <input type="text" name="interface" id="interface" placeholder="misal em1" required>

        <label for="unit">Unit:</label>
        <input type="text" name="unit" id="unit" placeholder="misal 10" required>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
