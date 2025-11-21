# Student Q&A Platform - Complete Implementation

A PHP PDO + MySQL mini student Q&A platform (similar to StackOverflow) with user authentication, post management, comments, and admin panel.

## Features Implemented

### Core Features
- ✅ Display list of questions/posts
- ✅ Add, edit, delete questions (owners and admins only)
- ✅ Display images in posts
- ✅ Manage users (registration, login, profiles)
- ✅ Module management
- ✅ Posts assigned to authors and modules

### Authentication & User Management
- ✅ User registration with validation
- ✅ Secure login with password hashing (bcrypt)
- ✅ Session management
- ✅ User logout
- ✅ User profile pages with avatar display
- ✅ Profile shows user's posts and comments

### Comments System
- ✅ Add comments to posts
- ✅ Edit own comments
- ✅ Delete own comments
- ✅ Post owners can delete any comment on their post
- ✅ Admin can delete any comment

### Admin Features
- ✅ Admin panel for managing users, posts, comments, modules
- ✅ Delete user accounts
- ✅ Delete any post
- ✅ Delete any comment
- ✅ Delete modules
- ✅ Admin cannot edit (view-only operations for admin management)

### Additional Features
- ✅ Contact form with email notification
- ✅ User avatars displayed next to posts and comments
- ✅ User profile links (author names link to profile pages)
- ✅ Responsive design
- ✅ Form validation (server-side)
- ✅ Accessibility considerations (focus states, semantic HTML)

## Database Schema

### Tables
1. **user** - User accounts with roles (user/admin)
   - id, username, name, email, password, role, avatar, created_at

2. **question** - Posts/questions
   - id, text, date, userid, moduleid, img

3. **module** - Subject modules
   - id, name

4. **comment** - Comments on questions
   - id, text, date, userid, questionid

## Installation & Setup

### 1. Database Setup
```sql
-- Import the SQL file
mysql -u root < cw_train_21_11_2025.sql
```

### 2. Configure Database Connection
Edit `includes/DatabaseConnection.php` if needed:
```php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=cw_train;charset=utf8mb4', 'root', '');
```

### 3. Configure Admin Email (for contact form)
Edit `contact.php` and set your admin email:
```php
$ADMIN_EMAIL = 'your-email@example.com';
```

### 4. Create Avatar Directory
Ensure the following directories exist:
- `images/` (for question images)
- `images/avatars/` (for user avatars)

### 5. Access the Application
- Browse to: `http://localhost/University_Coursework_Web_Programming_1/index.php`

## Default Test Accounts

| Username | Password | Role |
|----------|----------|------|
| willyphan | password | User |
| alice_nguyen | password | User |
| bob_tran | password | User |
| admin_user | password | Admin |
| testuser | password | User |

(Note: All test accounts use the password "password" - hashed with bcrypt in the database)

## File Structure

```
├── index.php                    # Home page - list of questions
├── login.php                    # Login page
├── register.php                 # Registration page
├── logout.php                   # Logout handler
├── profile.php                  # User profile page
├── question.php                 # Single question view with comments
├── contact.php                  # Contact form
├── styles.css                   # Global CSS styles
├── cw_train_21_11_2025.sql     # Database dump
│
├── includes/
│   ├── DatabaseConnection.php   # PDO connection
│   └── DataBaseFunctions.php    # All database functions & session management
│
├── admin/
│   ├── admin_panel.php          # Admin management dashboard
│   ├── addquestion.php          # Add question (requires login)
│   ├── editquestion.php         # Edit question (owner/admin only)
│   ├── deletequestion.php       # Delete question (owner/admin only)
│   ├── addcomment.php           # Add comment (requires login)
│   ├── editcomment.php          # Edit comment (owner/admin only)
│   └── deletecomment.php        # Delete comment (owner/post-owner/admin)
│
├── templates/
│   ├── layout.php               # Main HTML template
│   ├── questions_list.php       # List of all questions
│   ├── question_view.php        # Single question + comments
│   ├── question_form.php        # Form for add/edit question
│   ├── comment_form.php         # Form for add/edit comment
│   ├── register_form.php        # Registration form
│   ├── login_form.php           # Login form
│   ├── user_profile.php         # User profile display
│   ├── contact_form.php         # Contact form
│   └── admin_panel.php          # Admin management interface
│
├── images/
│   ├── (question images)
│   └── avatars/
│       └── (user avatar images)
│
└── README.md                    # This file
```

## Key Functions in DataBaseFunctions.php

### Session Management
- `startUserSession()` - Start PHP session
- `getCurrentUser()` - Get logged-in user data
- `isLoggedIn()` - Check if user is logged in
- `isAdmin()` - Check if current user is admin

### Authentication
- `registerUser($pdo, $username, $name, $email, $password)` - Register new user
- `loginUser($pdo, $username, $password)` - Authenticate user
- `logoutUser()` - Destroy session
- `getUserById($pdo, $id)` - Get user by ID
- `getUserByUsername($pdo, $username)` - Get user by username

