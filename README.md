<h1 align="center">e-StaffCare</h1>
<p align="center">
  <b>Integrated occupational health management solution</b>
</p>

## 📋 About

**e-StaffCare** is a comprehensive web application for occupational health management designed for companies to efficiently monitor employee health. This solution helps track medical consultations, manage medical records, and enhance communication between occupational doctors and employees.

This project was developed as a sample application for employees at the Regional Directorate of Railway Transport of Algiers to demonstrate the potential of digital health management solutions in the transportation sector.

## ✨ Features

### 🛡️ Administrator

-   **Analytics dashboard** with statistics on consultations and medical activities
-   **Full user management** (doctors, employees)
-   **Management of departments, sectors, specialties, and medical centers**
-   **Scheduling and tracking of consultations**
-   **Reports and statistics** on staff's general health
-   **Monitoring of medical activities**

<div align="center">
  <img src="screenshots/dashboard-admin-1.png" width="48%">
  <img src="screenshots/admin-manage-medecins.png" width="48%">
</div>

<div align="center">
  <img src="screenshots/dashboard-admin-2.png" width="48%">
  <img src="screenshots/admin-creating-consultation.png" width="48%">
</div>

### 👨‍⚕️ Doctors

-   **Personalized dashboard**
-   **Consultation management**
-   **Prescription creation and printing**
-   **Medical records management**
-   **Full consultation flow**: diagnosis, functional/exploratory tests, patient interview, clinical examination, etc.
-   **Complete history** of medical interventions per employee

<div align="center">
  <img src="screenshots/medecin-dashboard.png" width="48%">
  <img src="screenshots/medecin-manage-dossiers.png" width="48%">
</div>

<div align="center">
  <img src="screenshots/medecin-consultations.png" width="48%">
  <img src="screenshots/medecin-print-ordonnance.png" width="48%">
</div>

### 👷 Employees

-   **Personal profile**
-   **View upcoming scheduled consultations**
-   **Access personal medical history**
-   **Mail notifications** for scheduled/modified appointments, visit reminders, and system alerts
-   **Consultation details and prescriptions**

<div align="center">
  <img src="screenshots/employé-navbar.png" width="23%">
  <img src="screenshots/employé-home-page.png" width="23%">
  <img src="screenshots/employé-dossier-medical.png" width="23%">
  <img src="screenshots/employé-consultations.png" width="23%">
</div>

## 🚀 Installation

```bash
# Clone the repository
git clone https://github.com/tamer-d/e-StaffCare.git

# Go to the project directory
cd e-StaffCare

# Install dependencies
composer install
npm install

# Generate the application key
php artisan key:generate

# Configure your database in the .env file
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=estaffcare
# DB_USERNAME=root
# DB_PASSWORD=

# Run SQL script (if needed manually) and migrations
php artisan migrate

# Start the development server
php artisan serve
```

## 🔐 Security

-   Secure authentication with roles and permissions

-   Encryption of sensitive data

-   Strict form validation

-   CSRF protection
