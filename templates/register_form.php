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

<style>
    .auth-container {
        max-width: 400px;
        margin: 40px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #f9f9f9;
    }
    
    .auth-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    
    .form-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    
    .form-group small {
        display: block;
        font-size: 0.85em;
        color: #666;
        margin-top: 3px;
    }
    
    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 20px;
    }
    
    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-primary {
        background: #4a90e2;
        color: white;
    }
    
    .btn-primary:hover {
        background: #357abd;
    }
    
    .btn-secondary {
        background: #ccc;
        color: #333;
    }
    
    .btn-secondary:hover {
        background: #bbb;
    }
    
    .alert {
        padding: 12px;
        margin-bottom: 15px;
        border-radius: 4px;
    }
    
    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
