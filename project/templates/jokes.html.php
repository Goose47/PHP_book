<p>
    <?=$totalJokes?> jokes have been submitted to IJDB.
</p>
<?php foreach ($jokes as $joke): ?>
    <blockquote>
        <p>
            <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8') . "<br>"?>
            (by <a href="mailto:<?php echo htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8');?></a> on
            <?php
            $date = new DateTime($joke['jokedate']);
            echo $date -> format('jS F Y');
            ?>)

            <br>
            <a href="index.php?route=joke/edit&id=<?=$joke['id'];?>">
                Edit
            </a>

            <form action = "index.php?route=joke/delete" method = "post">
                <input type = "hidden" name = "id" value = "<?=$joke['id']?>">
                <input type = "submit" value = "Delete">
            </form>
        </p>
    </blockquote>
<?php endforeach; ?>
