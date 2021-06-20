# Faculty-Leave-Application-Portal(FLAP)

FLAP with MySQL database in backend

## TABLES

|     Table     |    Attributes  |
___________________________________________________________________________________________________________

|    login_info  |  username(PK), password, profile_type  |                                                                                                        
|    emp_info    |  username, name, designation, department, address, email_id, joining_year  |                                                                     
|   leaves_count |  username, used_leaves  |                                                                                                                       
| applied_leaves |  username, start_date, end_date, leave_type, reason, comments, approved_by, result  |                                                           
| appoint_info   |  username, start_date, end_date  |                                                                                                               
| login_sessions |  username, login_time, logout_time  |                                                                                                           

- login_info table contains the details of login credentials of admin, faculties, hod, deans and director of the institute and used in several other relations.
- emp_info table contains the details of the employees of the institute such as name, post, email, office address etc.
- leaves_count table counts the total leaves of the employees and updates it.
- appoint_info tables contains the appointment details of the dean and hod.
- login_sessions table contails the session details of every employee.

## Leave application procedure
 Initially admin needs to register users for the use of portal.
 
# For Faculty : 
  when faculties applies for normal leaves (NL) their request goes to HoD for approvel and after getting approvel it goes to Dean for approvel in case of Normal leaves but when they applies for retrospective leave (RL) their request will go to director for approves i.e the procedure will be HoD approves application and it goes to Dean for approvel after getting approvel of Dean, application goes to Director for approvel. If faculty is not provinding any reason then HoD or Dean or Director can ask them for reason by commenting on their leave application and faculty can get to them by commenting back.

# For HoD or Dean :
  Leave application of HoD or Dean will go Directaly to Director for approvel in case of both type(Normal Leave or Retrospective Leave) of leaves.
  
## Validations

- Login (user & admin)
    
      Username - Not Empty & Valid
      Password - Not Empty & Valid

- Apply for Leave
     
      Applying for RL(Retrospective Leave)? if then provide reason otherwise system will generate error.
 
## Other Functionalities 

- View Applied leaves
       users can view their applied leaves application.
 
- View others leave history 
    This functionlities is only available for Hod's, Dean's and Director as they can confirm when that person was faculty how many leave did he/she took and when they were appointed HoD of their respective department or Dean how many leaves they have left as it would count old leaves respective to their posts.
 
- View All Users
    Admin can see details of the users that are persent in the system and their roles.
    
## Tech Stack

- Frontend

      HTML
      CSS
      JavaScript

- Backend
     
      PHP
      
- Database
      
      MySQL
 
- Server
     
      Apache
      
## How to Run Locally

- Install [XAMPP](https://www.apachefriends.org/index.html) on your system
- Clone the repository in ```C:/xampp/htdocs```
- Start Apache & MySql Servers from XAMPP Control Panel
- Visit "http://localhost/phpmyadmin" on your browser
- Create a new database ```flap```  and then click Import
- Select ```sql/queries.sql``` & database will be loaded
- Open "http://localhost/FLAP" on your browser
- Now you are all set to start!

## Directory Structure
 
 ```
 Faculty-Leave-Application-Portal
 |- Flap
    ├─ css
       ├─ admin.css
       ├─ faculty.css
       ├─ login.css
    ├─ index.php
    ├─ js
        ├─ admin.js
        ├─ faculty.js
    ├─ php
        ├─ admin.php
        ├─ apply_leave.php
        ├─ appoint.php
        ├─ config.php
        ├─ create_user.php
        ├─ dean.php
        ├─ delete_user.php
        ├─ director.php
        ├─ faculty.php
        ├─ hod.php
        ├─ login.php
        ├─ logout.php
        ├─ reply.php
        ├─ requests_comment.php
        ├─ update_credentials.php
        ├─ update_profile.php
    ├─ sql
        ├─ queries.sql
 ```
## Assumptions Made

- Every faculty, HoD, or Dean can apply only one leave application at a time.
- Retrospective leaves are those where some days has already gone but for some reason employee was not able to aply on that date but applies after that specific date has already gone.
- Multiple users can use the application at one time.
