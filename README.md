## 🚀 Please follow the instructions for Setup  
1. Navigate to the backend folder:
    cd backend
   
`Server Requirements:` Php server & CLI version >= 8.2  
- clone this git repository  
- copy `.env.example` to `.env`  
- configure all info in `.env`  
- run command `composer install`  
- run command `php artisan key:generate`  
- set your email configuration in `.env` file  
- run command `php artisan migrate`
- run command `php artisan db:seed`  
- run command `php artisan optimize:clear`  
- run command `php artisan optimize`  
- run command `php artisan serve`  
---

Admin Login: 
username: admin@app.com
pass: 12345678


Writer: 
username: writer@app.com
pass: 12345678
