<?php
session_set_cookie_params(31536000, '/');
session_start();

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    $task = trim($_POST['task']);
    if ($task !== '') {
        $_SESSION['tasks'][] = $task;
    }
    header('Location: index.php');
    exit;
}

if (isset($_GET['remove']) && isset($_SESSION['tasks'][(int)$_GET['remove']])) {
    unset($_SESSION['tasks'][(int)$_GET['remove']]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']);
    header('Location: index.php');
    exit;
}

$tasks = $_SESSION['tasks'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List Manager</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f5f7fb; }
        .container { max-width: 700px; margin: 0 auto; }
        .panel { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        form { display: flex; gap: 10px; margin-bottom: 20px; }
        input[type="text"] { flex: 1; padding: 10px; }
        button { padding: 10px 16px; background: #1976d2; color: white; border: none; border-radius: 6px; cursor: pointer; }
        ul { list-style: none; padding: 0; }
        li { display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; border-bottom: 1px solid #eee; }
        .remove { color: #d32f2f; text-decoration: none; }
        .session-box { margin-top: 20px; padding: 12px; background: #e8f5e9; border: 1px solid #c8e6c9; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="panel">
            <h1>Task List Manager</h1>

            <form method="post" action="index.php">
                <input type="text" name="task" placeholder="Enter a task" required>
                <button type="submit">Add Task</button>
            </form>

            <?php if (empty($tasks)): ?>
                <p>No tasks yet.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($tasks as $index => $task): ?>
                        <li>
                            <span><?php echo htmlspecialchars($task); ?></span>
                            <a class="remove" href="index.php?remove=<?php echo $index; ?>">Remove</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="session-box">
                <strong>Session ID:</strong> <?php echo htmlspecialchars(session_id()); ?>
            </div>
        </div>
    </div>
</body>
</html>
