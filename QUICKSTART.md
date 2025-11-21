# Quick Start Guide

## Getting Started in 5 Minutes

### 1. Import Database
```bash
mysql -u root cw_train < cw_train_21_11_2025.sql
```

### 2. Access the Site
Open: `http://localhost/University_Coursework_Web_Programming_1/`

### 3. Test User Accounts
Login with any of these:
- **Username**: `admin_user` | **Password**: `password` (Admin)
- **Username**: `willyphan` | **Password**: `password` (User)
- **Username**: `alice_nguyen` | **Password**: `password` (User)

Or create a new account via **Register** button.

---

## Main Features to Try

### 👤 User System
1. Register a new account
2. Click on any author name to view their profile
3. See your posted questions and comments on your profile

### ❓ Questions
1. Login, then click "Add Question"
2. Write a question, optionally select module and upload image
3. Click question to view it
4. Click "Edit" (only if you're the author)
5. Click "Delete" (only if you're the author or admin)

### 💬 Comments
1. On any question, click "Add a Comment"
2. Write and submit your comment
3. Edit/delete your own comments
4. If you're the post owner, you can delete any comment on your post

### 👨‍💼 Admin Features (Use admin_user account)
1. Click "Admin Panel" in top right
2. Manage users (view and delete)
3. Manage questions (view and delete)
4. Manage comments (view and delete)
5. Manage modules (view and delete)

### 📧 Contact Form
1. Click "Contact" in navigation
2. Fill out the form and submit
3. Admin receives email with your message

---

## File Locations for Quick Reference

| What | Where |
|------|-------|
| Home page | `/index.php` |
| Login | `/login.php` |
| Register | `/register.php` |
| Profile | `/profile.php?username=willyphan` |
| Question view | `/question.php?id=1` |
| Add question | `/admin/addquestion.php` |
| Admin panel | `/admin/admin_panel.php` |
| Contact form | `/contact.php` |

---

## Key Features

✅ **User Authentication** - Register and login
✅ **Own Posts** - Create, edit, delete your questions
✅ **Comments** - Comment on any question
✅ **User Profiles** - View other users' activity
✅ **Admin Panel** - Manage all users, posts, comments
✅ **Avatar Display** - User profile pictures throughout site
✅ **Contact Form** - Email the administrator
✅ **Responsive Design** - Works on mobile and desktop

---

## Troubleshooting

**Can't login?**
- Make sure database was imported
- Use one of the test accounts listed above

**Can't see questions?**
- Check that images folder exists: `images/`
- Check that avatars folder exists: `images/avatars/`

**Can't add questions?**
- You must be logged in
- Use Register button to create account first

**Email not sending?**
- Check server has mail() enabled
- Update `$ADMIN_EMAIL` in `/contact.php`

---

For detailed documentation, see README.md
