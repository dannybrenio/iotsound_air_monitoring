IOT SOUND AND AIR MONITORING 

Versions: 
- 0.1v initial commit with hardware table working
- 0.1.1v working pending hardware with postman, new database migrations, hardware_data blade but no data entry point, updated:routing, hardware controller
- 0.1.2v pending to hardware create now working, typo fix on migration 
- 0.1.3v data fetching working, next step is alert 
- 0.1.4v alert trigger working, next polishing of exisiting modules
- 0.1.5v reports view working, need img path, need user sending simulation

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
