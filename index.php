<?php
include './vendor/autoload.php';
include './functions/database.php';

$db = dbConnect(
    user: 'root',
    pass: '',
    db: 'kdg-todo'
);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $todoText = $_POST['todo'] ?? null;

    if (!empty($todoText)) {
        addToDo($db, $todoText);
    }

    if (isset($_POST['check'])) {
        checkTodo($db, $_POST['id']);
    }

    if (isset($_POST['uncheck'])) {
        unCheckTodo($db, $_POST['id']);
    }

    if (isset($_POST['delete'])) {
        deleteTodo($db, $_POST['id']);
    }
}

$todos = getTodos($db);
?>

<?php include './snippets/layout/header.php'; ?>

<div class="text-3xl text-center font-bold mb-3 uppercase">Todo List</div>

<?php include './snippets/todo/add.php'; ?>

<div class="bg-gray-100 mt-5 p-5 rounded-xl shadow-lg text-gray-700">
    <h1 class="font-bold text-xl italic">Todo's</h1>
    <small class="block mb-5 mt-0 text-xs text-gray-500">
        <?= getPendingCount($db); ?> Todos pending <?= getCompletedCount($db); ?> Completed.
    </small>

    <?php include './snippets/todo/all.php'; ?>
</div>

<?php include './snippets/layout/footer.php'; ?>