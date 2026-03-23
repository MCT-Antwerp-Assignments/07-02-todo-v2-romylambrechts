<div class="max-h-80 overflow-y-auto">
    <table class="table w-full">
        <thead>
            <tr>
                <th class="text-center px-1 py-2 bg-orange-500 text-orange-100 rounded-tl-xl">#</th>
                <th class="text-left px-1 py-2 bg-orange-500 text-orange-100">Details</th>
                <th class="px-1 py-2 bg-orange-500 text-orange-100 rounded-tr-xl">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($todos) === 0): ?>
            <tr>
                <td colspan="3" class="text-center px-1 py-2 text-orange-800">No Todos found. Add a few to begin.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($todos as $nr => $todo): ?>
                <tr class="odd:bg-orange-100 even:bg-orange-50">
                    <td class="text-center px-1 py-2 text-orange-800 <?= $todo['done'] ? 'line-through' : ''; ?>">
                        <?= $nr + 1; ?>
                    </td>
                    <td class="px-1 py-2 text-orange-800 <?= $todo['done'] ? 'line-through' : ''; ?>">
                        <?= $todo['text']; ?>
                    </td>
                    <td class="text-center px-1 py-2 text-orange-800 flex gap-3 justify-start">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $todo['id']; ?>" />
                            <?php if ($todo['done'] == 0): ?>
                                <button class="text-orange-600" name="check" value="1">✔</button>
                            <?php else: ?>
                                <button class="text-orange-600" name="uncheck" value="1">✖</button>
                            <?php endif; ?>
                            <button class="text-orange-600" name="delete" value="1">🗑</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>