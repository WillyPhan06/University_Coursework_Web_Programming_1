<div class="contact-container">
    <h2>Contact Us</h2>

    <p class="text-center text-muted mb-20">
        Have a question or feedback? We'd love to hear from you!
    </p>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <strong>Success!</strong> Your message has been sent successfully. We'll get back to you as soon as possible!
        </div>
        <p class="text-center mt-20">
            <a href="index.php" class="btn btn-primary">Return to Home</a>
        </p>
    <?php else: ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Name: <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" required minlength="2" maxlength="100"
                       value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                       placeholder="Enter your full name">
            </div>

            <div class="form-group">
                <label for="email">Email: <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" required maxlength="100"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="your.email@example.com">
            </div>

            <div class="form-group">
                <label for="subject">Subject: <span class="text-danger">*</span></label>
                <input type="text" id="subject" name="subject" required minlength="3" maxlength="200"
                       value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>"
                       placeholder="What is this regarding?">
            </div>

            <div class="form-group">
                <label for="message">Message: <span class="text-danger">*</span></label>
                <textarea name="message" id="message" rows="8" required minlength="10" maxlength="5000"
                          placeholder="Type your message here..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                <small>Minimum 10 characters, maximum 5000 characters</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Send Message</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    <?php endif; ?>
</div>
