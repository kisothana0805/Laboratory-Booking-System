# 🧪 Laboratory Booking System

A web-based application built with **PHP**, **MySQL**, and **HTML/CSS/JavaScript** that enables instructors to book laboratories and manage schedules efficiently, while Lab Technical Officers (Lab TOs) can approve, monitor, and track laboratory usage and equipment.


## 📌 Features

### 🔐 Authentication
- Secure login system for both **Instructors** and **Lab TOs**
- Role-based access control

### 👨‍🏫 Instructor Functions
- Book a laboratory with selected time slots and lab details
- View upcoming scheduled labs
- Edit or delete existing bookings
- View laboratory usage logs by selecting lab
- Friendly and modern UI with success messages and validation

### 🧑‍🔬 Lab Technical Officer Functions
- View and manage laboratory booking **requests** (Approve / Reject / Pending)
- View laboratories and associated **equipment**
- Log and track **lab usage history**
- Receive real-time notifications on booking requests


## 🗂️ Project Structure

```
lab_booking_system/
│
├──  index.php                       # Landing page with login options
├──  db.php                          # Database connection file
├──  session_check.php              # Session validation for role-based access
├──  logout.php                     # Logout script for all users

│   
├── instructor_login.php       # Instructor login page
├── instructor_signup.php      # Instructor registration page
├── instructor_auth.php        # Instructor login authentication
├── instructor_dashboard.php   # Dashboard for instructor role
├── laboratory_booking.php     # Form to book a lab
├── upcoming_labs.php          # View upcoming scheduled lab bookings
├── manage.php                 # View/Edit/Delete instructor's bookings
├── edit_booking.php           # Edit form for instructor's lab booking
├── lab_to_info.php            # View labs and equipment managed by Lab TO
├── lab_usage_log.php          # View lab usage log by lab name

│   
├── labto_login.php            # Lab Technical Officer login
├── labto_signup.php           # Lab TO registration
├── labto_auth.php             # Lab TO login authentication
├── labto_dashboard.php        # Dashboard for Lab TO
├── booking_requests.php       # Lab booking approval interface
├── add_usage_log.php          # Add a log of lab usage
├── equipment_checking.php     # View and manage equipment availability

│   
├── add_lab.php                # Admin adds a new lab
├── add_equipment.php          # Admin adds equipment
├── lab_details.php            # View/edit/delete lab info
├── instructor_details.php     # View instructor details

│   
├── university-logo.png         # University logo
├── imgbg_labto.jpg             # Lab TO dashboard background
├── portrait-engineers-work.jpg # Instructor dashboard background
└── research-innovation.jpg     # Additional decorative asset

```

## 🧰 Technologies Used

- **Frontend**: HTML, CSS (custom styling), JavaScript
- **Backend**: PHP (session-based role management)
- **Database**: MySQL
- **Tools**: XAMPP / WAMP for local development


## 🧪 How to Run Locally

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/laboratory-booking-system.git
   cd laboratory-booking-system
   ```

2. **Start local server (e.g., XAMPP):**
   - Copy project files to `htdocs/` folder.
   - Start Apache and MySQL.

3. **Create MySQL database:**
   - Import the database using phpMyAdmin.
   - Recommended DB name: `laboratorybookingsystem`

4. **Set up tables:**
   - Use the provided SQL file or manually create tables:
     - `instructor`
     - `lab_to`
     - `laboratory`
     - `equipment`
     - `lab_booking`
     - `usage_log`

5. **Login Credentials (Sample):**
   - Instructor: `Email: sample@inst.jfn.ac.lk` | `Password: 123456`
   - Lab TO: `Email: sample@to.jfn.ac.lk` | `Password: 987654`


## 🚀 Future Enhancements

- Admin module to oversee both instructor and Lab TO operations
- Email notification system for booking status
- Conflict detection for overlapping lab sessions
- Equipment reservation system with stock limits


## 🧑‍💻 Author

- 👩‍💻 **Kisothana P.**
- 🏫 3rd Year Computer Engineering Student

## Contact
For any questions or feedback, feel free to reach out via LinkedIn - www.linkedin.com/in/kisothana-bala-03aa1a273
