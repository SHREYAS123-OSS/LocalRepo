# shreyas-Demo
This is my first GitHub Repository.
<br>
Author - Shreyas (Shinde Shreyas)
# Smart Gym Attendance and Membership Management System (SaaS)

This is a SaaS-based Cloud Platform designed for modern gyms to manage memberships, track trainer schedules, and automate daily attendance using **QR-code based check-ins**.

---

## 🛠 Tech Stack Used
*   **Backend:** PHP
*   **Database:** MySQL
*   **Server Environment:** WAMP Server / XAMPP
*   **Frontend:** HTML5, CSS3, Bootstrap, JavaScript

---

## 🚀 How to Set Up and Run the Project on WAMP Server

Follow these simple steps to run this project on your local machine:

### Step 1: Clone or Download the Project
1. Download this repository as a `.zip` file or clone it using Git.
2. Extract the folder and move it to your WAMP server's web root directory:
   📂 `C:\wamp64\www\` (or `C:\wamp\www\` depending on your version)

### Step 2: Import the Databases in phpMyAdmin
This project uses multiple SQL files for organized data management. Follow these steps to import them:

1. Open your browser and go to: `http://localhost/phpmyadmin/`
2. Create a new database named **`smart_gym`**.
3. Click on the **`smart_gym`** database from the left sidebar, then click on the **Import** tab at the top.
4. Upload and import the main database file first:
   *   `smart_gym (1).sql`
5. After successfully importing the main file, import the remaining table-specific SQL files one by one into the same database:
   *   `admins.sql` (Admin credentials and controls)
   *   `members.sql` (Gym members data)
   *   `trainers.sql` (Trainers profiles and details)
   *   `attendance.sql` (Daily QR-based attendance logs)

### Step 3: Configure Database Connection
1. Open the project folder in your code editor (e.g., VS Code).
2. Look for the database configuration file (usually named `config.php`, `db.php`, or `connection.php`).
3. Update the database credentials according to your local WAMP settings:
   ```php
   $servername = "localhost";
   $username = "root";  // Default WAMP username
   $password = "";      // Default WAMP password (keep empty)
   $dbname = "smart_gym";