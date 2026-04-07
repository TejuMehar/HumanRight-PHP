# How to Run the Project Locally

## Prerequisites
Make sure the following are installed on your system:
- XAMPP (PHP 8.0+) — installed at `C:\xampp`
- MongoDB — installed as a Windows service
- Git

---

## Step 1 — Start MongoDB

Open CMD and run:
```cmd
net start MongoDB
```

If already running you will see:
```
The requested service has already been started.
```

---

## Step 2 — Start PHP Web Server

Open CMD and run:
```cmd
C:\xampp\php\php.exe -S localhost:8080 -t C:\xampp\htdocs\demo C:\xampp\htdocs\demo\router.php
```

Keep this CMD window **open**. The server runs as long as this window is open.

---

## Step 3 — Open in Browser

| Page         | URL                                      |
|--------------|------------------------------------------|
| Home         | http://localhost:8080                    |
| About        | http://localhost:8080/about              |
| Blog         | http://localhost:8080/blog               |
| Contact      | http://localhost:8080/contact            |
| Login        | http://localhost:8080/auth/login         |
| Sign Up      | http://localhost:8080/auth/signup        |
| Admin Panel  | http://localhost:8080/admin/login        |

---

## Admin Credentials

| Field    | Value                      |
|----------|----------------------------|
| Email    | admin@humanrights.org      |
| Password | Admin@1234                 |

---

## Shortcut — Double Click to Start

Instead of typing commands, just double-click this file:
```
C:\xampp\htdocs\demo\start-server.bat
```

It will automatically:
- Start MongoDB
- Start PHP server on port 8080
- Show all URLs and admin credentials

---

## Step 4 — Stop the Server

Press `Ctrl + C` in the CMD window to stop the server.

---

## Troubleshooting

### Port 8080 already in use
Run this to find and kill the process:
```cmd
netstat -ano | findstr :8080
taskkill /PID <PID_NUMBER> /F
```

### MongoDB not starting
```cmd
net start MongoDB
```
Or open **Services** → find **MongoDB** → Start

### PHP not found
Make sure XAMPP is installed at `C:\xampp`
Test PHP:
```cmd
C:\xampp\php\php.exe -v
```

### Composer dependencies missing
```cmd
cd C:\xampp\htdocs\demo
C:\xampp\php\php.exe C:\xampp\php\composer.phar install
```

---

## Project Folder Location
```
C:\xampp\htdocs\demo
```

## GitHub Repository
```
https://github.com/TejuMehar/HumanRight-PHP
```

## Live Website (Render)
```
https://humanright-php.onrender.com
```
