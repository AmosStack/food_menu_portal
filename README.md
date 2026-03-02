# Food Menu Portal – Docker Setup

This project runs using **Docker + Docker Compose** and includes:

- PHP 8.1 + Apache Web Server
- MySQL 8 database
- Auto-installed mysqli & pdo_mysql extensions

---

## 📌 How to Run the Project

### 1. Install Docker & Docker Compose

Download Docker Desktop from:  
[https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)

---

### 2. Clone the project

```bash
git clone https://github.com/AmosStack/food_menu_portal.git
cd food_menu_portal

```

---

## Google Login (OAuth)

The project now supports Google Sign-In for users on the login page.

### 1. Create a Google OAuth Client

- Go to Google Cloud Console → APIs & Services → Credentials
- Create an **OAuth 2.0 Client ID** (Web application)
- Add authorized JavaScript origin(s), for example:
  - `http://localhost`
  - `http://localhost:80`
  - `http://localhost/food`

### 2. Configure Client ID

Set environment variable `GOOGLE_CLIENT_ID` in your PHP/Apache runtime.

If not set, normal email/password login still works and Google button shows as not configured.

### 3. Login Flow

- User clicks Google Sign-In on `login.php`
- Token is verified on backend (`google-login.php`)
- Existing user by email logs in directly
- New user is auto-created in `tbl_users` and logged in
