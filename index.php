<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$servername = "localhost";
$username = "ucmg2yy4f50w9";
$password = "int2rs0tyyae";
$dbname = "dbn8my0kjcwsbu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT title, content, created_at FROM articles ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);
$title = "Welcome to My Blogger";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }

        /* Header Styles */
        header {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1.5rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header h1 {
            color: #1a73e8;
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            gap: 2rem;
        }

        nav ul li a {
            text-decoration: none;
            color: #555;
            font-weight: 500;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }

        nav ul li a:hover {
            color: #1a73e8;
            background-color: #f0f7ff;
        }

        /* Main Content */
        main {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 1.5rem;
        }

        section h2 {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-bottom: 2.5rem;
            text-align: center;
            font-weight: 600;
        }

        /* Article Cards */
        article {
            background: #ffffff;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        article:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        article h3 {
            color: #1a73e8;
            font-size: 1.6rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .article-meta {
            margin-bottom: 1.5rem;
            color: #666;
            font-size: 0.9rem;
        }

        .date {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .date::before {
            content: "📅";
        }

        article p {
            color: #4a4a4a;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .read-more {
            display: inline-block;
            color: #1a73e8;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            padding: 0.5rem 0;
        }

        .read-more:hover {
            color: #1557b0;
        }

        .read-more::after {
            content: " →";
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .read-more:hover::after {
            transform: translateX(5px);
        }

        /* No Articles Message */
        .no-articles {
            text-align: center;
            padding: 3rem;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .no-articles p {
            color: #666;
            font-size: 1.1rem;
        }

        /* Footer */
        footer {
            background-color: #ffffff;
            border-top: 1px solid #eaeaea;
            padding: 2rem 0;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-content p {
            color: #666;
        }

        .social-links {
            display: flex;
            gap: 1.5rem;
        }

        .social-links a {
            color: #1a73e8;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: #1557b0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header h1 {
                font-size: 1.8rem;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            main {
                margin: 2rem auto;
            }

            article {
                padding: 1.5rem;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }

            .social-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1><?php echo $title; ?></h1>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Latest Articles</h2>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $date = new DateTime($row['created_at']);
                    echo "<article>";
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    echo "<div class='article-meta'>";
                    echo "<span class='date'>" . $date->format('F j, Y') . "</span>";
                    echo "</div>";
                    // Get first 250 characters of content for preview
                    $preview = substr(strip_tags($row['content']), 0, 250);
                    if (strlen($row['content']) > 250) {
                        $preview .= '...';
                    }
                    echo "<p>" . nl2br(htmlspecialchars($preview)) . "</p>";
                    echo "<a href='#' class='read-more'>Read More</a>";
                    echo "</article>";
                }
            } else {
                echo "<div class='no-articles'>";
                echo "<p>No articles available at the moment.</p>";
                echo "</div>";
            }
            $conn->close();
            ?>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2025 My Blogger. All rights reserved.</p>
            <div class="social-links">
                <a href="#">Twitter</a>
                <a href="#">Facebook</a>
                <a href="#">Instagram</a>
            </div>
        </div>
    </footer>
</body>
</html>
