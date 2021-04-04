# PHP: User Authentication System
A PHP user authentication and login system with MySQL database

Tutorial: [__PHP 8 MySQL Tutorial: Build Login and User Authentication System__](https://www.positronx.io/build-php-mysql-login-and-user-authentication-system/)

Bootstrap template: [REGISTRATION - Epic Bootstrap](https://epicbootstrap.com/snippets/registration)

## Implementation
First create a table ```users```.

Field | Type | Null | Key | Default | Extra          
------|------|------|-----|---------|-------
id | int(11) | NO | PRI | NULL | auto_increment
email | varchar(50) | NO | UNI | NULL |
password | varchar(255) | NO | | NULL | 
date_time | date | NO | | NULL |

The user is able to register with their email and password. And the application consists of:
* User registration system
* Login system
* Log Out