<div class="admin-panel">
    <h2>Admin Panel</h2>
    <nav style="margin-bottom:12px;">
        <a href="#users" style="margin-right:10px;">Users (<?=count($allUsers)?>)</a>
        <a href="#modules" style="margin-right:10px;">Modules (<?=count($allModules)?>)</a>
        <a href="#questions" style="margin-right:10px;">Questions (<?=count($allQuestions)?>)</a>
        <a href="#comments">Comments (<?=count($allComments)?>)</a>
    </nav>
    
    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success"><?=htmlspecialchars($successMessage)?></div>
    <?php endif; ?>
    
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-error"><?=htmlspecialchars($errorMessage)?></div>
    <?php endif; ?>

    <div class="admin-section" id="users">
        <h3>Manage Users (<?=count($allUsers)?>)</h3>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allUsers as $u): ?>
                        <tr>
                            <td><?=htmlspecialchars($u['username'])?></td>
                            <td><?=htmlspecialchars($u['name'])?></td>
                            <td><?=htmlspecialchars($u['email'])?></td>
                            <td>
                                <?php if ($u['id'] != getCurrentUser()['id']): ?>
                                    <form action="" method="post" style="display:inline; margin:0;">
                                        <input type="hidden" name="action" value="edit_user_role">
                                        <input type="hidden" name="user_id" value="<?=htmlspecialchars($u['id'])?>">
                                        <select name="role" onchange="this.form.submit()" style="padding:5px; border:1px solid #ccc; border-radius:3px;">
                                            <option value="user" <?=$u['role'] === 'user' ? 'selected' : ''?>>User</option>
                                            <option value="admin" <?=$u['role'] === 'admin' ? 'selected' : ''?>>Admin</option>
                                        </select>
                                    </form>
                                <?php else: ?>
                                    <span style="color:#666; font-weight:bold;"><?=ucfirst($u['role'])?> (You)</span>
                                <?php endif; ?>
                            </td>
                            <td><?=htmlspecialchars(date('M d, Y', strtotime($u['created_at'])))?></td>
                            <td>
                                <?php if ($u['id'] != getCurrentUser()['id']): ?>
                                    <form action="" method="post" style="display:inline;">
                                        <input type="hidden" name="action" value="delete_user">
                                        <input type="hidden" name="user_id" value="<?=htmlspecialchars($u['id'])?>">
                                        <input type="submit" value="Delete" onclick="return confirm('Delete this user? This will also delete their questions and comments.');" style="background:#d9534f; color:white; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;">
                                    </form>
                                <?php else: ?>
                                    <span style="color:#999;">Current User</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-section" id="modules">
        <h3>Manage Modules (<?=count($allModules)?>)</h3>
        
        <!-- Add New Module Form -->
        <div style="background:#f0f8ff; padding:15px; border-radius:4px; margin-bottom:20px; border:1px solid #4a90e2;">
            <h4 style="margin-top:0; color:#4a90e2;">Add New Module</h4>
            <form action="" method="post" style="display:flex; gap:10px; align-items:flex-end;">
                <input type="hidden" name="action" value="add_module">
                <div style="flex:1;">
                    <label for="new_module_name" style="display:block; margin-bottom:5px; font-weight:bold;">Module Name:</label>
                    <input type="text" id="new_module_name" name="module_name" required maxlength="100" 
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;">
                </div>
                <button type="submit" style="padding:8px 16px; background:#5cb85c; color:white; border:none; border-radius:4px; cursor:pointer; font-weight:bold;">
                    Add Module
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Module Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allModules as $m): ?>
                        <tr>
                            <td>
                                <form action="" method="post" style="display:flex; gap:10px; align-items:center; margin:0;">
                                    <input type="hidden" name="action" value="edit_module">
                                    <input type="hidden" name="module_id" value="<?=htmlspecialchars($m['id'])?>">
                                    <input type="text" name="module_name" value="<?=htmlspecialchars($m['name'])?>" 
                                           required maxlength="100" 
                                           style="flex:1; padding:6px; border:1px solid #ccc; border-radius:3px;">
                                    <button type="submit" style="padding:5px 12px; background:#5cb85c; color:white; border:none; border-radius:3px; cursor:pointer;">
                                        Update
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="action" value="delete_module">
                                    <input type="hidden" name="module_id" value="<?=htmlspecialchars($m['id'])?>">
                                    <input type="submit" value="Delete" onclick="return confirm('Delete this module? Questions assigned to it will become unassigned.');" style="background:#d9534f; color:white; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-section" id="questions">
        <h3>Manage Questions (<?=count($allQuestions)?>)</h3>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Author</th>
                        <th>Question</th>
                        <th>Module</th>
                        <th>Posted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allQuestions as $q): ?>
                        <tr>
                            <td><?=htmlspecialchars($q['name'] ?? 'Unknown')?></td>
                            <td><?=htmlspecialchars(substr($q['questiontext'], 0, 50))?></td>
                            <td><?=htmlspecialchars($q['modulename'] ?? 'Unassigned')?></td>
                            <td><?=htmlspecialchars(date('M d, Y', strtotime($q['date'])))?></td>
                            <td>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="action" value="delete_question">
                                    <input type="hidden" name="question_id" value="<?=htmlspecialchars($q['id'])?>">
                                    <input type="submit" value="Delete" onclick="return confirm('Delete this question and its comments?');" style="background:#d9534f; color:white; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-section" id="comments">
        <h3>Manage Comments (<?=count($allComments)?>)</h3>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Author</th>
                        <th>Comment</th>
                        <th>Question</th>
                        <th>Posted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allComments as $c): ?>
                        <tr>
                            <td><?=htmlspecialchars($c['name'] ?? 'Unknown')?></td>
                            <td><?=htmlspecialchars(substr($c['text'], 0, 50))?></td>
                            <td><?=htmlspecialchars(substr($c['questiontext'] ?? '', 0, 30))?></td>
                            <td><?=htmlspecialchars(date('M d, Y', strtotime($c['date'])))?></td>
                            <td>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="action" value="delete_comment">
                                    <input type="hidden" name="comment_id" value="<?=htmlspecialchars($c['id'])?>">
                                    <input type="submit" value="Delete" onclick="return confirm('Delete this comment?');" style="background:#d9534f; color:white; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <p style="margin-top:30px;">
        <a href="../index.php" style="padding:8px 16px; background:#4a90e2; color:white; text-decoration:none; border-radius:4px; display:inline-block;">Back to Home</a>
    </p>
</div>