<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Blogger</title>
    <style>
        body { background-color: #f9fbe7; color: #333; font-family: Arial, sans-serif; }
        .post { padding: 10px; border: 1px solid #ccc; margin: 10px; }
        button { background-color: #4caf50; color: white; padding: 10px; border: none; }
    </style>
</head>
<body>
    <h1>Dashboard</h1>
    <a href="new-post.php">Create New Post</a>
    <div class="post">
        <h3>Post Title</h3>
        <p>Short description of the post...</p>
        <a href="edit.php?id=1">Edit</a> | <a href="delete.php?id=1">Delete</a>
    </div>
</body>
</html>
