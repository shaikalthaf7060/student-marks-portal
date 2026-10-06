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

This project is open-source and available under the [MIT License](LICENSE).
