# 📚 Book Management System

A simple yet powerful Laravel-based Book Management System where users can **add**, **edit**, **delete**, and **view books**. Authenticated users can manage their own posts, and view books posted by others.

---

## 🚀 Features

- User authentication (Login / Register)
- Add books with:
  - Title
  - Author
  - ISBN
  - Published Year
  - Description
  - Category
  - Cover Image
- User-based permissions:
  - Users can **edit/delete only their own posts**
  - View others’ posts but no edit/delete option
- Book filtering (by author, year, category)
- Pagination for better UI/UX
- Admin can manage all books
- Clean Bootstrap UI

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12.x
- **Frontend:** Blade + Bootstrap 5
- **Database:** MySQL
- **Authentication:** Laravel Breeze (or Auth scaffolding)
- **File Upload:** Laravel Storage

---

## 📂 Project Structure

```bash
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── BookController.php
├── resources/
│   └── views/
│       ├── books/
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   ├── index.blade.php
├── routes/
│   └── web.php
├── database/
│   └── migrations/
│       └── create_books_table.php
└── public/
    └── storage/ (for cover images)



