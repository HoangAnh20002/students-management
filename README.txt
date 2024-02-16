- install xampp and setup xampp
+"https://www.apachefriends.org/download.html"
+ run xampp after downloaded
+ start Apache and MySQL: after installation, start both Apache and MySQL services using the XAMPP Control Panel.

-install library you need with composer
+ open terminal,cd in project folder, then run command: " composer install "

-copy file .env. example ,rename to .env, then config accordingly DB_CONNECTION=mysql
                                                                  DB_HOST=
                                                                  DB_PORT=
                                                                  DB_DATABASE=
                                                                  DB_USERNAME=
                                                                  DB_PASSWORD=


- run "php artisan migrate" to create table
- run "php artisan db:seed" to create fake data
- run "php artisan serve" to run serve
