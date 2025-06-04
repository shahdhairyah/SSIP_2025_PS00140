
# SSIP 2025 – PS00140: Skill & Employment Management System

## Overview

The **Skill & Employment Management System** is a full-stack web application developed under the **Student Startup and Innovation Policy (SSIP) 2.0** by the Government of Gujarat. It is designed to connect skilled students with employment opportunities while enabling employers to post jobs and review applicants.

## Features

- ✅ **User Authentication**: Register/login with secure credential handling.
- ✅ **Profile Management**: Users can manage detailed profiles.
- ✅ **Skill Listing**: Showcase and update skills/certifications.
- ✅ **Job Portal**: Job seekers can browse and apply for jobs.
- ✅ **Employer Panel**: Post and manage job openings.
- ✅ **Admin Dashboard**: Full backend control for approvals and user management.
- ✅ **Responsive Design**: Works on desktop, tablet, and mobile.

## Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Backend:** PHP (Core)
- **Database:** MySQL
- **Tools Used:** XAMPP/WAMP (Local server), phpMyAdmin, Git

---

## 🔧 Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/shahdhairyah/SSIP_2025_PS00140.git
```

### 2. Navigate to the Project Directory

```bash
cd SSIP_2025_PS00140
```

### 3. Set Up the Database

- Create a new MySQL database using phpMyAdmin or terminal.
- Import the provided SQL file (`database.sql`) if available to set up necessary tables.

### 4. Configure Database Connection

- Open the `config.php` or the database connection file.
- Update the following variables with your own credentials:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "your_database_name";
```

### 5. Run the Application

- Start your local server (XAMPP, WAMP, or LAMP).
- Move the project folder to the server’s root directory:
  - For XAMPP: `C:/xampp/htdocs/`
- Open your browser and go to:

```
http://localhost/SSIP_2025_PS00140
```

---

## 💼 Usage

### 👤 Job Seekers
- Register and log in to your account.
- Fill in your profile and list your skills.
- View available job listings and apply.

### 🧑‍💼 Employers
- Create an account as an employer.
- Post job vacancies with complete details.
- Manage and review applications.

### 🛠️ Admin Panel
- Secure login access for admin.
- Approve/reject job postings and user accounts.
- Oversee all platform activity.

---

## 🤝 Contributing

We welcome contributions! Here’s how you can help:

1. Fork the repository.
2. Create a new branch:
   ```bash
   git checkout -b feature-name
   ```
3. Make your changes and commit:
   ```bash
   git commit -m "Added new feature"
   ```
4. Push and open a pull request:
   ```bash
   git push origin feature-name
   ```

---

## 📄 License

This project is licensed under the **MIT License**.  
You are free to use, modify, and distribute it for educational or professional purposes.

---

### 👨‍💻 Developed by Dhairya Shah  
As part of the **SSIP 2025 Innovation Project – PS00140**

> For questions or support, feel free to open an issue or contact me through the GitHub profile.
