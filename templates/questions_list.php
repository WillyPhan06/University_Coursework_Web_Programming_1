<h2>Questions</h2>
<?php if (empty($questions)): ?>
    <p>No questions yet.</p>
<?php else: ?>
    <?php foreach ($questions as $q): ?>
        <article style="border-bottom:1px solid #ddd; padding:10px 0;">
            <?php if (!empty($q['img'])): ?>
                <div style="float:right; max-width:160px; margin-left:10px;">
                    <img src="images/<?=htmlspecialchars($q['img'])?>" style="max-width:100%;" alt="">
                </div>
            <?php endif; ?>
            <h3><a href="question.php?id=<?=htmlspecialchars($q['id'])?>"><?=htmlspecialchars(substr($q['questiontext'],0,120))?></a></h3>
            <p><strong>Module:</strong> <?=htmlspecialchars($q['modulename'] ?? 'Unassigned')?> &nbsp; <strong>By:</strong> <?=htmlspecialchars($q['username'] ?? 'Unknown')?></p>
            <p><small>Posted on <?=htmlspecialchars($q['date'])?></small></p>
            <p>
                <a href="admin/editquestion.php?id=<?=htmlspecialchars($q['id'])?>">Edit</a> |
                <form action="admin/deletequestion.php" method="post" style="display:inline; margin:0;">
                    <input type="hidden" name="id" value="<?=htmlspecialchars($q['id'])?>">
                    <input type="submit" value="Delete" onclick="return confirm('Delete this question?');">
                </form>
            </p>
            <div style="clear:both;"></div>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
