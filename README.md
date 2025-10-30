IOT SOUND AND AIR MONITORING 


Cloning steps: 

- clone the repository 
- composer -v 
- php -v 

if you get problems during php artisan it might be because of outdated php so you need to update your version
then after that you have to setup your php.ini file which is located 
depending where you installed your php or inside xampp if you didn't separate it

- uncomment these extensions in php.ini file:
    - extension=fileinfo
    - extension=mbstring
    - extension=openssl
    - extension=pdo_mysql
    - extension=mysqli

- php artisan migrate
- php artisan serve 
