Student Q&A Coursework - starter app

This folder contains a minimal PHP + PDO app scaffold inspired by the provided `week_5` jokes example and the `cw_train` SQL dump.

Quick start (XAMPP on Windows):

1. Ensure MySQL has a database named `cw_train` and import the provided SQL dump `cw_train_21_11_2025.sql` into it.
2. Place this folder under `C:\xampp\htdocs` (already so in this workspace).
3. Open `includes/DatabaseConnection.php` and adjust DB credentials if needed.
4. Browse to `http://localhost/University_Coursework_Web_Programming_1/index.php`.

Files added:
- includes/DatabaseConnection.php
- includes/DataBaseFunctions.php
- index.php, question.php
- admin/addquestion.php, admin/editquestion.php, admin/deletequestion.php
- templates/* (layout, list, view, form)
- styles.css
- images/ (for uploads)

Notes:
- This is a minimal scaffold to get you started. Next steps: add user management, module CRUD, validation and security improvements, and a report.
