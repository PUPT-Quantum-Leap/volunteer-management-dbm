# Volunteer Management System

**Comprehensive Laravel-based web application for managing volunteers, tracking attendance, evaluating performance, conducting polls, and organizing volunteer activities.**

---

## 📖 About

The **Volunteer Management System (VMS)** is a modern web application built with Laravel 12 and React to streamline volunteer coordination for organizations. It provides comprehensive tools for volunteer registration, attendance tracking, performance evaluation, and organizational planning.

### 🎯 Problem Statement

Organizations and coordinators often struggle with:

- ❌ Disorganized volunteer records and scattered information
- ❌ Manual tracking of volunteer attendance and hours
- ❌ No systematic way to evaluate volunteer performance
- ❌ Difficulty coordinating large-scale volunteer activities
- ❌ Lack of transparency in team assignments and organizational structure

### ✨ Our Solution

The Volunteer Management System provides an intuitive, efficient platform to:

- ✅ Centralize volunteer information and profiles
- ✅ Automate attendance tracking with detailed statistics
- ✅ Evaluate volunteer performance with measurable metrics
- ✅ Create polls for democratic decision-making
- ✅ Manage organizational charts and team assignments
- ✅ Auto-assign volunteers based on skills and requirements

---

## 🚀 Key Features

<table>
<tr>
<td width="50%">

### 👥 Volunteer Management

- Complete volunteer registration with detailed profiles
- Skills, training, and availability tracking
- Emergency contact information
- Lifegroup membership status
- Profile updates and deletion

### 📊 Attendance Tracking

- Record attendance by date and event
- Status options: present, absent, excused
- Real-time statistics calculation
- Attendance rate percentages
- Historical attendance records

### 📈 Performance Evaluation

- Metrics: reliability, punctuality, quality (0-100 scale)
- Detailed feedback text and evaluator name
- Historical performance data
- Top performer identification
- Performance trends over time

</td>
<td width="50%">

### 🗳️ Polling System

- Create polls with multiple options
- Vote tracking with configurable limits
- Prevention of duplicate votes
- Real-time vote count updates
- Admin poll management

### 🏗️ Organization Chart

- Leadership structure management
- Team assignments by area (Alpha, Bravo, Charlie, Delta, Echo, Foxtrot)
- Role assignments (Planning, Purchasing, Safety, etc.)
- Meal breakdown and vehicle assignments
- Mobile kitchen operations support

### ⚡ Auto-Assignments

- Skill-based volunteer assignment algorithm
- Role requirements based on meal objectives
- Coordinator and team member assignment
- Automated distribution optimization
- Fair workload distribution

</td>
</tr>
</table>

---

## 🛠️ Tech Stack

### Backend

![PHP](https://img.shields.io/badge/PHP_8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel_12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

- **Framework:** Laravel 12.0
- **Language:** PHP 8.2+
- **Database:** MySQL
- **ORM:** Eloquent
- **Authentication:** Laravel Auth (database sessions)

### Frontend

![React](https://img.shields.io/badge/React_18.2-61DAFB?style=for-the-badge&logo=react&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS_4-38B2AC?style=for-the-badge&logo=tailwindcss&logoColor=white)
![Vite](https://img.shields.io/badge/Vite_7.0-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

- **Framework:** React 18.2.0
- **Styling:** Tailwind CSS 4.1.17
- **Build Tool:** Vite 7.0.7
- **Icons:** Lucide React, FontAwesome

---

## 📦 Project Structure

```
volunteer-management-dbm/
├── vms_db/                          # Main Laravel application
│   ├── app/
│   │   ├── Http/
│   │   │   └── Controllers/         # RESTful controllers
│   │   └── Models/                  # Eloquent models
│   ├── database/
│   │   └── migrations/              # Database schema
│   ├── resources/
│   │   ├── views/                   # Blade templates
│   │   └── js/                      # React components
│   ├── routes/
│   │   └── web.php                  # Application routes
│   └── tests/                       # Unit and feature tests
├── composer.json                    # PHP dependencies
├── package.json                     # NPM dependencies
└── README.md                        # This file
```

## 👥 Quantum Leap Team Composition

<div align="center">

<table>
  <tr>
    <td align="center" width="25%">
      <a href="https://github.com/mejares-jamesmichael">
        <img src="https://github.com/mejares-jamesmichael.png" width="100px;" alt="James Michael Mejares"/><br />
      </a>
      <sub><b>James Michael C. Mejares</b></sub><br />
      <sup>DevOps Engineer / AI and Backend Developer</sup>
    </td>
    <td align="center" width="25%">
      <a href="https://github.com/deleon-jasminerobelle">
        <img src="https://github.com/deleon-jasminerobelle.png" width="100px;" alt="Jasmine Robelle De Leon"/><br />
      </a>
      <sub><b>Jasmine Robelle C. De Leon</b></sub><br />
      <sup>Project Manager / Developer</sup>
    </td>
    <td align="center" width="25%">
      <a href="https://github.com/ynion-mabeamae">
        <img src="https://github.com/ynion-mabeamae.png" width="100px;" alt="Ma. Bea Mae Ynion"/><br />
      </a>
      <sub><b>Ma. Bea Mae Ynion</b></sub><br />
      <sup>UI/UX Designer / Frontend Developer</sup>
    </td>
    <td align="center" width="25%">
      <a href="https://github.com/arroyo-johnmatthew">
        <img src="https://github.com/arroyo-johnmatthew.png" width="100px;" alt="John Matthew Arroyo"/><br />
      </a>
      <sub><b>John Matthew Arroyo</b></sub><br />
      <sup>Backend Developer</sup>
    </td>
  </tr>
</table>

</div>

---

## 📜 License

This project is licensed under the MIT License.

---

<div align="center">

[⬆ Back to Top](#volunteer-management-system)

</div>
