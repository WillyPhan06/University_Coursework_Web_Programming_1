<div class="auth-container">
    <h2>Register</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    
    <form method="post" action="">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required minlength="3" maxlength="50"
                   value="<?=htmlspecialchars($_POST['username'] ?? '')?>">
            <small>3-50 characters, alphanumeric and underscores</small>
        </div>

        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required maxlength="100"
                   value="<?=htmlspecialchars($_POST['name'] ?? '')?>">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required maxlength="100"
                   value="<?=htmlspecialchars($_POST['email'] ?? '')?>">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required minlength="6">
            <small>At least 6 characters</small>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-secondary">Already have an account? Login</a>
        </div>
    </form>
</div>
