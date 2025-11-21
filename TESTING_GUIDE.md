# Testing Guide & Test Scenarios

## How to Test All Features

### Test Accounts Available
```
Admin Account:
  Username: admin_user
  Password: password
  
Regular Users:
  Username: willyphan / Password: password
  Username: alice_nguyen / Password: password
  Username: bob_tran / Password: password
  Username: testuser / Password: password
```

---

## Test Scenario 1: User Registration & Login

### Steps:
1. Go to http://localhost/University_Coursework_Web_Programming_1/
2. Click "Register" button
3. Fill in form:
   - Username: `testuser2025`
   - Name: `Test User`
   - Email: `test@example.com`
   - Password: `password123`
   - Confirm: `password123`
4. Click Register

### Expected Result:
- ✅ New account created
- ✅ Auto-logged in
- ✅ Redirected to home page
- ✅ Name appears in header "Hello, Test User!"

### Then Test Login/Logout:
1. Click "Logout"
2. Verify redirected to home
3. Name no longer shows in header
4. Click "Login"
5. Enter credentials
6. Click Login
7. Verify logged back in

---

## Test Scenario 2: Create & Edit Question

### Create:
1. Login as `willyphan`
2. Click "Add Question"
3. Fill form:
   - Question text: "What is the best way to learn PHP?"
   - Module: "Web Development"
   - Upload image: (optional)
4. Click Save

### Expected Result:
- ✅ Question appears on home page
- ✅ Shows author name "Willy Phan" with avatar
- ✅ Shows module "Web Development"
- ✅ Shows current date/time

### Edit:
1. On home page, find your question
2. Click "Edit" button
3. Change text: "What is the best way to learn modern PHP?"
4. Change module to "Python Basics"
5. Click Save

### Expected Result:
- ✅ Question updated
- ✅ New module shows
- ✅ Timestamp updated
- ✅ Can't edit if not owner

### Test Permission:
1. Login as `alice_nguyen`
2. Go to home page
3. Find Willy's question
4. Verify NO "Edit" button appears
5. Only see "View" link

---

## Test Scenario 3: Comments System

### Add Comment:
1. Click on a question
2. Scroll to comments section
3. Login if not already logged in
4. Click "Add a Comment"
5. Write: "This is a great question! I struggled with this too."
6. Click Save

### Expected Result:
- ✅ Comment appears under question
- ✅ Shows commenter name with avatar
- ✅ Shows timestamp
- ✅ Shows "Edit" and "Delete" buttons if your comment

### Edit Comment:
1. Find your comment
2. Click "Edit"
3. Change text
4. Click Save

### Expected Result:
- ✅ Comment text updated
- ✅ Timestamp updated (shows "edited")

### Delete Comment:
1. Find your comment
2. Click "Delete"
3. Click OK on confirmation

### Expected Result:
- ✅ Comment removed from page
- ✅ Comments count decreases

### Test Post Owner Delete:
1. Login as post owner (question author)
2. Go to a question with comments
3. See comment from another user
4. Click "Delete" on their comment
5. Confirm

### Expected Result:
- ✅ Comment deleted (post owner can delete any comment)
- ✅ Only post owner or admin can do this

---

## Test Scenario 4: User Profiles

### View Your Profile:
1. Click on your name in header: "My Profile"
2. Or click any author name on questions list

### Expected Result:
- ✅ Profile page loads
- ✅ Shows user avatar (large, circular)
- ✅ Shows username, email, role, join date
- ✅ Lists user's questions
- ✅ Lists user's comments
- ✅ All questions are clickable links

### Test Profile Links:
1. Go to home page
2. Find any question
3. Click on author name
4. Verify profile loads for that user
5. See their questions and comments

---

## Test Scenario 5: Admin Panel

### Access Admin Panel:
1. Login as `admin_user`
2. Click "Admin Panel" in navigation
3. Verify page loads with 4 sections

### Section 1 - Manage Users:
1. See table with all users
2. Try to delete a non-admin user
3. Click Delete, confirm
4. Verify user removed

### Expected Result:
- ✅ User deleted
- ✅ Can't delete yourself (button disabled)

### Section 2 - Manage Modules:
1. See all modules
2. Click Delete on a module
3. Confirm deletion

### Expected Result:
- ✅ Module deleted
- ✅ Questions assigned to it become "Unassigned"

### Section 3 - Manage Questions:
1. See all questions with authors
2. Click Delete on a question
3. Confirm deletion

### Expected Result:
- ✅ Question deleted
- ✅ All comments on that question also deleted

### Section 4 - Manage Comments:
1. See all comments with authors
2. Click Delete on a comment
3. Confirm deletion

### Expected Result:
- ✅ Comment deleted
- ✅ Removed from question view

### Test Admin-Only Access:
1. Login as regular user
2. Try to visit: /admin/admin_panel.php
3. Verify 403 Forbidden error

---

## Test Scenario 6: Contact Form

### Send Message:
1. Click "Contact" in navigation
2. Fill form:
   - Name: "John Smith"
   - Email: "john@example.com"
   - Subject: "Question about the platform"
   - Message: "I love this Q&A platform!"
3. Click Send Message

