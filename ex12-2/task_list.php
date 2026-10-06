<?php
session_set_cookie_params(31536000, '/');
session_start();

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_task'])) {
    $task = trim($_POST['new_task']);
    if ($task !== '') {
        $_SESSION['tasks'][] = $task;
    }
}

if (isset($_GET['clear']) && $_GET['clear'] === '1') {
    $_SESSION['tasks'] = [];
}

$tasks = $_SESSION['tasks'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .container { max-width: 600px; margin: 0 auto; }
        .task-form { margin-bottom: 20px; }
        input[type="text"] { width: 70%; padding: 10px; }
        button { padding: 10px 16px; }
        ul { list-style: disc; padding-left: 20px; }
        a { color: #1976d2; }
        .session-box { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Task List</h1>

        <form class="task-form" method="post" action="task_list.php">
            <input type="text" name="new_task" placeholder="Add a task" required>
            <button type="submit">Add</button>
        </form>

        <p><a href="task_list.php?clear=1">Clear All Tasks</a> | <a href="index.php">Back to main page</a></p>

        <?php if (empty($tasks)): ?>
            <p>No tasks in the list.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($tasks as $task): ?>
                    <li><?php echo htmlspecialchars($task); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="session-box">
            <strong>Session ID:</strong> <?php echo htmlspecialchars(session_id()); ?>
        </div>
    </div>
</body>
</html>
