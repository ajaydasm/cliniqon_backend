# 📊 Cliniqon Dashboard API – Laravel Backend

This project provides a **Dashboard API** built with **Laravel**, supporting:
- Authentication
- Dashboard summary
- Earnings & balance charts
- Projects listing
- Daily schedule / activities (Right Panel)

All APIs are protected using `auth:api`.

---

## 🛠 Tech Stack
- Laravel 12
- MySQL
- Eloquent ORM
- REST APIs
- React (Frontend Consumer)

---

## 🚀 Getting Started

### 1️⃣ Clone Repository
```bash
git clone <repository-url>
cd cliniqon_backend



---

### 2️⃣ Install Dependencies
composer install

3️⃣ Environment Setup
cp .env.example .env
php artisan key:generate


Update database credentials in .env:

DB_DATABASE=cliniqon_backend
DB_USERNAME=root
DB_PASSWORD=

4️⃣ Run Migrations

All database tables are managed via migrations.

php artisan migrate


Seed dummy data:

php artisan db:seed

5️⃣ Start Application
php artisan serve


Application will be available at:

http://127.0.0.1:8000

🔐 Authentication
Login
POST /api/login


Request

{
  "email": "user@example.com",
  "password": "password"
}


Response

{
  "success": true,
  "token": "Bearer eyJ0eXAiOiJKV1Qi..."
}


Use token in request headers:

Authorization: Bearer <token>

📦 API Collection

All dashboard APIs are prefixed with:

/api/dashboard

1️⃣ Dashboard Summary
GET /api/dashboard/summary


Response

{
  "success": true,
  "data": {
    "total_earnings": 120000,
    "withdraw_amount": 45000,
    "total_projects": 12,
    "ongoing_projects": 4
  }
}

2️⃣ Monthly Earnings (Chart)
GET /api/dashboard/accounting-earnings


Response

{
  "success": true,
  "data": [
    { "month": "January", "year": 2025, "total": 15000 },
    { "month": "February", "year": 2025, "total": 20000 }
  ]
}
3️⃣ Projects List
GET /api/dashboard/projects?page=1&status=ongoing


Query Parameters

Name	Description
page	Pagination page
status	all / ongoing / completed

Response

{
  "success": true,
  "data": {
    "data": [
      {
        "id": 1,
        "name": "CRM System",
        "client": "ABC Corp",
        "role": "Backend Developer",
        "start_date": "2025-01-10",
        "status": "ongoing"
      }
    ]
  }
}

4️⃣ Balance Chart
GET /api/dashboard/balance-chart


Response

{
  "success": true,
  "data": {
    "total_earned": 120000,
    "total_withdrawn": 45000,
    "balance": 75000
  }
}

5️⃣ Daily Schedule / Activities
GET /api/dashboard/daily-schedule?date=2025-03-05


Fields

Field	Type
time	string
title	string
description	string
type	meeting / task / reminder

Response

{
  "success": true,
  "date": "2025-03-05",
  "data": [
    {
      "id": 1,
      "time": "09:00:00",
      "title": "Client Meeting",
      "description": "Design discussion with client",
      "type": "meeting"
    },
    {
      "id": 2,
      "time": "10:00:00",
      "title": "Check List",
      "description": "Complete assigned tasks",
      "type": "task"
    },
    {
      "id": 3,
      "time": "12:30:00",
      "title": "Course",
      "description": "Finish React module",
      "type": "reminder"
    }
  ]
}

🗄 Database Management
Tables (Migration Managed)

    users
    
    earnings
    
    withdrawals
    
    projects
    
    schedules





🔗 Frontend Integration

Designed to be consumed by:

React + Vite
Axios API hooks
Dashboard UI cards & charts
Right panel daily schedule timeline

