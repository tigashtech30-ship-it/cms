# Complaint Management System (CMS)
## Setup Instructions for Local Server

### Requirements
- XAMPP (PHP 8.2+, MySQL)
- Composer
- Node.js & npm

### Installation Steps

1. Place the `cms` folder in `D:/cms`
2. Open XAMPP → Start Apache & MySQL
3. Create database `cms_db` in phpMyAdmin
4. Open terminal in `D:/cms` and run:

```bash
composer install
npm install
npm run build
php artisan key:generate
php artisan migrate
php artisan storage:link
```

5. Add to XAMPP `httpd-vhosts.conf`:
```apache
<VirtualHost *:80>
    DocumentRoot "D:/cms/public"
    ServerName cms.local
    <Directory "D:/cms/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

6. Add to `C:\Windows\System32\drivers\etc\hosts`:
```
127.0.0.1    cms.local
```

7. Restart Apache → Visit `http://cms.local`

### Default Accounts
| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@cms.com | password123 |
| Admin | admin@cms.com | password123 |
