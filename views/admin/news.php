<?php require_once __DIR__ . '/../partials/header.php'; ?>

<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Release date</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
        <?php /** @var News $news */ foreach($viewModel->getNews() as $news): ?>
            <tr>
                <td><?php echo safeString($news->getTitle()) ?></td>
                <td><?php echo safeString($news->getDescription()) ?></td>
                <td><?php echo safeString($news->getReleaseDate()->format("d/m/Y")) ?></td>
                <td></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>