### Questions
- `allQuestions($pdo)` - Get all questions
- `getQuestion($pdo, $id)` - Get single question with author/module info
- `insertQuestion($pdo, $text, $userid, $moduleid, $img)` - Create question
- `updateQuestion($pdo, $id, $text, $moduleid, $img)` - Update question
- `deleteQuestion($pdo, $id)` - Delete question (cascades to comments)

### Comments
- `insertComment($pdo, $text, $userid, $questionid)` - Create comment
- `getCommentsByQuestion($pdo, $questionid)` - Get all comments for a question
- `getComment($pdo, $id)` - Get single comment
- `updateComment($pdo, $id, $text)` - Update comment
- `deleteComment($pdo, $id)` - Delete comment

### Modules
- `allModules($pdo)` - Get all modules
- `insertModule($pdo, $name)` - Create module (admin only)
- `updateModule($pdo, $id, $name)` - Update module (admin only)
- `deleteModule($pdo, $id)` - Delete module (admin only)

## Permission Model

| Action | Anonymous | User | Question Owner | Post Owner | Admin |
|--------|-----------|------|---|---|-------|
| View questions | ✅ | ✅ | ✅ | ✅ | ✅ |
| View profile | ✅ | ✅ | ✅ | ✅ | ✅ |
| Add question | ❌ | ✅ | ✅ | ✅ | ✅ |
| Edit own question | ❌ | ✅ | ✅ | ✅ | ✅ |
| Delete own question | ❌ | ✅ | ✅ | ✅ | ✅ |
| Add comment | ❌ | ✅ | ✅ | ✅ | ✅ |
| Edit own comment | ❌ | ✅ | ✅ | ✅ | ✅ |
| Delete own comment | ❌ | ✅ | ✅ | ✅ | ✅ |
| Delete comment on own post | ❌ | ❌ | ❌ | ✅ | ✅ |
| Admin Panel | ❌ | ❌ | ❌ | ❌ | ✅ |
| Delete any user | ❌ | ❌ | ❌ | ❌ | ✅ |
| Delete any post | ❌ | ❌ | ❌ | ❌ | ✅ |
| Delete any comment | ❌ | ❌ | ❌ | ❌ | ✅ |
| Delete module | ❌ | ❌ | ❌ | ❌ | ✅ |

## Security Features

- ✅ Password hashing with bcrypt (password_hash/password_verify)
- ✅ SQL injection prevention (prepared statements with PDO)
- ✅ Session-based authentication
- ✅ Permission checks on edit/delete operations
- ✅ Input validation (server-side)
- ✅ HTML escaping in output (htmlspecialchars)
- ✅ Email validation

## Browser Compatibility

- Chrome/Chromium
- Firefox
- Safari
- Edge
- Mobile browsers

## Technologies Used

- **Backend**: PHP 7.4+ (PDO)
- **Database**: MySQL 5.7+ / MariaDB 10.4+
- **Frontend**: HTML5, CSS3, JavaScript (for form validation)
- **Server**: XAMPP / Apache

## Notes for Coursework

This implementation fully addresses the COMP1841 requirements:

1. **Display list of questions** ✅ - index.php
2. **Add/edit/delete questions** ✅ - admin/add/edit/deletequestion.php
3. **Display images** ✅ - question.php and templates
4. **Send email (contact form)** ✅ - contact.php
5. **Manage users** ✅ - register.php, login.php, profile.php
6. **Manage modules** ✅ - admin_panel.php
7. **Assign to author/module** ✅ - Via question_form.php (auto assigns author from session)
8. **Extra features** ✅ - Authentication, admin panel, comments, user profiles, contact form

### Additional Items for Report

- Accessibility: Uses semantic HTML5, focus states, ARIA considerations
- GDPR: Data minimization, user control, consent (implicit in registration)
- Security: Password hashing, prepared statements, input validation, permission checks
- Testing: All CRUD operations work, permission controls enforced, edge cases handled

## Future Enhancements

- Email verification for registration
- Password reset functionality
- Search functionality
- Pagination for large datasets
- Rate limiting
- File upload restrictions
- Avatar upload for users
- Like/vote system for questions
- Category tags for questions
- Email notifications

## Support & Troubleshooting

### Database Connection Issues
- Ensure MySQL is running
- Check credentials in `includes/DatabaseConnection.php`
- Verify database `cw_train` exists

### Email Not Sending
- Check if your server has mail() enabled
- Update `$ADMIN_EMAIL` in `contact.php`
- Some hosts require SMTP configuration

### Permission Denied Errors
- Ensure `images/` and `images/avatars/` directories exist and are writable
- Check file permissions: `chmod 755 images/`

### Session Issues
- Clear browser cookies
- Ensure PHP sessions are enabled in php.ini
- Check disk space for session storage

