<h2><?=htmlspecialchars($title)?></h2>
<?php if (!empty($error)): ?>
    <div style="color:red; padding:10px; background:#ffe6e6; margin-bottom:15px; border-radius:4px;">Error: <?=htmlspecialchars($error)?></div>
<?php endif; ?>

<form action="" method="post">
    <div style="margin-bottom:15px;">
        <label for="text"><strong>Comment:</strong></label><br>
        <textarea name="text" id="text" rows="6" cols="80" required maxlength="5000" style="padding:8px; border:1px solid #ccc; border-radius:4px; width:100%; box-sizing:border-box;"><?=isset($comment) ? htmlspecialchars($comment['text']) : ''?></textarea>
        <small style="display:block; margin-top:5px; color:#666;">Max 5000 characters</small>
    </div>

    <div style="margin-bottom:15px;">
        <button type="submit" style="padding:8px 16px; background:#4a90e2; color:white; border:none; border-radius:4px; cursor:pointer;">Save</button>
        <a href="../question.php?id=<?=htmlspecialchars($comment['questionid'] ?? $_GET['qid'] ?? '')?>" style="padding:8px 16px; background:#ccc; color:#333; text-decoration:none; border-radius:4px; display:inline-block; margin-left:10px;">Cancel</a>
    </div>
</form>
