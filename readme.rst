This is a web application and it is dependent on database.
The back-end framework 'Codeigniter' and front-end framwork 'Bootstrap'
is already involved in the codes.
To make it work, apache2, mysql and php5 is required.
Release all the codes into web root folder (/var/www/html/).
Run 'cs4221_data.sql' to setup the database.
Configuure the /application/config/database.php to help the 'Codeigniter'
connect to the database.
then the application is available at 'localhost/index.php/datagenrator' in browser.

Our work is mainly under 'application/models', 'application/views/' and 'application/constrollers/'