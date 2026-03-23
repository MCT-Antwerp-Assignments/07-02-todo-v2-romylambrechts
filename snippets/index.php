<?php
include './vendor/autoload.php';
require './classes/Todo.php';


$pdo = new PDO('mysql:host=127.0.0.1;dbname=kdg-todo;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$todoApp = new Todo($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['todo'])) {
        $todoApp->add($_POST['todo']);
    }

    if (isset($_POST['check'])) {
        $todoApp->check($_POST['id']);
    }

    if (isset($_POST['uncheck'])) {
        $todoApp->uncheck($_POST['id']);
    }

    if (isset($_POST['delete'])) {
        $todoApp->delete($_POST['id']);
    }
}


$todos = $todoApp->getTodos();
?>

<?php include './snippets/layout/header.php'; ?>

<div class="text-3xl text-center font-bold mb-3 uppercase">Todo List</div>

<?php include './snippets/todo/add.php'; ?>

<div class="bg-gray-100 mt-5 p-5 rounded-xl shadow-lg text-gray-700">
    <h1 class="font-bold text-xl italic">Todo's</h1>
    <small class="block mb-5 mt-0 text-xs text-gray-500">
        <?= $todoApp->getPendingCount(); ?>Todos pending<?= $todoApp->getCompletedCount(); ?> Completed.
    </small>

    <?php include './snippets/todo/all.php'; ?>
</div>

<?php include './snippets/layout/footer.php'; ?>