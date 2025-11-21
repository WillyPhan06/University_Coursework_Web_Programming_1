<article>
    <h2><?=htmlspecialchars($question['text'])?></h2>
    <p><strong>Module:</strong> <?=htmlspecialchars($question['modulename'] ?? 'Unassigned')?></p>
    
    <div style="display:flex; align-items:center; gap:10px; margin:10px 0;">
        <?php if (!empty($question['avatar'])): ?>
            <a href="profile.php?username=<?=htmlspecialchars($question['username'])?>">
                <img src="images/avatars/<?=htmlspecialchars($question['avatar'])?>" 
                     style="width:40px; height:40px; border-radius:50%; object-fit:cover;" 
                     alt="<?=htmlspecialchars($question['name'])?>">
            </a>
        <?php endif; ?>
        <p style="margin:0;">
            <strong>Author:</strong> 
            <a href="profile.php?username=<?=htmlspecialchars($question['username'])?>" style="text-decoration:none; color:#4a90e2;">
                <?=htmlspecialchars($question['name'] ?? 'Unknown')?>
            </a>
        </p>
    </div>
    
    <p><small>Posted on <?=htmlspecialchars($question['date'])?></small></p>
    
    <?php if (!empty($question['img'])): ?>
        <div style="margin:15px 0;">
            <img src="images/<?=htmlspecialchars($question['img'])?>" style="max-width:400px;" alt="">
        </div>
    <?php endif; ?>
    
    <p style="margin-top:20px;">
        <?php 
        $currentUser = getCurrentUser();
        $isOwner = ($currentUser && $currentUser['id'] == $question['userid']);
        $isAdmin = isAdmin();
        if ($isOwner):
        ?>
            <a href="admin/editquestion.php?id=<?=htmlspecialchars($question['id'])?>">Edit</a>
            | <form action="admin/deletequestion.php" method="post" style="display:inline; margin:0;">
                <input type="hidden" name="id" value="<?=htmlspecialchars($question['id'])?>">
                <input type="submit" value="Delete" onclick="return confirm('Delete this question?');" style="background:none; border:none; color:#d9534f; cursor:pointer; text-decoration:underline; padding:0;">
            </form>
        <?php elseif ($isAdmin): ?>
            <form action="admin/deletequestion.php" method="post" style="display:inline; margin:0;">
                <input type="hidden" name="id" value="<?=htmlspecialchars($question['id'])?>">
                <input type="submit" value="Delete" onclick="return confirm('Delete this question?');" style="background:none; border:none; color:#d9534f; cursor:pointer; text-decoration:underline; padding:0;">
            </form>
        <?php endif; ?>
        | <a href="index.php">Back</a>
    </p>
</article>

<!-- Comments Section -->
<div style="margin-top:40px; padding-top:20px; border-top:2px solid #ddd;">
    <h3>Comments (<?=count($comments)?>)</h3>
    
    <?php if (!isLoggedIn()): ?>
        <p><a href="login.php">Login</a> to add a comment.</p>
    <?php else: ?>
        <div style="margin-bottom:30px; padding:15px; background:#f9f9f9; border-radius:4px;">
            <p><a href="admin/addcomment.php?qid=<?=htmlspecialchars($question['id'])?>">Add a Comment</a></p>
        </div>
    <?php endif; ?>
    
    <?php if (empty($comments)): ?>
        <p>No comments yet.</p>
    <?php else: ?>
        <div style="display:flex; flex-direction:column; gap:20px;">
            <?php foreach ($comments as $c): ?>
                <div style="padding:15px; background:#f9f9f9; border-radius:4px; border-left:4px solid #4a90e2;">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                        <?php if (!empty($c['avatar'])): ?>
                            <a href="profile.php?username=<?=htmlspecialchars($c['username'])?>">
                                <img src="images/avatars/<?=htmlspecialchars($c['avatar'])?>" 
                                     style="width:35px; height:35px; border-radius:50%; object-fit:cover;" 
                                     alt="<?=htmlspecialchars($c['username'])?>">
                            </a>
                        <?php endif; ?>
                        <strong>
                            <a href="profile.php?username=<?=htmlspecialchars($c['username'])?>" style="text-decoration:none; color:#4a90e2;">
                                <?=htmlspecialchars($c['username'] ?? 'Unknown')?>
                            </a>
                        </strong>
                        <small style="color:#666;"><?=htmlspecialchars(date('M d, Y H:i', strtotime($c['date'])))?></small>
                    </div>
                    <p style="margin:10px 0; line-height:1.5;"><?=htmlspecialchars($c['text'])?></p>
                    
                    <?php 
                    $isCommentOwner = ($currentUser && $currentUser['id'] == $c['userid']);
                    if ($isCommentOwner):
                    ?>
                        <div style="margin-top:10px;">
                            <a href="admin/editcomment.php?id=<?=htmlspecialchars($c['id'])?>">Edit</a>
                            | <form action="admin/deletecomment.php" method="post" style="display:inline; margin:0;">
                                <input type="hidden" name="id" value="<?=htmlspecialchars($c['id'])?>">
                                <input type="submit" value="Delete" onclick="return confirm('Delete this comment?');" style="background:none; border:none; color:#d9534f; cursor:pointer; text-decoration:underline; padding:0; font-size:0.9em;">
                            </form>
                        </div>
                    <?php elseif ($isAdmin && $currentUser && $currentUser['id'] != $c['userid']): ?>
                        <div style="margin-top:10px;">
                            <form action="admin/deletecomment.php" method="post" style="display:inline; margin:0;">
                                <input type="hidden" name="id" value="<?=htmlspecialchars($c['id'])?>">
                                <input type="submit" value="Delete" onclick="return confirm('Delete this comment?');" style="background:none; border:none; color:#d9534f; cursor:pointer; text-decoration:underline; padding:0; font-size:0.9em;">
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
