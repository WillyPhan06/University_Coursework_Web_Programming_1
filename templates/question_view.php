<article>
    <h2><?=htmlspecialchars($question['text'])?></h2>
    <p><strong>Module:</strong> <?=htmlspecialchars($question['modulename'] ?? 'Unassigned')?></p>
    <p><strong>Author:</strong> <?=htmlspecialchars($question['username'] ?? 'Unknown')?></p>
    <p><small>Posted on <?=htmlspecialchars($question['date'])?></small></p>
    <?php if (!empty($question['img'])): ?>
        <div>
            <img src="images/<?=htmlspecialchars($question['img'])?>" style="max-width:400px;" alt="">
        </div>
    <?php endif; ?>
    <p>
        <a href="admin/editquestion.php?id=<?=htmlspecialchars($question['id'])?>">Edit</a>
        | <a href="index.php">Back</a>
    </p>
</article>
