<div class="auth-container">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    
    <form method="post" action="">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required
                   value="<?=htmlspecialchars($_POST['username'] ?? '')?>">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="register.php" class="btn btn-secondary">Create an account</a>
        </div>
    </form>
</div>