### Expected Result:
- ✅ Success message appears: "Message sent successfully"
- ✅ Form clears
- ✅ Admin email receives notification
- ✅ Email has reply-to set to sender

### Test Validation:
1. Try to submit with empty fields
2. Verify error message
3. Try invalid email format
4. Verify error message

---

## Test Scenario 7: Permission Checks

### Test Create Question (requires login):
1. Logout or clear session
2. Try to access /admin/addquestion.php
3. Verify redirected to login

### Test Edit Question (owner only):
1. Login as `bob_tran`
2. Try to edit someone else's question (change URL)
3. Verify 403 Forbidden error
4. Only can edit own questions

### Test Admin Panel (admin only):
1. Login as regular user
2. Try to access /admin/admin_panel.php
3. Verify 403 Forbidden error
4. Only admin can access

### Test Comment Edit (owner/admin):
1. Login as commenter
2. Can edit own comment ✅
3. Cannot edit others' comments ✅
4. Admin can edit any ✅

### Test Comment Delete (three-way):
1. Login as commenter
2. Can delete own ✅
3. Post owner can delete ✅
4. Admin can delete ✅

---

## Test Scenario 8: Image Upload

### Upload Question Image:
1. Click "Add Question"
2. Fill question text
3. Click "Choose File"
4. Select image (JPEG/PNG/GIF under 3MB)
5. Submit

### Expected Result:
- ✅ Image uploaded to /images/ folder
- ✅ Image displays on question page
- ✅ Image displays on list (small, right-aligned)
- ✅ Circular avatar displays (separate)

### Test File Validation:
1. Try uploading file > 3MB
2. Verify error: "Image is too large"
3. Try uploading wrong format (TXT)
4. Verify error: "Invalid image uploaded"

---

## Test Scenario 9: Form Validation

### Registration Validation:
1. Try short username (< 3 chars): ❌ Error
2. Try duplicate username: ❌ Error
3. Try invalid email: ❌ Error
4. Try short password (< 6 chars): ❌ Error
5. Try mismatched passwords: ❌ Error

### Question Validation:
1. Try empty question text: ❌ Error
2. Empty questions allowed: ✅ OK

### Comment Validation:
1. Try empty comment: ❌ Error
2. Try > 5000 chars: ❌ Error

### Contact Validation:
1. Try empty fields: ❌ Error
2. Try invalid email: ❌ Error
3. Try > 5000 char message: ❌ Error

---

## Test Scenario 10: Avatar Display

### Check Avatar Sizes:
1. **Home page (questions list)**: 50x50px circular
2. **Question page (question author)**: 40x40px circular
3. **Comments section**: 35x35px circular
4. **User profile page**: 150x150px circular

### Check Avatar Fallback:
1. User without avatar shows: "No Avatar" placeholder
2. Click on placeholder doesn't break anything

### Check Avatar Links:
1. Click avatar → goes to user profile
2. Click name → goes to user profile
3. Both should work

---

## Test Scenario 11: Responsive Design

### Desktop View (1200px+):
1. Open in desktop browser
2. All elements display properly
3. Navigation on one line
4. Comments layout correct

### Tablet View (768px-1199px):
1. Resize browser or use device
2. Layout should adjust
3. Navigation might wrap
4. All features work

### Mobile View (< 768px):
1. Access on mobile or use device emulation
2. Single column layout
3. Avatar displays properly
4. Forms are usable
5. All features accessible

---

## Test Scenario 12: Session Management

### Test Session Persistence:
1. Login as user
2. Close browser tab (not whole browser)
3. Reopen same website
4. Verify still logged in

### Test Session Timeout:
1. Login
2. Wait (or manually delete session file)
3. Refresh page
4. Should be logged out

### Test Multiple Sessions:
1. Login as User A
2. Open new incognito window
3. Login as User B
4. Verify separate sessions work
5. Logout B, User A still logged in

---

## Checklist for Complete Testing

- [ ] Registration (valid/invalid)
- [ ] Login/Logout
- [ ] Add question with/without image
- [ ] Edit own question
- [ ] Cannot edit others' questions
- [ ] Delete own question
- [ ] Add comment
- [ ] Edit own comment
- [ ] Cannot edit others' comments
- [ ] Delete own comment
- [ ] Post owner can delete any comment
- [ ] Admin can access admin panel
- [ ] Admin can delete users/posts/comments
- [ ] User profiles load correctly
- [ ] Avatars display at all sizes
- [ ] Author names link to profiles
- [ ] Contact form sends email
- [ ] Form validation works
- [ ] Image upload works
- [ ] Image validation works
- [ ] Responsive design works
- [ ] Sessions persist correctly
- [ ] Permissions enforced

---

## Expected Test Results

✅ All tests should pass
✅ No errors in browser console
✅ All features functional
✅ Permissions properly enforced
✅ Data saves correctly
✅ UI responsive
✅ Forms validate

## Notes

- Use browser developer tools (F12) to monitor console
- Check network tab for failed requests
- Test in Chrome, Firefox, Safari, Edge
- Test on mobile devices if possible
- Clear browser cache between tests

---

Ready to test! Have fun exploring the platform! 🎉
