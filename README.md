# Mini Project Management System

A simple Project Management System built using Laravel (Backend) and Blade + JavaScript (Frontend).
This application allows users to create projects and manage tasks under each specific project.

---

## 🚀 Features

### 📁 Project Management
- Create Project (name, description)
- View All Projects (with pagination)
- Delete Project
- Each project has its own tasks

### ✅ Task Management (Project-wise)
- Create Task under a specific project
- View Tasks based on selected project
- Update Task (Edit)
- Delete Task

---

## 🔁 Flow of Application

1. User creates a **Project**
2. Each Project has a unique **ID**
3. User clicks on a project → redirected to Tasks page
4. Tasks are managed using `project_id`
5. All tasks belong to a specific project

---

## ⚙️ Additional Features
- Pagination on Projects
- Filter Tasks by Status (Todo / In Progress / Done)
- Sort Tasks by Due Date
- Input Validation (Laravel)
- Proper Error Handling (API responses)

---
## 🔗 API Endpoints

### Project APIs
- POST `/api/projects` → Create project
- GET `/api/projects` → Get all projects (pagination)
- GET `/api/projects/{id}` → Get single project
- DELETE `/api/projects/{id}` → Delete project

### Task APIs
- POST `/api/projects/{project_id}/tasks` → Create task for project
- GET `/api/projects/{project_id}/tasks` → Get tasks of project
- PUT `/api/tasks/{id}` → Update task
- DELETE `/api/tasks/{id}` → Delete task

---
## 🛠️ Tech Stack

- Laravel (Backend)
- MySQL (Database)
- Blade + JavaScript (Frontend)
- Bootstrap (UI)

---

## 📦 Installation

1. Clone repository

git clone <your-repo-link>


2. Install dependencies

composer install


3. Setup environment

cp .env.example .env
php artisan key:generate


4. Configure database in `.env`

5. Run migrations

php artisan migrate


6. Start server
