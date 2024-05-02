<!-- pages/search_results.php -->

<h2>Search Results for: <?= esc($query) ?></h2>

<ul>
    <?php foreach ($pages as $page) : ?>
        <li class="list-group-item">
            <h3><?= esc($page['title']) ?></h3>
            <p><?= esc($page['content']) ?></p>
        </li>
        <hr>
    <?php endforeach; ?>
</ul>
