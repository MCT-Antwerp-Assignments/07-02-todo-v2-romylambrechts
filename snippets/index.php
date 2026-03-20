<?php
include './functions/database.php';

$db = dbConnect(
    user: 'root',
    pass: '',
    db: 'kdg-todo'
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $todo = $_POST['todo'];

    if (!empty($todo)) {
        addTodo($db, $_Post['todo']);
    }
}

$todos = getTodos ($db);
?>



<?php include './snippets/layout/header.php'; ?>

<div class="text-3xl text-center font-bold mb-3 uppercase">Todo List</div>

<?php include './snippets/todo/add.php'; ?>

<div class="bg-gray-100 mt-5 p-5 rounded-xl shadow-lg text-gray-700">
    <h1 class="font-bold text-xl italic block mb-0 leading-none">Todo's</h1>
    <small class="block mb-5 mt-0 text-xs text-gray-500"><?= getPendingCount($db); ?> Todos pending, <?= getCompletedCount($db); ?>  Completed.</small>
    <?php include './snippets/todo/all.php' ?>
</div>

<?php include './snippets/layout/footer.php'; ?>