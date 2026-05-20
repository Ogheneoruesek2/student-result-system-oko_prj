# Design and Implementation of a Web-Based Result Computation System

### 🎓 Undergraduate B.Sc. Thesis Project
* **Author:** Ozah Oruese Kelvin (COMP/CS/21/0644)
* **Institution:** Michael and Cecilia Ibru University, Agbarha-Otor, Nigeria
* **Department:** Mathematics and Computer Science
* **Supervisor / HOD:** Dr. O.E. Agboje

---

## 📌 Project Overview
This web application automates and streamlines the complex task of academic result management and grading within higher education institutions. Developed as a direct case study for Michael and Cecilia Ibru University, it replaces traditional, error-prone manual grading sheets with a secure, high-integrity relational platform. 

The system operates via a collaborative shared database environment that integrates directly with structural course enrollment data to automatically compile student performance metrics.

## 🚀 Core Functionalities
* **Multi-Role Authentication:** Dedicated, secure login systems utilizing cryptographic hashing workflows for course advisors, academic administrators, and faculty members.
* **Shared Schema Integration:** Seamlessly retrieves live student rosters and course selections from a unified, normalized database cluster.
* **Automated Computation Engine:** Eliminates mathematical error arrays by automatically calculating and compiling individual student **GPA (Grade Point Average)**, **CGPA (Cumulative Grade Point Average)**, **TU (Total Units)**, and **TP (Total Points)** immediately upon raw score entry.
* **Granular Score Assessment:** Features advanced data fields tracking separate performance vectors including Objectives (`obj`), structured descriptive questions (`q1` through `q6`), and Continuous Assessment (`ca`) scores.
* **Account Recovery Framework:** Integrated data table tracking with verification token constraints and expiration parameters (`expires`) for password resets.
* **Reporting & Exporting Modules:** Equips course advisors with direct utilities to view, audit, alter, or cleanly format and print student result listings for physical board evaluation.

## 🛠️ Technical Stack & Systems Architecture
The application employs a highly modular **Client-Server (Two-Tier) Architecture** deployed on a shared remote testing infrastructure (000webhost / Hostinger server stacks).

* **Frontend Layout (Client-Side):** Responsive UI layouts developed using HTML5, CSS3, JavaScript, jQuery, and structured component blocks from the **Bootstrap 5 framework**.
* **Backend Engine (Server-Side):** Formulated utilizing a dynamic fusion of procedural and **Object-Oriented PHP** scripts ensuring safe asynchronous API requests.
* **Database Management System:** Structured relational database processing utilizing **MySQL (MariaDB)** executing fully optimized SQL schemas.

## 🗄️ Relational Database Layout
The physical data layer consists of highly optimized schemas structured across multiple interrelated normalized tables:

1. **Course Advisor Table (`Course Advisor Table`):** Manages staff directory tracking attributes: `id`, `name`, `contact`, `school_id`, `dept`, `faculty`, and `password` (Optimized longtext block for secure bcrypt values).
2. **Courses Table (`Courses Table`):** Catalogues academic modules tracking code metrics: `course_title`, `course_code`, `course_unit`, `level`, `session`, and `semester`.
3. **Password Reset Table (`Password Reset Table`):** Secure token verification handler tracing temporary access parameters via: `email`, `token`, and `expires`.
4. **Result Table (`Result Table`):** The primary transaction table logging performance columns: `mat_no`, `obj`, `q1`-`q6`, `ca`, `total`, and final assigned letter `grade`.
5. **Students Registry (`Students Table`):** Direct learner schema parsing user records: `fullname`, `email`, `mat_no`, `faculty`, `dept`, and `pwd`.

## 📦 System Requirements & Quick Installation
To deploy and analyze this codebase locally within an experimental workspace:

1. Clone or extract this project repository straight into your server's root deployment directory: `C:/xampp/htdocs/`.
2. Open your **XAMPP Control Panel** and execute the **Apache HTTP Server** and **MySQL** modules.
3. Access the database terminal via your local web browser: `http://localhost/phpmyadmin/`.
4. Initialize a clean data environment named `result_db` and import the structured SQL dump file: `database/result_db.sql`.
5. Navigate directly to the deployment entry path to run the portal application: `http://localhost/student-result-system-oko_prj/login.php`.
