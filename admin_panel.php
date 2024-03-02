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
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #333;
        }

        h3 {
            margin-top: 20px;
            color: #555;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 5px 10px;
            cursor: pointer;
            background-color: #4caf50;
            color: #fff;
            border: none;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>

    <!-- Display data for all sections -->

    <!-- About Section -->
    <h3>About Section</h3>
    <form action="#" method="post">
        <input type="hidden" name="table" value="about_section">
        <!-- Add Section -->
        <h4>Add About Section</h4>
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        <label for="content">Content:</label>
        <input type="text" name="content" required>
        <button type="submit" name="add">Add</button>
    </form>

    <form action="#" method="post">
        <input type="hidden" name="table" value="about_section">
        <!-- Update and Delete Section -->
        <h4>Update/Delete About Section</h4>
        <table>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Action</th>
            </tr>
            <?php foreach ($data['about_section'] as $row) : ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['content']; ?></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="update">Update</button>
                        <form action="#" method="post">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </form>

    <!-- Timeline Section -->
    <h3>Timeline Section</h3>
    <form action="#" method="post">
        <input type="hidden" name="table" value="timeline_section">
        <!-- Add Section -->
        <h4>Add Timeline Section</h4>
        <!-- Add form fields for timeline section -->
        <button type="submit" name="add">Add</button>
    </form>

    <form action="#" method="post">
        <input type="hidden" name="table" value="timeline_section">
        <!-- Update and Delete Section -->
        <h4>Update/Delete Timeline Section</h4>
        <!-- Add form fields for updating and deleting timeline section -->
        <button type="submit" name="update">Update</button>
        <form action="#" method="post">
            <input type="hidden" name="delete_id" value="">
            <button type="submit" name="delete">Delete</button>
        </form>
    </form>

    <!-- Projects Section -->
    <h3>Projects Section</h3>
    <form action="#" method="post">
        <input type="hidden" name="table" value="projects_section">
        <!-- Add Section -->
        <h4>Add Projects Section</h4>
        <!-- Add form fields for projects section -->
        <button type="submit" name="add">Add</button>
    </form>

    <form action="#" method="post">
        <input type="hidden" name="table" value="projects_section">
        <!-- Update and Delete Section -->
        <h4>Update/Delete Projects Section</h4>
        <!-- Add form fields for updating and deleting projects section -->
        <button type="submit" name="update">Update</button>
        <form action="#" method="post">
            <input type="hidden" name="delete_id" value="">
            <button type="submit" name="delete">Delete</button>
        </form>
    </form>

    <!-- Add similar forms for other sections -->

    <a href="admin_logout.php">Logout</a>
</body>

</html>