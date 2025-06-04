
# 🚀 SSIP 2025 – PS00140: Skill & Employment Management System

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
![Build](https://img.shields.io/badge/build-passing-brightgreen)
![Status](https://img.shields.io/badge/status-active-blue)
![Made with PHP](https://img.shields.io/badge/Made%20with-PHP-blue)

> 🔗 Connecting Talent with Opportunity under the Government of Gujarat's SSIP 2.0 Initiative

---

## 📌 Project Summary

The **Skill & Employment Management System** is a full-stack web-based platform designed to link skilled students with relevant employment and internship opportunities. Built under the **Student Startup and Innovation Policy (SSIP) 2025**, the system aims to streamline skill documentation, employer interactions, and admin-based validation in one integrated portal.

---

## ✨ Key Features

- 🔐 **Authentication System** — Secure login/register with role-based access (Student, Employer, Admin)
- 👨‍🎓 **Student Dashboard** — Profile creation, skill upload, and job application
- 🧑‍💼 **Employer Portal** — Post jobs, manage listings, and view applications
- 🛠️ **Admin Control Panel** — Approve or reject jobs, validate user profiles
- 📃 **Skill Repository** — Structured data for resume-building and reporting
- 📱 **Responsive UI** — Clean, mobile-friendly interface using Bootstrap

---

## 🧰 Tech Stack

| Layer        | Technology             |
|--------------|------------------------|
| Frontend     | HTML5, CSS3, Bootstrap, JavaScript |
| Backend      | PHP (Core)             |
| Database     | MySQL                  |
| Tools Used   | XAMPP/WAMP, phpMyAdmin, Git, GitHub |

---

## ⚙️ Setup Instructions

### 📥 Clone the Repository

```bash
git clone https://github.com/shahdhairyah/SSIP_2025_PS00140.git
cd SSIP_2025_PS00140
```

### 🗄️ Database Configuration

1. Create a new MySQL database using phpMyAdmin.
2. Import the SQL file (if provided) into your database.
3. Open the `config.php` file and update:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "your_database_name";
```

### 🧪 Run Locally

- Start your local server (XAMPP/WAMP).
- Move the project to `htdocs/`.
- Access it at: [http://localhost/SSIP_2025_PS00140](http://localhost/SSIP_2025_PS00140)

---

## 🖥️ System Roles

### 🎓 Students
- Register & log in
- Add and update profile
- List certifications and skills
- Apply to job/internship listings

### 🧑‍💼 Employers
- Post new job openings
- View & manage student applications
- Maintain employer profile

### 🛡️ Admin
- Full platform control
- Approve user registrations
- Monitor and verify job listings
- Generate reports

---

## 📈 Future Enhancements

- 📧 Email Notifications
- 📊 Analytics Dashboard
- 📍 Location-based Filtering
- 🗃️ Resume Builder Integration
- 🔍 Advanced Search & Filters

---

## 🤝 Contributing

We welcome your contributions!  
Fork the repo, create a branch, commit changes, and open a pull request.

```bash
git checkout -b feature-new
git commit -m "Add new feature"
git push origin feature-new
```

---

## 📄 License

This project is licensed under the **MIT License**.  
See the [LICENSE](LICENSE) file for details.

---

## 🙋 About the Developer

**Dhairya Shah**  
`Lead Developer`  
🔗 [GitHub Profile](https://github.com/shahdhairyah)

---

> Developed under SSIP 2025 – Project ID: PS00140  
> Empowering students through innovation and skill development.

