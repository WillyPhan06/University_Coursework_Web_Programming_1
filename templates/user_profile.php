<div class="user-profile">
    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success"><?=htmlspecialchars($successMessage)?></div>
    <?php endif; ?>
    
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-error"><?=htmlspecialchars($errorMessage)?></div>
    <?php endif; ?>

    <div class="profile-header">
        <div class="avatar-section">
            <?php if (!empty($user['avatar'])): ?>
                <img src="images/avatars/<?=htmlspecialchars($user['avatar'])?>" alt="<?=htmlspecialchars($user['name'])?>" class="profile-avatar">
            <?php else: ?>
                <div class="profile-avatar-placeholder">No Avatar</div>
            <?php endif; ?>
            
            <?php if ($isOwnProfile): ?>
                <div class="avatar-actions">
                    <form method="post" action="" enctype="multipart/form-data" style="margin-top:10px;">
                        <input type="hidden" name="action" value="upload_avatar">
                        <input type="file" name="avatar" id="avatar" accept="image/*" style="display:none;" onchange="this.form.submit()">
                        <label for="avatar" style="padding:6px 12px; background:#5cb85c; color:white; border-radius:3px; cursor:pointer; display:inline-block; font-size:0.9em;">
                            <?=!empty($user['avatar']) ? 'Change Avatar' : 'Upload Avatar'?>
                        </label>
                    </form>
                    
                    <?php if (!empty($user['avatar'])): ?>
                        <form method="post" action="" style="margin-top:5px;">
                            <input type="hidden" name="action" value="delete_avatar">
                            <button type="submit" onclick="return confirm('Delete your avatar?');" style="padding:6px 12px; background:#d9534f; color:white; border:none; border-radius:3px; cursor:pointer; font-size:0.9em;">
                                Delete Avatar
                            </button>
                        </form>
                    <?php endif; ?>
                    <p style="margin-top:5px; font-size:0.85em; color:#666;">Max 2MB (JPG, PNG, GIF)</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="profile-info">
            <h2><?=htmlspecialchars($user['name'])?></h2>
            <p><strong>Username:</strong> <?=htmlspecialchars($user['username'])?></p>
            <p><strong>Email:</strong> <?=htmlspecialchars($user['email'])?></p>
            <p><strong>Joined:</strong> <?=htmlspecialchars(date('M d, Y', strtotime($user['created_at'])))?></p>
            <p><strong>Role:</strong> <?=htmlspecialchars($user['role'] === 'admin' ? 'Administrator' : 'User')?></p>
        </div>
    </div>

    <div class="profile-content">
        <h3>Questions Posted (<?=count($userQuestions)?>)</h3>
        <?php if (empty($userQuestions)): ?>
            <p>No questions yet.</p>
        <?php else: ?>
            <div class="questions-list">
                <?php foreach ($userQuestions as $q): ?>
                    <article class="question-card">
                        <h4><a href="question.php?id=<?=htmlspecialchars($q['id'])?>"><?=htmlspecialchars(substr($q['questiontext'], 0, 100))?></a></h4>
                        <p><strong>Module:</strong> <?=htmlspecialchars($q['modulename'] ?? 'Unassigned')?></p>
                        <p><small>Posted on <?=htmlspecialchars(date('M d, Y H:i', strtotime($q['date'])))?></small></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="profile-content">
        <h3>Comments Posted (<?=count($userComments)?>)</h3>
        <?php if (empty($userComments)): ?>
            <p>No comments yet.</p>
        <?php else: ?>
            <div class="comments-list">
                <?php foreach ($userComments as $c): ?>
                    <article class="comment-card">
                        <p><?=htmlspecialchars($c['text'])?></p>
                        <p><small>On question: <a href="question.php?id=<?=htmlspecialchars($c['questionid'])?>"><?=htmlspecialchars(substr($c['questiontext'], 0, 80))?></a></small></p>
                        <p><small>Posted on <?=htmlspecialchars(date('M d, Y H:i', strtotime($c['date'])))?></small></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
