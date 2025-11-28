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
                    <form method="post" action="" enctype="multipart/form-data" class="avatar-upload-form">
                        <input type="hidden" name="action" value="upload_avatar">
                        <input type="file" name="avatar" id="avatar" accept="image/*" class="avatar-input" onchange="this.form.submit()">
                        <label for="avatar" class="avatar-label">
                            <?=!empty($user['avatar']) ? 'Change Avatar' : 'Upload Avatar'?>
                        </label>
                    </form>
                    
                    <?php if (!empty($user['avatar'])): ?>
                        <form method="post" action="" class="avatar-delete-form">
                            <input type="hidden" name="action" value="delete_avatar">
                            <button type="submit" onclick="return confirm('Delete your avatar?');" class="btn-delete-avatar">
                                Delete Avatar
                            </button>
                        </form>
                    <?php endif; ?>
                    <p class="avatar-note">Max 2MB (JPG, PNG, GIF)</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="profile-info">
            <h2><?=htmlspecialchars($user['name'])?></h2>
            
            <?php if ($isOwnProfile): ?>
                <div class="edit-name-section">
                    <form method="post" action="" class="edit-name-form">
                        <input type="hidden" name="action" value="update_name">
                        <div class="form-group-inline">
                            <label for="name">Edit Name:</label>
                            <input type="text" id="name" name="name" value="<?=htmlspecialchars($user['name'])?>" 
                                   required minlength="2" maxlength="100" class="name-input">
                            <button type="submit" class="btn-update-name">Update</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
            
            <p><strong>Username:</strong> <?=htmlspecialchars($user['username'])?> <span class="info-note">(cannot be changed)</span></p>
            <p><strong>Email:</strong> <?=htmlspecialchars($user['email'])?> <span class="info-note">(cannot be changed)</span></p>
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
    
    <?php if ($isOwnProfile): ?>
    <!-- Delete Account Section -->
    <div class="profile-content danger-zone">
        <h3 class="danger-title">Danger Zone</h3>
        <div class="danger-container">
            <h4 class="danger-heading">Delete Your Account</h4>
            <p class="danger-text">
                <strong>Warning:</strong> This action cannot be undone. Deleting your account will permanently remove:
            </p>
            <ul class="danger-list">
                <li>Your profile and personal information</li>
                <li>All your questions and posts</li>
                <li>All your comments</li>
                <li>Your avatar and uploaded images</li>
            </ul>
            
            <details class="danger-details">
                <summary class="danger-summary">
                    I understand the consequences, show me the delete option
                </summary>
                
                <form method="post" action="" class="danger-form">
                    <input type="hidden" name="action" value="delete_account">
                    
                    <div class="form-group">
                        <label for="delete_password" class="danger-label">
                            Enter your password to confirm account deletion:
                        </label>
                        <input type="password" 
                               id="delete_password" 
                               name="password" 
                               required 
                               minlength="6"
                               placeholder="Your current password"
                               class="danger-input">
                    </div>
                    
                    <button type="submit" 
                            class="btn btn-danger"
                            onclick="return confirm('Are you ABSOLUTELY sure you want to delete your account? This action cannot be undone and all your data will be permanently lost!');">
                        Delete My Account Permanently
                    </button>
                </form>
            </details>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    .profile-content h3 {
        border-bottom: 2px solid #4a90e2;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .question-card h4 a {
        color: #4a90e2;
        text-decoration: none;
    }

    .question-card h4 a:hover {
        text-decoration: underline;
    }

</style>