<h2><?=htmlspecialchars($title)?></h2>
<?php if (!empty($error)): ?>
    <div style="color:red; padding:10px; background:#ffe6e6; margin-bottom:15px; border-radius:4px;">Error: <?=htmlspecialchars($error)?></div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <p>
        <label for="questiontext">Question text</label><br>
        <textarea name="questiontext" rows="6" cols="80" required><?=isset($question) ? htmlspecialchars($question['text']) : ''?></textarea>
    </p>

    <p>
        <label for="moduleid">Module</label><br>
        <select name="moduleid">
            <option value="">None</option>
            <?php foreach ($modules as $m): ?>
                <option value="<?=htmlspecialchars($m['id'])?>" <?=isset($question) && $question['moduleid']==$m['id'] ? 'selected' : ''?>><?=htmlspecialchars($m['name'])?></option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label for="questionimage">Optional image</label><br>
        <input type="file" name="questionimage" accept="image/*">
        <?php if (!empty($question['img'])): ?>
            <div style="margin-top:10px;">
                <strong>Current image:</strong><br>
                <img src="images/questions/<?=htmlspecialchars($question['img'])?>" style="max-width:200px; display:block; margin-top:5px; border:1px solid #ddd; padding:5px;">
            </div>
        <?php endif; ?>
    </p>

    <?php if (isset($question)): ?>
        <input type="hidden" name="id" value="<?=htmlspecialchars($question['id'])?>">
    <?php endif; ?>

    <p>
        <input type="submit" value="Save">
        <a href="index.php">Cancel</a>
    </p>
</form>