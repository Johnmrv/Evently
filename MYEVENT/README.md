# Evently - Event Management System

A professional event management platform that allows organizers to create events, admins to approve them, and users to browse and register for approved events.

## 🎨 Design Philosophy

- **Color Scheme**: Vibrant green (#00C853) with clean white themes
- **Style**: Youthful, eye-catching, professional
- **No Hover Animations**: Clean, static interactions
- **No Drop Shadows**: Flat, modern design

## 📋 Project Overview

Evently is a role-based event management system with three main user types:

1. **Organizer**: Creates and manages events
2. **Admin**: Approves events and manages the platform
3. **User**: Browses approved events and registers to participate

## 🔄 Workflow

1. **Organizer** posts a new event (status: Pending)
2. **Admin** reviews and approves/rejects the event
3. **User** browses only approved events
4. **User** registers for an event (status: Pending)
5. **Organizer** reviews and approves/declines user registrations

## 📁 Project Structure

```
Evently/
│
├── admin/
│   ├── dashboard.php           # System Overview & Stats
│   ├── manage-users.php        # View users, ban/delete users
│   ├── verify-organizers.php   # Approve new organizer accounts
│   ├── event-approvals.php     # [KEY FEATURE] Approve/Reject events
│   └── reports.php             # Activity logs
│
├── organizer/
│   ├── dashboard.php           # Organizer stats (My events, Pending bookings)
│   ├── create-event.php        # Post a new event (Status = Pending)
│   ├── my-events.php           # Edit/Delete my events
│   └── manage-bookings.php     # [KEY FEATURE] Approve/Decline user registrations
│
├── user/
│   ├── dashboard.php           # User Dashboard (Stats: Events Joined, Pending)
│   ├── browse-events.php       # View ONLY Admin-approved events
│   ├── event-details.php       # Event details and registration form
│   ├── my-bookings.php         # Check status of bookings (Pending/Approved)
│   └── profile.php             # User profile & settings
│
├── css/
│   └── styles.css              # Main Theme: Vibrant Green, Light, Professional
│
├── js/
│   └── main.js                 # Frontend interactions
│
├── assets/                     # Images, Icons, Logos (to be added)
│
├── index.php                   # Landing Page (Home)
├── login.php                   # Universal Login
├── register.php                # Universal Registration
├── logout.php                  # Session Destroy
└── README.md                   # Project Documentation
```

## 👥 Team Assignments

### 🟦 Member 1 (TRISTAN) – Authentication & User Roles

**Responsibilities:**
- Create user table in database
- Implement user registration backend
- Implement user login backend
- Create user role system (Admin, Organizer, User)
- Add role validation for restricted pages
- Create login page UI (already provided)
- Create registration page UI (already provided)
- Add password validation (minimum length, required fields)
- Create logout function
- Test login/register roles (Admin/Organizer/User)
- Fix bugs related to authentication

**Files to Implement Backend:**
- `login.php` - Handle login form submission
- `register.php` - Handle registration form submission
- `logout.php` - Session destruction
- `admin/dashboard.php` - Dashboard counts (users, events)
- `admin/manage-users.php` - View users, ban/delete users
- `admin/verify-organizers.php` - Approve organizer accounts
- `admin/event-approvals.php` - Approve/reject events
- `admin/reports.php` - Activity logs

### 🟩 Member 2 (STEFFI) – Event Management

**Responsibilities:**
- Create events table in the database
- Build "Create Event" backend logic
- Build "Edit Event" backend logic
- Build "Delete Event" backend logic
- Create event form UI (create) - already provided
- Create event form UI (edit) - to be implemented
- Create events list UI - already provided
- Create event details UI - already provided
- Add validation for event fields
- Restrict event creation to Organizer/Admin roles
- Test all event CRUD functions

**Files to Implement Backend:**
- `organizer/create-event.php` - Handle event creation form
- `organizer/my-events.php` - Display, edit, delete events
- `organizer/dashboard.php` - Organizer statistics

### 🟧 Member 3 (GERO) – Registration & Participants

**Responsibilities:**
- Create participant/registration table in database
- Build "Register for Event" backend logic
- Build participant list backend logic
- Add limit checking for participants
- Create "Register" button UI inside event details - already provided
- Create participant list UI page - already provided
- Link participant list only for Organizer/Admin
- Prevent duplicate registration
- Display my registered events (user side)
- Show total available slots (user side)
- Cancel event registration (user side)

**Files to Implement Backend:**
- `user/event-details.php` - Handle event registration
- `user/my-bookings.php` - Display user's bookings, cancel registration
- `user/browse-events.php` - Display approved events only
- `user/dashboard.php` - User statistics
- `organizer/manage-bookings.php` - Approve/decline user registrations

### 🟪 Member 4 (JANRO) – User Profile & Dashboard

**Responsibilities:**
- Create user profile page UI - already provided
- Backend for updating user profile
- Add profile picture upload (optional/simple)
- Display user information
- Create dashboard backend for counts (users, events)
- Create dashboard UI (cards showing counts) - already provided
- Add filtering options (optional simple)
- Show upcoming events on dashboard
- Create home page layout - already provided
- Test dashboard counts
- Test profile update and viewing

**Files to Implement Backend:**
- `user/profile.php` - Handle profile updates, password changes
- `index.php` - Home page logic (if needed)
- `css/styles.css` - UI/Design (already provided)

## 🎯 Key Features

### Admin Features
- **Event Approvals**: Review and approve/reject events posted by organizers
- **User Management**: View, ban, or delete user accounts
- **Organizer Verification**: Approve new organizer accounts
- **System Reports**: View activity logs and system statistics

### Organizer Features
- **Create Events**: Post new events (pending admin approval)
- **Manage Events**: Edit or delete created events
- **Manage Bookings**: Approve or decline user registration requests
- **Dashboard**: View statistics (events, bookings, participants)

### User Features
- **Browse Events**: View only admin-approved events
- **Register for Events**: Submit registration requests
- **My Bookings**: View booking status (pending/approved)
- **Cancel Registration**: Cancel event registrations
- **Profile Management**: Update profile information

## 🚀 Getting Started

### Prerequisites
- PHP 7.4 or higher
- MySQL/MariaDB database
- Web server (Apache/Nginx) or XAMPP/WAMP

### Installation

1. Clone or download the project to your web server directory
   ```
   C:\xampp\htdocs\MYEVENT
   ```

2. Create a database for the project
   ```sql
   CREATE DATABASE evently_db;
   ```

3. Configure database connection (create `config/database.php` or similar)
   ```php
   <?php
   $host = 'localhost';
   $dbname = 'evently_db';
   $username = 'root';
   $password = '';
   ```

4. Each team member should implement their respective backend logic as outlined in the Team Assignments section

5. Access the application:
   - Landing Page: `http://localhost/MYEVENT/`
   - Login: `http://localhost/MYEVENT/login.php`
   - Register: `http://localhost/MYEVENT/register.php`

## 📝 Database Schema (To be implemented by team)

### Users Table (TRISTAN)
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- fullname (VARCHAR)
- email (VARCHAR, UNIQUE)
- password (VARCHAR, HASHED)
- role (ENUM: 'admin', 'organizer', 'user')
- status (ENUM: 'active', 'banned', 'pending')
- created_at (DATETIME)
```

### Events Table (STEFFI)
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- organizer_id (INT, FOREIGN KEY)
- title (VARCHAR)
- description (TEXT)
- event_date (DATE)
- event_time (TIME)
- location (VARCHAR)
- max_participants (INT)
- category (VARCHAR)
- contact_email (VARCHAR)
- contact_phone (VARCHAR)
- status (ENUM: 'pending', 'approved', 'rejected')
- created_at (DATETIME)
```

### Registrations Table (GERO)
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- event_id (INT, FOREIGN KEY)
- user_id (INT, FOREIGN KEY)
- fullname (VARCHAR)
- email (VARCHAR)
- phone (VARCHAR)
- notes (TEXT)
- status (ENUM: 'pending', 'approved', 'declined', 'cancelled')
- registered_at (DATETIME)
```

## 🎨 UI/UX Guidelines

- **Color Palette**:
  - Primary Green: `#00C853`
  - Dark Green: `#00A844`
  - Light Green: `#4CAF50`
  - Background Green: `#E8F5E9`
  - White: `#FFFFFF`

- **Design Principles**:
  - No hover animations
  - No drop shadows
  - Clean, flat design
  - Vibrant and youthful
  - Professional appearance

- **Navigation**:
  - Menu bar on every dashboard page
  - Consistent navigation across all pages
  - Clear active state indicators

## 📋 Implementation Checklist

### Phase 1: Database & Authentication (TRISTAN)
- [ ] Create database tables
- [ ] Implement user registration
- [ ] Implement user login
- [ ] Implement role-based access control
- [ ] Test authentication flow

### Phase 2: Event Management (STEFFI)
- [ ] Create events table
- [ ] Implement event creation
- [ ] Implement event editing
- [ ] Implement event deletion
- [ ] Add event validation

### Phase 3: Registration System (GERO)
- [ ] Create registrations table
- [ ] Implement event registration
- [ ] Implement booking approval/decline
- [ ] Add participant limit checking
- [ ] Prevent duplicate registrations

### Phase 4: Profile & Dashboard (JANRO)
- [ ] Implement profile update
- [ ] Add profile picture upload
- [ ] Implement dashboard statistics
- [ ] Add filtering options

## 🔒 Security Considerations

- Hash passwords using PHP `password_hash()` and `password_verify()`
- Use prepared statements for all database queries
- Validate and sanitize all user inputs
- Implement CSRF protection for forms
- Use session management for authentication
- Restrict file uploads (profile pictures) to safe types and sizes

## 📞 Support

For questions or issues, contact the respective team member based on the feature area.

## 📄 License

This project is for educational purposes.

---

**Note**: This is a frontend UI/UX implementation. All backend logic needs to be implemented by the respective team members as outlined in the Team Assignments section.

