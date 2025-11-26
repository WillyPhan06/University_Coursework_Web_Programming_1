<h2>Questions</h2>
<?php if (empty($questions)): ?>
    <p>No questions yet.</p>
<?php else: ?>
    <?php foreach ($questions as $q): ?>
        <article style="border-bottom:1px solid #ddd; padding:10px 0; display:flex; gap:15px;">
            <!-- User Avatar -->
            <div style="flex-shrink:0;">
                <?php if (!empty($q['avatar'])): ?>
                    <a href="profile.php?username=<?=htmlspecialchars($q['username'])?>">
                        <img src="images/avatars/<?=htmlspecialchars($q['avatar'])?>" 
                             style="width:50px; height:50px; border-radius:50%; object-fit:cover;" 
                             alt="<?=htmlspecialchars($q['name'])?>">
                    </a>
                <?php else: ?>
                    <div style="width:50px; height:50px; border-radius:50%; background:#ddd; display:flex; align-items:center; justify-content:center; color:#999;">
                        <small>N/A</small>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Question Content -->
            <div style="flex-grow:1;">
                <?php if (!empty($q['img'])): ?>
                    <div style="float:right; max-width:160px; margin-left:10px;">
                        <img src="images/<?=htmlspecialchars($q['img'])?>" style="max-width:100%;" alt="">
                    </div>
                <?php endif; ?>
                <h3><a href="question.php?id=<?=htmlspecialchars($q['id'])?>"><?=htmlspecialchars(substr($q['questiontext'],0,120))?></a></h3>
                <p><strong>Module:</strong> <?=htmlspecialchars($q['modulename'] ?? 'Unassigned')?> &nbsp; 
                   <strong>By:</strong> <a href="profile.php?username=<?=htmlspecialchars($q['username'])?>" style="text-decoration:none; color:#4a90e2;"><?=htmlspecialchars($q['name'] ?? 'Unknown')?></a></p>
                <p><small>Posted on <?=htmlspecialchars($q['date'])?></small></p>
                <p>
                        <?php 
                        $currentUser = getCurrentUser();
                        $isOwner = ($currentUser && $currentUser['id'] == $q['userid']);
                        $isAdmin = isAdmin();
                        if ($isOwner):
                        ?>
                            <a href="editquestion.php?id=<?=htmlspecialchars($q['id'])?>">Edit</a> |
                            <form action="deletequestion.php" method="post" style="display:inline; margin:0;">
                                <input type="hidden" name="id" value="<?=htmlspecialchars($q['id'])?>">
                                <input type="submit" value="Delete" onclick="return confirm('Delete this question?');" style="background:none; border:none; color:#d9534f; cursor:pointer; text-decoration:underline; padding:0;">
                            </form>
                        <?php elseif ($isAdmin): ?>
                            <form action="admin/deletequestion.php" method="post" style="display:inline; margin:0;">
                                <input type="hidden" name="id" value="<?=htmlspecialchars($q['id'])?>">
                                <input type="submit" value="Delete" onclick="return confirm('Delete this question?');" style="background:none; border:none; color:#d9534f; cursor:pointer; text-decoration:underline; padding:0;">
                            </form>
                        <?php else: ?>
                            <a href="question.php?id=<?=htmlspecialchars($q['id'])?>">View</a>
                        <?php endif; ?>
                </p>
                <div style="clear:both;"></div>
            </div>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
