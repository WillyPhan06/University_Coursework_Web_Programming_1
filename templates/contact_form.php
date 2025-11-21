<div class="contact-container">
    <h2>Contact Us</h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success">Your message has been sent successfully. We'll get back to you soon!</div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required maxlength="100"
                   value="<?=htmlspecialchars($_POST['name'] ?? '')?>">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required maxlength="100"
                   value="<?=htmlspecialchars($_POST['email'] ?? '')?>">
        </div>

        <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required maxlength="200"
                   value="<?=htmlspecialchars($_POST['subject'] ?? '')?>">
        </div>

        <div class="form-group">
            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="8" required maxlength="5000"><?=htmlspecialchars($_POST['message'] ?? '')?></textarea>
            <small>Max 5000 characters</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Send Message</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
    .contact-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #f9f9f9;
    }

    .contact-container h2 {
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

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    .form-group textarea {
        resize: vertical;
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

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
</style>
