<?php
// Start session and include the database connection file
session_start();
include 'db.php'; // Ensure db.php contains your database connection code

// Initialize variables
$title = $content = "";
$title_error = $content_error = $success_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_error = "Title is required.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate content
    if (empty(trim($_POST["content"]))) {
        $content_error = "Content is required.";
    } else {
        $content = trim($_POST["content"]);
    }

    // If no errors, insert into the database
    if (empty($title_error) && empty($content_error)) {
        $sql = "INSERT INTO articles (title, content, created_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ss", $title, $content);

            if ($stmt->execute()) {
                $success_message = "Blog added successfully!";
                $title = $content = ""; // Clear form fields
            } else {
                $error_message = "Error: " . $conn->error;
            }

            $stmt->close();
        } else {
            $error_message = "Database error: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Include your CSS -->
</head>
<body>
    <div class="container">
        <h1>Add a New Blog</h1>

        <?php if (!empty($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="add-blog.php" method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title); ?>">
                <span class="error"><?php echo $title_error; ?></span>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" rows="5"><?php echo htmlspecialchars($content); ?></textarea>
                <span class="error"><?php echo $content_error; ?></span>
            </div>

            <div class="form-group">
                <button type="submit">Add Blog</button>
            </div>
        </form>

        <a href="index.php">Back to Articles</a>
    </div>
</body>
</html>
