# KK Enterprises – Water Management App (PHP 8 + MySQL + Tailwind)

## Requirements
- PHP 8+
- MySQL 5.7+/8+
- Apache/Nginx (Apache + .htaccess recommended for quick start)

## Setup
1. Import database schema and defaults:
   - mysql -u root -p < database.sql
2. Configure DB credentials via environment variables (or set defaults in `config/database.php`):
   - DB_HOST, DB_NAME, DB_USER, DB_PASS
3. Serve the app from the `public/` directory:
   - Apache: point VirtualHost DocumentRoot to `public/` (or use provided `.htaccess` in repo root)
   - PHP built-in server (dev only):
     - cd public && php -S 0.0.0.0:8000

## Default Flow
- Visit /login
- Create users directly in DB (roles: client, staff, admin). Passwords must be bcrypt hashes; or use registration via a quick SQL insert:
  - INSERT INTO users (username,name,email,password,address,role) VALUES ('admin','Admin','admin@example.com', '$2y$10$F7o0qfJ5kQhH/7Zl8w4tQe0Q8F9z3dQyQ3W6iQpJ7c4w7s2Q4dCgu', '', 'admin');
  - The above hash is for password: admin123

## Features
- Role-based dashboards and navigation
- Client: create order, cart, order history, invoice, profile, change password
- Staff: view present orders, mark delivered, request paid, weekly record, profile, login hour visibility controlled by admin
- Admin: daily orders by category with status edit, client viewer, staff alignment (assign), daily accounts, daily jar record

## Notes
- Tailwind CDN is used for simplicity. For production, prebuild Tailwind CSS.
- Session is used for auth. Consider hardening with HTTPS, secure cookie flags, and CSRF tokens for production.