<?php
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

// Write a function to display data of about section in html table
function displayAboutSectionData($result, $section)
{
    echo "<h3>$section Section</h3>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Title</th>";
    echo "<th>Content</th>";
    echo "<th>Action</th>";
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['content'] . "</td>";
        echo "<td>";
        echo "<button onclick='updateSection(" . json_encode($row) . ")'>Update</button>";
        echo "<button onclick='deleteSection(" . $row['id'] . ")'>Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Write a function to display data of timeline section
function displayTimelineSectionData($result, $section)
{
    echo "<h3>$section Section</h3>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Title</th>";
    echo "<th>Location</th>";
    echo "<th>Duration</th>";
    echo "<th>Action</th>";
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['location'] . "</td>";
        echo "<td>" . $row['duration'] . "</td>";
        echo "<td>";
        echo "<button onclick='updateSection(" . json_encode($row) . ")'>Update</button>";
        echo "<button onclick='deleteSection(" . $row['id'] . ")'>Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Write a function to display data of projects section
function displayProjectsSectionData($result, $section)
{
    echo "<h3>$section Section</h3>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Title</th>";
    echo "<th>Git Link</th>";
    echo "<th>Description</th>";
    echo "<th>Action</th>";
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['git_link'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>";
        echo "<button onclick='updateSection(" . json_encode($row) . ")'>Update</button>";
        echo "<button onclick='deleteSection(" . $row['id'] . ")'>Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Write a function to display data of achievements section
function displayAchievementsSectionData($result, $section)
{
    echo "<h3>$section Section</h3>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Title</th>";
    echo "<th>Description</th>";
    echo "<th>Certificate Link</th>";
    echo "<th>Action</th>";
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['certificate_link'] . "</td>";
        echo "<td>";
        echo "<button onclick='updateSection(" . json_encode($row) . ")'>Update</button>";
        echo "<button onclick='deleteSection(" . $row['id'] . ")'>Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Write a function to display data of skills section
function displaySkillsSectionData($result, $section)
{
    echo "<h3>$section Section</h3>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Title</th>";
    echo "<th>Description</th>";
    echo "<th>Certificate Link</th>";
    echo "<th>Action</th>";
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['certificate_link'] . "</td>";
        echo "<td>";
        echo "<button onclick='updateSection(" . json_encode($row) . ")'>Update</button>";
        echo "<button onclick='deleteSection(" . $row['id'] . ")'>Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Write a function to display data of meaasges
function displayMessagesSectionData($result, $section)
{
    echo "<h3>$section Section</h3>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Email</th>";
    echo "<th>Message</th>";
    echo "<th>Created At</th>";
    echo "<th>Action</th>";
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['message'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "<td>";
        echo "<button onclick='updateSection(" . json_encode($row) . ")'>Update</button>";
        echo "<button onclick='deleteSection(" . $row['id'] . ")'>Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle CRUD operations based on the submitted form data
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Perform CRUD operations based on $action
        switch ($action) {
            case 'add_about':
                // add data at about section
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $content = mysqli_real_escape_string($conn, $_POST['content']);
                $sql = "INSERT INTO about_section (title, content) VALUES ('$title', '$content')";
                $conn->query($sql);
                $sql = "SELECT * FROM about_section";
                $result = $conn->query($sql);
                displayAboutSectionData($result, 'About');
                break;

            case 'update_about':
                // update about section data
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $content = mysqli_real_escape_string($conn, $_POST['content']);
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $sql = "UPDATE about_section SET title='$title', content='$content' WHERE id=$id";
                $conn->query($sql);
                $sql = "SELECT * FROM about_section";
                $result = $conn->query($sql);
                displayAboutSectionData($result, 'About');
                break;

            case 'delete_about':
                // delete about section data
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $sql = "DELETE FROM about_section WHERE id=$id";
                $conn->query($sql);
                $sql = "SELECT * FROM about_section";
                $result = $conn->query($sql);
                displayAboutSectionData($result, 'About');
                break;

                // Similar switch cases for other sections (timeline, projects, achievements, skills)...
            case 'add_timeline':
                // add data at timeline section
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $content = mysqli_real_escape_string($conn, $_POST['content']);
                $sql = "INSERT INTO timeline_section (title, content) VALUES ('$title', '$content')";
                $conn->query($sql);
                $sql = "SELECT * FROM timeline_section";
                $result = $conn->query($sql);
                displayTimelineSectionData($result, 'Timeline');
                break;
            case 'update_timeline':
                // update timeline section data
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $content = mysqli_real_escape_string($conn, $_POST['content']);
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $sql = "UPDATE timeline_section SET title='$title', content='$content' WHERE id=$id";
                $conn->query($sql);
                $sql = "SELECT * FROM timeline_section";
                $result = $conn->query($sql);
                displayTimelineSectionData($result, 'Timeline');
                break;
            case 'delete_timeline':
                // delete timeline section data
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $sql = "DELETE FROM timeline_section WHERE id=$id";
                $conn->query($sql);
                $sql = "SELECT * FROM timeline_section";
                $result = $conn->query($sql);
                displayTimelineSectionData($result, 'Timeline');
                break;
            case 'add_projects':
                // add data at projects section
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $content = mysqli_real_escape_string($conn, $_POST['content']);
                $sql = "INSERT INTO projects_section (title, content) VALUES ('$title', '$content')";
                $conn->query($sql);
                $sql = "SELECT * FROM projects_section";
                $result = $conn->query($sql);
                displayProjectsSectionData($result, 'Projects');
                break;
            case 'update_projects':
                // update projects section data
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $content = mysqli_real_escape_string($conn, $_POST['content']);
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $sql = "UPDATE projects_section SET title='$title', content='$content' WHERE id=$id";
                $conn->query($sql);
                $sql = "SELECT * FROM projects_section";
                $result = $conn->query($sql);
                displayProjectsSectionData($result, 'Projects');
                break;
            case 'delete_projects':
                // delete projects section data
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $sql = "DELETE FROM projects_section WHERE id=$id";
                $conn->query($sql);
                $sql = "SELECT * FROM projects_section";
                $result = $conn->query($sql);
                displayProjectsSectionData($result, 'Projects');
                break;
            case 'add_achievements':
                // add data at achievements section
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $content = mysqli_real_escape_string($conn, $_POST['content']);
                $sql = "INSERT INTO achievements_section (title, content) VALUES ('$title', '$content')";
                $conn->query($sql);
                $sql = "SELECT * FROM achievements_section";
                $result = $conn->query($sql);
                displayAchievementsSectionData($result, 'Achievements');
                break;
            case 'update_achievements':
                // update achievements section data
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $content = mysqli_real_escape_string($conn, $_POST['content']);
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $sql = "UPDATE achievements_section SET title='$title', content='$content' WHERE id=$id";
                $conn->query($sql);
                $sql = "SELECT * FROM achievements_section";
                $result = $conn->query($sql);
                displayAchievementsSectionData($result, 'Achievements');
                break;
            case 'delete_achievements':
                // delete achievements section data
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $sql = "DELETE FROM achievements_section WHERE id=$id";
                $conn->query($sql);
                $sql = "SELECT * FROM achievements_section";
                $result = $conn->query($sql);
                displayAchievementsSectionData($result, 'Achievements');
                break;
            case 'add_skills':
                // add data at skills section
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $content = mysqli_real_escape_string($conn, $_POST['content']);
                $sql = "INSERT INTO skills_section (title, content) VALUES ('$title', '$content')";
                $conn->query($sql);
                $sql = "SELECT * FROM skills_section";
                $result = $conn->query($sql);
                displaySkillsSectionData($result, 'Skills');
                break;
            case 'update_skills':
                // update skills section data
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $content = mysqli_real_escape_string($conn, $_POST['content']);
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $sql = "UPDATE skills_section SET title='$title', content='$content' WHERE id=$id";
                $conn->query($sql);
                $sql = "SELECT * FROM skills_section";
                $result = $conn->query($sql);
                displaySkillsSectionData($result, 'Skills');
                break;
            case 'delete_skills':
                // delete skills section data
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $sql = "DELETE FROM skills_section WHERE id=$id";
                $conn->query($sql);
                $sql = "SELECT * FROM skills_section";
                $result = $conn->query($sql);
                displaySkillsSectionData($result, 'Skills');
                break;
            default:
                // Handle unexpected action
                echo "Invalid action";
                break;
        }
    }
}

// Placeholder for fetching and displaying data in HTML tables for each section
$sqlAbout = "SELECT * FROM about_section";
$resultAbout = $conn->query($sqlAbout);
displayAboutSectionData($resultAbout, 'About');

// Placeholder for fetching and displaying data for other sections (timeline, projects, achievements, skills)...

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Panel</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 20px;
}

h2 {
    color: #007bff;
}

form {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input,
textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 15px;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #007bff;
    color: #fff;
}

a {
    color: #007bff;
    text-decoration: none;
    margin-top: 20px;
    display: inline-block;
}

a:hover {
    text-decoration: underline;
}

.logout-link {
    margin-top: 20px;
    display: inline-block;
    color: #fff;
    background-color: #dc3545;
    padding: 10px 15px;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.logout-link:hover {
    background-color: #c82333;
}


    </style>
</head>

<body>
    <h2>Welcome, Admin!</h2>

    <!-- Example form for adding about section -->
    <form action="#" method="post">
        <input type="hidden" name="action" value="add_about">
        <label for="title">About Title:</label>
        <input type="text" name="title" required>
        <label for="content">About Content:</label>
        <textarea name="content" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Add About Section</button>
    </form>

    <!-- Example form for updating about section -->
    <form action="#" method="post">
        <input type="hidden" name="action" value="update_about">
        <input type="hidden" name="id" id="update_id">
        <label for="title">About Title:</label>
        <input type="text" name="title" id="update_title" required>
        <label for="content">About Content:</label>
        <textarea name="content" id="update_content" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Update About Section</button>
    </form>

    <!-- Example form for deleting about section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="delete_about">
        <input type="hidden" name="id" id="delete_id">
        <button type="submit">Delete About Section</button>
    </form>

    <!--Example form for adding timeline section -->
    <form action="#" method="post">
        <input type="hidden" name="action" value="add_timeline">
        <label for="title">Timeline Title:</label>
        <input type="text" name="title" required>
        <label for="content">Timeline Content:</label>
        <textarea name="content" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Add Timeline Section</button>
    </form>

    <!-- Example form for updating timeline section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="update_timeline">
        <input type="hidden" name="id" id="update_id">
        <label for="title">Timeline Title:</label>
        <input type="text" name="title" id="update_title" required>
        <label for="content">Timeline Content:</label>
        <textarea name="content" id="update_content" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Update Timeline Section</button>
    </form>

    <!-- Example form for deleting timeline section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="delete_timeline">
        <input type="hidden" name="id" id="delete_id">
        <button type="submit">Delete Timeline Section</button>
    </form>

    <!-- Example form for adding projects section -->
    <form action="#" method="post">
        <input type="hidden" name="action" value="add_projects">
        <label for="title">Projects Title:</label>
        <input type="text" name="title" required>
        <label for="content">Projects Content:</label>
        <textarea name="content" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Add Projects Section</button>
    </form>

    <!-- Example form for updating projects section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="update_projects">
        <input type="hidden" name="id" id="update_id">
        <label for="title">Projects Title:</label>
        <input type="text" name="title" id="update_title" required>
        <label for="content">Projects Content:</label>
        <textarea name="content" id="update_content" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Update Projects Section</button>
    </form>

    <!-- Example form for deleting projects section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="delete_projects">
        <input type="hidden" name="id" id="delete_id">
        <button type="submit">Delete Projects Section</button>
    </form>

    <!-- Example form for adding achievements section -->
    <form action="#" method="post">
        <input type="hidden" name="action" value="add_achievements">
        <label for="title">Achievements Title:</label>
        <input type="text" name="title" required>
        <label for="content">Achievements Content:</label>
        <textarea name="content" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Add Achievements Section</button>
    </form>

    <!-- Example form for updating achievements section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="update_achievements">
        <input type="hidden" name="id" id="update_id">
        <label for="title">Achievements Title:</label>
        <input type="text" name="title" id="update_title" required>
        <label for="content">Achievements Content:</label>
        <textarea name="content" id="update_content" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Update Achievements Section</button>
    </form>

    <!-- Example form for deleting achievements section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="delete_achievements">
        <input type="hidden" name="id" id="delete_id">
        <button type="submit">Delete Achievements Section</button>
    </form>

    <!-- Example form for adding skills section -->
    <form action="#" method="post">
        <input type="hidden" name="action" value="add_skills">
        <label for="title">Skills Title:</label>
        <input type="text" name="title" required>
        <label for="content">Skills Content:</label>
        <textarea name="content" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Add Skills Section</button>
    </form>

    <!-- Example form for updating skills section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="update_skills">
        <input type="hidden" name="id" id="update_id">
        <label for="title">Skills Title:</label>
        <input type="text" name="title" id="update_title" required>
        <label for="content">Skills Content:</label>
        <textarea name="content" id="update_content" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Update Skills Section</button>
    </form>

    <!-- Example form for deleting skills section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="delete_skills">
        <input type="hidden" name="id" id="delete_id">
        <button type="submit">Delete Skills Section</button>
    </form>

    <!-- Example form for adding contact section -->
    <form action="#" method="post">
        <input type="hidden" name="action" value="add_contact">
        <label for="name">Contact Name:</label>
        <input type="text" name="name" required>
        <label for="email">Contact Email:</label>
        <input type="email" name="email" required>
        <label for="message">Contact Message:</label>
        <textarea name="message" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Add Contact Section</button>
    </form>

    <!-- Example form for updating contact section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="update_contact">
        <input type="hidden" name="id" id="update_id">
        <label for="name">Contact Name:</label>
        <input type="text" name="name" id="update_name" required>
        <label for="email">Contact Email:</label>
        <input type="email" name="email" id="update_email" required>
        <label for="message">Contact Message:</label>
        <textarea name="message" id="update_message" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Update Contact Section</button>
    </form>

    <!-- Example form for deleting contact section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="delete_contact">
        <input type="hidden" name="id" id="delete_id">
        <button type="submit">Delete Contact Section</button>
    </form>

    <!-- Example form for adding messages section -->
    <form action="#" method="post">
        <input type="hidden" name="action" value="add_messages">
        <label for="name">Messages Name:</label>
        <input type="text" name="name" required>
        <label for="email">Messages Email:</label>
        <input type="email" name="email" required>
        <label for="message">Messages Message:</label>
        <textarea name="message" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Add Messages Section</button>
    </form>

    <!-- Example form for updating messages section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="update_messages">
        <input type="hidden" name="id" id="update_id">
        <label for="name">Messages Name:</label>
        <input type="text" name="name" id="update_name" required>
        <label for="email">Messages Email:</label>
        <input type="email" name="email" id="update_email" required>
        <label for="message">Messages Message:</label>
        <textarea name="message" id="update_message" required></textarea>
        <!-- Add more input fields as needed -->
        <button type="submit">Update Messages Section</button>
    </form>

    <!-- Example form for deleting messages section -->

    <form action="#" method="post">
        <input type="hidden" name="action" value="delete_messages">
        <input type="hidden" name="id" id="delete_id">
        <button type="submit">Delete Messages Section</button>
    </form>
    <a href="logout.php">Logout</a>
    <script src="script.js"></script>
</body>

</html>