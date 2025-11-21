<h2><?=htmlspecialchars($title)?></h2>
<?php if (!empty($error)): ?>
    <div style="color:red;">Error: <?=htmlspecialchars($error)?></div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <p>
        <label for="questiontext">Question text</label><br>
        <textarea name="questiontext" rows="6" cols="80"><?=isset($question) ? htmlspecialchars($question['text']) : ''?></textarea>
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
            <div>Current: <img src="images/<?=htmlspecialchars($question['img'])?>" style="max-width:100px; display:block;"></div>
        <?php endif; ?>
    </p>

    <?php if (isset($question)): ?>
        <input type="hidden" name="id" value="<?=htmlspecialchars($question['id'])?>">
    <?php endif; ?>

    <p>
        <input type="submit" value="Save">
        <a href="../index.php">Cancel</a>
    </p>
</form>
