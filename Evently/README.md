# Evently - Event Management System

A professional event management and booking system built with PHP, MySQL, and jQuery. The system allows organizers to post venues, users to book events, and admins to manage the entire platform.

## Features

### User Roles

1. **Admin**
   - Approve/reject events posted by organizers
   - Manage users (ban, delete)
   - View system statistics and reports
   - Full system access

2. **Organizer**
   - Create and manage events/venues
   - Upload venue images
   - Set venue availability status
   - Approve/decline user booking requests
   - View booking statistics

3. **User**
   - Browse approved events
   - Search venues by name, address, or capacity
   - Book events with custom date, time, and event type
   - View booking status
   - Cancel pending bookings
   - Manage profile

### Key Features

- **Event Management**: Organizers can post venues with images, location, and capacity
- **Admin Approval**: All events require admin approval before going live
- **Smart Booking**: Users input their desired date, time, and event type
- **Date Availability**: Calendar automatically disables already booked dates
- **Search & Filter**: Users can search by venue name, address, and filter by capacity
- **Status Management**: Organizers can set venues as Available/Unavailable
- **Image Upload**: Support for venue and profile picture uploads
- **Responsive Design**: Modern UI with vibrant green theme

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- XAMPP/WAMP (for local development)

### Setup Instructions

1. **Clone or download the project**
   ```bash
   cd C:\xampp\htdocs\Events\Evently
   ```

2. **Create the database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `evently`
   - Import the `database.sql` file or run the SQL commands manually

3. **Configure database connection**
   - Edit `config.php` and update database credentials if needed:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "evently";
     ```

4. **Set up upload directories**
   - Create `uploads/` directory in the project root
   - Create `uploads/profiles/` directory for profile pictures
   - Ensure these directories have write permissions (chmod 777 on Linux/Mac)

5. **Access the application**
   - Open browser and navigate to: `http://localhost/Events/Evently/`
   - Default admin credentials:
     - Username: `admin`
     - Password: `admin123`

## Project Structure

```
Evently/
├── admin/
│   ├── dashboard.php           # Admin dashboard with statistics
│   ├── event-approvals.php     # Approve/reject events
│   └── manage-users.php        # User management
├── organizer/
│   ├── dashboard.php           # Organizer dashboard
│   ├── create-event.php        # Create new events
│   ├── my-events.php           # Manage events
│   └── manage-bookings.php     # Approve/decline bookings
├── user/
│   ├── dashboard.php           # User dashboard
│   ├── browse-events.php       # Browse and search events
│   ├── book-event.php          # Book an event
│   ├── my-bookings.php         # View bookings
│   └── profile.php             # User profile
├── ajax/
│   ├── check_date.php          # Check date availability
│   ├── update_event_status.php # Update event status
│   ├── update_booking_status.php # Update booking status
│   └── cancel_booking.php      # Cancel booking
├── includes/
│   ├── session.php            # Session management
│   └── navbar.php              # Navigation component
├── css/
│   └── styles.css             # Main stylesheet
├── js/
│   ├── jquery.min.js          # jQuery library
│   └── main.js                # Custom JavaScript
├── uploads/                   # Uploaded images
├── config.php                 # Database configuration
├── login.php                  # Login page
├── register.php               # Registration page
├── logout.php                 # Logout handler
├── index.php                  # Landing page
├── database.sql               # Database schema
└── README.md                  # This file
```

## Team Assignments

### Backend Development

- **TRISTAN** - Authentication & User Roles
  - Login/Registration system
  - User role management
  - Session handling
  - Admin user management

- **STEFFI** - Event Management
  - Event CRUD operations
  - Event status management
  - Venue image uploads
  - Event availability controls

- **GERO** - Registration & Participants
  - Booking system
  - Participant management
  - Date availability checking
  - Booking status updates

- **JANRO** - User Profile & Dashboard
  - User profile management
  - Dashboard statistics
  - Profile picture uploads
  - UI/UX Design

## Usage Guide

### For Administrators

1. **Login** with admin credentials
2. **Approve Events**: Go to "Event Approvals" to review and approve/reject events
3. **Manage Users**: Access "Manage Users" to ban or delete users
4. **View Statistics**: Dashboard shows system-wide statistics

### For Organizers

1. **Register** as an organizer or login
2. **Create Event**: Post a new venue with details and image
3. **Wait for Approval**: Events need admin approval before going live
4. **Manage Events**: Edit, delete, or set availability status
5. **Manage Bookings**: Approve or decline user booking requests

### For Users

1. **Register** as a user or login
2. **Browse Events**: Search and filter available venues
3. **Book Event**: Select a venue and provide date, time, and event type
4. **View Bookings**: Check status of your bookings
5. **Cancel Booking**: Cancel pending bookings if needed

## Database Schema

### Tables

- **users**: User accounts and authentication
- **events**: Event/venue information
- **bookings**: User event bookings and registrations

See `database.sql` for complete schema details.

## Design Guidelines

- **Color Scheme**: Vibrant green (#22c55e) with white backgrounds
- **No Hover Animations**: Static design as per requirements
- **No Drop Shadows**: Clean, flat design
- **Responsive**: Works on desktop and mobile devices
- **Simple & Clean**: Easy to read and navigate

## Security Features

- Password hashing using PHP `password_hash()`
- Prepared statements to prevent SQL injection
- Session-based authentication
- Role-based access control
- File upload validation

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check `config.php` database credentials
   - Ensure MySQL service is running
   - Verify database `evently` exists

2. **Image Upload Not Working**
   - Check `uploads/` directory permissions
   - Ensure PHP `upload_max_filesize` is adequate
   - Verify directory exists

3. **Session Issues**
   - Check PHP session configuration
   - Ensure cookies are enabled in browser
   - Clear browser cache and cookies

4. **Page Not Found**
   - Verify .htaccess configuration (if using Apache)
   - Check file paths are correct
   - Ensure mod_rewrite is enabled

## Future Enhancements

- Email notifications for bookings
- Payment integration
- Calendar view for bookings
- Event categories and tags
- Rating and review system
- Advanced search filters

## License

This project is created for educational purposes.

## Support

For issues or questions, please contact the development team.

---

**Developed by**: TRISTAN, STEFFI, GERO, JANRO  
**Version**: 1.0  
**Last Updated**: 2024

