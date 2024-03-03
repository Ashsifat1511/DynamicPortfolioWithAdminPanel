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


// Placeholder for fetching and displaying data for other sections (timeline, projects, achievements, skills)...

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="panel.css" />
</head>

<body>
    <h2>Welcome, Admin!</h2>
    
    <?php 
        $sqlAbout = "SELECT * FROM about_section";
        $resultAbout = $conn->query($sqlAbout);
        displayAboutSectionData($resultAbout, 'About');
        $sqlTimeline = "SELECT * FROM timeline_section";
        $resultTimeline = $conn->query($sqlTimeline);
        displayTimelineSectionData($resultTimeline, 'Timeline');
        $sqlProjects = "SELECT * FROM projects_section";
        $resultProjects = $conn->query($sqlProjects);
        displayProjectsSectionData($resultProjects, 'Projects');
        $sqlAchievements = "SELECT * FROM achievements_section";
        $resultAchievements = $conn->query($sqlAchievements);
        displayAchievementsSectionData($resultAchievements, 'Achievements');
        $sqlSkills = "SELECT * FROM skills_section";
        $resultSkills = $conn->query($sqlSkills);
        displaySkillsSectionData($resultSkills, 'Skills');
        $sqlMessages = "SELECT * FROM messages";
        $resultMessages = $conn->query($sqlMessages);
        displayMessagesSectionData($resultMessages, 'Messages');
    ?>
    <a href="logout.php">Logout</a>
    <script src="script.js"></script>
</body>

</html>