<div class="user-profile">
    <div class="profile-header">
        <?php if (!empty($user['avatar'])): ?>
            <img src="images/avatars/<?=htmlspecialchars($user['avatar'])?>" alt="<?=htmlspecialchars($user['name'])?>" class="profile-avatar">
        <?php else: ?>
            <div class="profile-avatar-placeholder">No Avatar</div>
        <?php endif; ?>
        
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

<style>
    .user-profile {
        max-width: 800px;
        margin: 20px auto;
    }

    .profile-header {
        display: flex;
        align-items: flex-start;
        gap: 30px;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 4px;
        margin-bottom: 30px;
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #4a90e2;
    }

    .profile-avatar-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        border: 3px solid #ccc;
    }

    .profile-info h2 {
        margin-top: 0;
        margin-bottom: 15px;
    }

    .profile-info p {
        margin: 8px 0;
        line-height: 1.5;
    }

    .profile-content {
        margin-bottom: 30px;
    }

    .profile-content h3 {
        border-bottom: 2px solid #4a90e2;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .questions-list, .comments-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .question-card, .comment-card {
        padding: 15px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .question-card h4 {
        margin: 0 0 10px 0;
    }

    .question-card h4 a {
        color: #4a90e2;
        text-decoration: none;
    }

    .question-card h4 a:hover {
        text-decoration: underline;
    }

    .comment-card p:first-child {
        margin: 0 0 10px 0;
        color: #333;
    }

    .comment-card small {
        color: #666;
    }

    @media (max-width: 600px) {
        .profile-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }
</style>
