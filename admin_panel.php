<?php
// Include the database connection and start the session
include 'db.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Function to sanitize user input
function sanitizeInput($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

// Function to handle the addition of data
function addData($table, $data)
{
    global $conn;
    $columns = implode(", ", array_keys($data));
    $values = "'" . implode("', '", array_values($data)) . "'";
    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    return $conn->query($sql);
}

// Function to handle the updating of data
function updateData($table, $id, $data)
{
    global $conn;
    $updates = "";
    foreach ($data as $key => $value) {
        $updates .= "$key = '$value', ";
    }
    $updates = rtrim($updates, ", ");
    $sql = "UPDATE $table SET $updates WHERE id=$id";
    return $conn->query($sql);
}

// Function to handle the deletion of data
function deleteData($table, $id)
{
    global $conn;
    $sql = "DELETE FROM $table WHERE id=$id";
    return $conn->query($sql);
}

// Check if form is submitted for adding or updating data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = $_POST['table'];
    
    if (isset($_POST['add'])) {
        $data = array();
        foreach ($_POST as $key => $value) {
            if ($key != 'table' && $key != 'add') {
                $data[$key] = sanitizeInput($value);
            }
        }
        addData($table, $data);
    } elseif (isset($_POST['update'])) {
        $id = sanitizeInput($_POST['id']);
        $data = array();
        foreach ($_POST as $key => $value) {
            if ($key != 'table' && $key != 'update' && $key != 'id') {
                $data[$key] = sanitizeInput($value);
            }
        }
        updateData($table, $id, $data);
    } elseif (isset($_POST['delete'])) {
        $id = sanitizeInput($_POST['delete_id']);
        deleteData($table, $id);
    }
}

// Fetch data for all sections
$tables = array('about_section', 'timeline_section', 'projects_section', 'achievements_section', 'skills_section', 'messages');
$data = array();
foreach ($tables as $table) {
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);
    $data[$table] = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>

<body>
    <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>

    <!-- Display data for all sections -->
    <?php foreach ($tables as $table) : ?>
        <h3><?php echo ucfirst(str_replace("_", " ", $table)); ?></h3>
        <form action="#" method="post">
            <input type="hidden" name="table" value="<?php echo $table; ?>">

            <!-- Add Section -->
            <h4>Add <?php echo ucfirst(str_replace("_", " ", $table)); ?></h4>
            <?php foreach (array_keys($data) as $key) : ?>
                <label for="<?php echo $key; ?>"><?php echo ucfirst(str_replace("_", " ", $key)); ?>:</label>
                <input type="text" name="<?php echo $key; ?>" required>
            <?php endforeach; ?>
            <button type="submit" name="add">Add</button>
        </form>

        <!-- Update and Delete Section -->
        <h4>Update/Delete <?php echo ucfirst(str_replace("_", " ", $table)); ?></h4>
        <table border="1">
            <tr>
                <?php foreach (array_keys($data) as $key) : ?>
                    <th><?php echo ucfirst(str_replace("_", " ", $key)); ?></th>
                <?php endforeach; ?>
                <th>Action</th>
            </tr>
            <?php foreach ($data[$table] as $row) : ?>
                <tr>
                    <?php foreach ($row as $key => $value) : ?>
                        <td><?php echo $value; ?></td>
                    <?php endforeach; ?>
                    <td>
                        <form action="#" method="post">
                            <input type="hidden" name="table" value="<?php echo $table; ?>">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="update">Update</button>
                        </form>
                        <form action="#" method="post">
                            <input type="hidden" name="table" value="<?php echo $table; ?>">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>

    <a href="admin_logout.php">Logout</a>
</body>

</html>
