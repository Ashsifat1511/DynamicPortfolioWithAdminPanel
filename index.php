<?php
include 'db.php';

// Fetch data for about section
$sqlAbout = "SELECT * FROM about_section";
$resultAbout = $conn->query($sqlAbout);


// Fetch data for timeline section
$sqlTimeline = "SELECT * FROM timeline_section";
$resultTimeline = $conn->query($sqlTimeline);

// Fetch data for projects section
$sqlProjects = "SELECT * FROM projects_section";
$resultProjects = $conn->query($sqlProjects);

// Fetch data for achievements section
$sqlAchievements = "SELECT * FROM achievements_section";
$resultAchievements = $conn->query($sqlAchievements);

// Fetch data for skills section
$sqlSkills = "SELECT * FROM skills_section";
$resultSkills = $conn->query($sqlSkills);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert data into the 'messages' table
    $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Sifat's Portfolio</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
    <h2>Admin Login</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="#" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <section id="header">
        <a href="#about">About</a>
        <a href="#timeline">Timeline</a>
        <a href="#projects">Projects</a>
        <a href="#achievements">Achievements</a>
        <a href="#skills">Skills</a>
        <a href="#contact">Contact</a>
    </section>
    <section id="about">
        <!-- Navigation Links... -->

        <!-- About Section Content -->
        <section id="profile">
            <?php
            if ($resultAbout->num_rows > 0) {
                $rowAbout = $resultAbout->fetch_assoc();
            ?>
                <div class="section__pic-container">
                    <img src="images/dp.jpg" alt="Profile picture" />
                </div>
                <div class="section__text">
                    <h1 class="title"><?php echo $rowAbout['title']; ?></h1>
                    <p class="section__text__p2"><?php echo $rowAbout['content']; ?></p>
                    <div id="socials-container">
                        <img src="./images/linkedin.png" class="icon" onclick="window.open('<?php echo $rowAbout['linkedin_url']; ?>')" />
                        <img src="./images/github.png" class="icon" onclick="window.open('<?php echo $rowAbout['github_url']; ?>')" />
                        <img src="./images/facebook.png" class="icon" onclick="window.open('<?php echo $rowAbout['facebook_url']; ?>')" />
                        <img src="./images/insta.png" class="icon" onclick="window.open('<?php echo $rowAbout['instagram_url']; ?>')" />
                    </div>
                </div>
            <?php
            } else {
                echo "No data available for the about section.";
            }
            ?>
        </section>
    </section>

    <!-- Timeline Section Content -->
    <hr class="divide" />
    <section id="timeline">
        <h1 class="title">Timeline</h1>
        <div>
            <ul>
                <?php
                while ($rowTimeline = $resultTimeline->fetch_assoc()) {
                    echo '<div class="circle"></div>';
                    echo '<li class="timeline-list">';
                    echo "<h1 onclick=\"window.open('{$rowTimeline['link']}')\">{$rowTimeline['title']}</h1>";
                    echo "<h2>{$rowTimeline['location']}</h2>";
                    echo "<h2>{$rowTimeline['duration']}</h2>";
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </section>

    <!-- Projects Section Content -->
    <hr class="divide" />
    <section id="projects">
        <h1 class="title">My Projects</h1>
        <div>
            <ul>
                <?php
                while ($rowProjects = $resultProjects->fetch_assoc()) {
                    echo '<div class="circle"></div>';
                    echo '<li class="timeline-list">';
                    echo "<h1>{$rowProjects['title']}</h1>";
                    echo "<h2 onclick=\"window.open('{$rowProjects['git_link']}')\"><b>Git Link</b></h2>";
                    echo "<p>{$rowProjects['description']}</p>";
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </section>

    <!-- Achievements Section Content -->
    <hr class="divide" />
    <section id="achievements">
        <h1 class="title">My Achievements</h1>

        <div class="achievements-container">
            <div class="about-container">
                <?php
                while ($rowAchievements = $resultAchievements->fetch_assoc()) {
                    echo '<div class="details-container acv-details-container">';
                    echo "<h3 class=\"acv-title\">{$rowAchievements['title']}<br /></h3>";
                    echo "<p>{$rowAchievements['description']}</p>";
                    echo '<div class="btn-container">';
                    echo "<button class=\"btn btn-color-2 acv-button\" onclick=\"window.open('{$rowAchievements['certificate_link']}')\">";
                    echo 'View';
                    echo '</button>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Skills Section Content -->
    <hr class="divide" />
    <section id="skills">
        <h1 class="title">My Skills</h1>

        <div class="skills-container">
            <div class="about-container">
                <?php
                while ($rowSkills = $resultSkills->fetch_assoc()) {
                    echo '<div class="details-container acv-details-container">';
                    echo "<h3 class=\"acv-title\">{$rowSkills['title']}<br /></h3>";
                    echo "<p>{$rowSkills['description']}</p>";
                    echo '<div class="btn-container">';
                    echo "<button class=\"btn btn-color-2 acv-button\" onclick=\"window.open('{$rowSkills['certificate_link']}')\">";
                    echo 'Attachement';
                    echo '</button>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Contact Section Content -->
    <section id="contact">
        <h1>Contact Me</h1>
        <p>Feel free to reach out to me through the following channels:</p>

        <!-- Contact Form -->
        <form action="#" method="post">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Your Message" rows="4" required></textarea>
            <button type="submit">Send Message</button>
        </form>


        <!-- Contact Details -->
        <div>
            <p>Email: sifatashrarul@gmail.com</p>
            <p>Address: Dept. of CSE, KUET, Khulna, Bangladesh</p>
        </div>
    </section>

    <hr class="divide" />
    <script src="script.js"></script>
</body>

</html>