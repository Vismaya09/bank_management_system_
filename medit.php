<?php
session_start();
if(!isset($_SESSION['managerId'])) { 
    header('location:login.php');
}

require 'assets/db.php';

if (isset($_GET['id'])) {
    $accountId = $_GET['id'];
    $accountQuery = $con->query("SELECT * FROM useraccounts WHERE id = '$accountId'");
    if ($accountQuery->num_rows > 0) {
        $account = $accountQuery->fetch_assoc();
    } else {
        header("location:mindex.php");
    }
} else {
    header("location:mindex.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission and update database
    $name = $_POST['name'];
    $balance = $_POST['balance'];
    $number = $_POST['number'];
    // Update the database with new values
    $updateQuery = "UPDATE useraccounts SET name = '$name', balance = '$balance', number = '$number' WHERE id = '$accountId'";
    if ($con->query($updateQuery) === TRUE) {
        header("location:mindex.php");
    } else {
        echo "Error updating record: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Account</title>
    <!-- Include necessary stylesheets and scripts -->
</head>
<body>
    <h2>Edit Account</h2>
    <form method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $account['name']; ?>"><br>
        <label for="balance">Balance:</label><br>
        <input type="text" id="balance" name="balance" value="<?php echo $account['balance']; ?>"><br>
        <label for="number">Contact Number:</label><br>
        <input type="text" id="number" name="number" value="<?php echo $account['number']; ?>"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
