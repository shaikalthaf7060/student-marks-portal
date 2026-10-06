# Online Examination Cell & Student Management Portal

![PHP](https://img.shields.io/badge/PHP-7.4%2B%20%7C%208.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6%2B-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)

A centralized web portal built as a **B.Tech Minor Project** for educational institutions to streamline student record administration, automate mid-term examination grading, manage internal marks assessments, and generate printable academic evaluation reports.

---

## 🌟 Key Features

- **🔐 Authentication & Access Control**:
  - Secure session-based login and logout flow.
  - Protected routes preventing unauthorized direct URL access.
  - Support for database-backed credentials with default administrative accounts.

- **👨‍🎓 Student Profile Management (CRUD)**:
  - **Register Student**: Comprehensive personal and academic registration (PIN / Roll Number, Name, DOB, Department, Batch, Father's Name, Contact).
  - **Directory View**: Searchable student directory filterable by Roll Number and Engineering Department.
  - **Edit & Manage**: Update student details with pre-populated forms or remove records with confirmation safety.

- **📝 Mid-Term Marks Automation**:
  - Dynamic curriculum loading by Department (`CSE`, `ECE`, `EEE`, `CIVIL`, `MECH`) and Semester (`First Year` through `Semester 5`).
  - Real-time client-side calculation of Mid-1, Mid-2 averages and subject totals.
  - Multi-subject batch saving in a single submission.

- **🧪 Internal / Lab Assessment Evaluation**:
  - Dedicated internal assessment score recording mapped per subject.
  - Fast tabular entry format with instant validation.

- **📊 Examination Records & Reports**:
  - Search and filter student performance by Roll Number, Department, or Semester.
  - Clean, print-ready grade sheets with auto-hiding navigation bars for physical transcript printing (`window.print()`).

---

## 🛠️ Technology Stack

| Layer | Technologies |
|---|---|
| **Backend** | PHP (Prepared Statements via `mysqli`, Session Management) |
| **Database** | MySQL / MariaDB (`mid-marks`) |
| **Frontend** | HTML5, CSS3, JavaScript (ES6+), jQuery, Bootstrap 5 |
| **Typography & Icons** | Google Fonts (Poppins, Inter), Boxicons / FontAwesome |
| **Server Compatibility** | Apache (XAMPP / WAMP / LAMP) or PHP Built-in Server |

---

## 📂 Project Directory Structure

```plaintext
├── css/
│   └── style.css                 # Global portal layout and navigation styles
├── images/                       # UI assets, logos, and hero graphics
├── internal/
│   ├── db_config.php             # Database connector reference
│   ├── get_semesters.php         # AJAX endpoint for department semester lists
│   ├── get_subjects.php          # AJAX endpoint for internal subjects table
│   ├── internal-view.php         # Searchable internal marks viewer
│   ├── internal.js               # Dynamic AJAX interactions for internal entry
│   ├── internal.php              # Internal marks entry portal
│   └── submit.php                # Backend processor for internal marks batch insertion
├── mid/
│   ├── db_config.php             # Database connector reference
│   ├── get_semesters.php         # AJAX endpoint for mid-term semester lists
│   ├── get_subjects.php          # AJAX endpoint for subject marks input grid
│   ├── data-view.php             # Filterable mid-marks viewer & print reports
│   ├── mid.js                    # Dynamic calculation logic & AJAX handlers
│   ├── mid-marks.php             # Mid-term marks entry portal
│   └── submit.php                # Backend processor for mid-term marks batch insertion
├── student-info/
│   ├── db_config.php             # Database connector reference
│   ├── delete-student.php        # Safe record deletion handler
│   ├── register.css              # Profile registration form styling
│   ├── s.php                     # Filterable student records directory
│   ├── staffedit.php             # Student editing and management interface
│   └── student-profile.php       # Student registration form
├── .gitignore                    # Git ignore file for temp/IDE files
├── auth.php                      # Authentication middleware session guard
├── database.sql                  # Complete SQL schema and sample seed records
├── db_config.php                 # Centralized database configuration
├── index.php                     # Main portal dashboard
├── login.css                     # Login page backdrop and glassmorphism styling
├── login.php                     # Authentication and user sign-in page
├── logout.php                    # Session destruction and sign-out handler
└── README.md                     # Project documentation
```

---

## 🚀 Getting Started / Installation

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) (recommended) or any WAMP / LAMP stack with **PHP 7.4+** and **MySQL**.

### 1. Clone or Download the Repository
```bash
git clone https://github.com/shaikalthaf7060/online-examination-cell.git
cd online-examination-cell
```
*(Or copy the folder into your web server's root directory: `htdocs/` for XAMPP or `www/` for WAMP).*

### 2. Set Up the Database
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Create a new database named `mid-marks` (or let the script create it automatically).
3. Click on the **Import** tab.
4. Choose the `database.sql` file provided in the repository and click **Import** (or **Go**).

Alternatively, using MySQL Command Line:
```bash
mysql -u root -p < database.sql
```

### 3. Configure Database Connection (Optional)
The default database configuration in [`db_config.php`](file:///C:/Users/shaik/Downloads/pw/db_config.php) is set for standard local setups:
```php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db     = "mid-marks";
```
Adjust credentials if your MySQL server uses a custom password or port.

### 4. Launch the Application
- Open your browser and navigate to:
  ```
  http://localhost/online-examination-cell/login.php
  ```
  *(or `http://localhost/pw/login.php` depending on your directory name)*

---

## 🔑 Demo Credentials

| Role | Username / Email | Password |
|---|---|---|
| **Administrator** | `admin` | `admin123` |
| **Staff Evaluator** | `bunny` | `bunny123` |

---

## 🛡️ Security & Architecture Improvements Made

This project was refined with modern standards:
1. **Prepared Statements**: Replaced string interpolation and concatenated queries with parameterized SQL queries (`mysqli::prepare`) across all entry and search views to eliminate SQL Injection vulnerabilities.
2. **Batch Array Processing**: Fixed mid-term and internal multi-subject marks submission so each subject's individual marks are correctly received and mapped in the database.
3. **Session Guards**: Added authentication validation (`auth.php`) across all protected endpoints to prevent direct URL access by unauthorized users.
4. **URL Safety**: Normalized folder structures (eliminated spaces in directory paths) for cross-platform Apache/Linux compatibility.
5. **Centralized Configuration**: Unified database configurations into a single root file with environment variable fallback support.

---

## 👤 Author

- **Shaik Althaf**
  - GitHub: [@shaikalthaf7060](https://github.com/shaikalthaf7060)
  - Project Type: B.Tech Minor Project (Computer Science & Engineering)

---

## 📄 License
This project is open-source and available under the [MIT License](LICENSE).
