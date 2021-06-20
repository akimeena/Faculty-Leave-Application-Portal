-- Create 'Faculty Leave Application Portal' database

CREATE DATABASE flap;

-- Create login_info table which has credentials and profile type of all accounts

CREATE TABLE IF NOT EXISTS login_info (
	username VARCHAR(20),
	password VARCHAR(20) NOT NULL,
	profile_type VARCHAR(20) NOT NULL,
	PRIMARY KEY(username)
);

-- Create emp_info table which has profile related information

CREATE TABLE IF NOT EXISTS emp_info (
	username VARCHAR(20),
	name VARCHAR(50),
	designation VARCHAR(30),
	department VARCHAR(30) NOT NULL,
	address VARCHAR(200),
	email_id VARCHAR(30),
	joining_year INT
	#FOREIGN KEY (username) REFERENCES login_info(username)
);

-- Create leaves_count table which has count of leaves used by users

CREATE TABLE IF NOT EXISTS leaves_count (
	username VARCHAR(20),
	used_leaves INT DEFAULT 0
	#FOREIGN KEY (username) REFERENCES login_info(username)
);


-- Create applied_leaves table which has all leaves information associated with all users

CREATE TABLE IF NOT EXISTS applied_leaves (
	username VARCHAR(20),
	start_date DATE NOT NULL,
	end_date DATE NOT NULL,
	leave_type VARCHAR(2) NOT NULL,
	reason VARCHAR(256) NOT NULL,
	comments VARCHAR(5000),
	approved_by VARCHAR(20),
	result VARCHAR(20) NOT NULL
	#FOREIGN KEY (username) REFERENCES login_info(username)
);

-- Inserting some sample data in applied_leaves table

-- Create appoint_info table which has history of all HoD/Dean appointings by director

CREATE TABLE IF NOT EXISTS appoint_info (
	username VARCHAR(20),
	start_date DATE NOT NULL,
	end_date DATE NOT NULL
	#FOREIGN KEY (username) REFERENCES login_info(username)
);

CREATE TABLE IF NOT EXISTS login_sessions (
	username VARCHAR(20),
	login_time DATETIME,
	logout_time DATETIME
	#FOREIGN KEY (username) REFERENCES login_info(username)
);

-- Inserting some sample data in login_info table

INSERT INTO login_info (username, password, profile_type) VALUES ('admin', 'techaso', 'admin');
INSERT INTO login_info (username, password, profile_type) VALUES ('rajeev', 'rajahu', 'director');
INSERT INTO login_info (username, password, profile_type) VALUES ('anupam', 'anuaga', 'dean_fa');
INSERT INTO login_info (username, password, profile_type) VALUES ('vgunturi', 'visgun', 'hod_cse');
INSERT INTO login_info (username, password, profile_type) VALUES ('ravi', 'ravmul','hod_ee');
INSERT INTO login_info (username, password, profile_type) VALUES ('ekta','ektsin','hod_me');
INSERT INTO login_info (username, password, profile_type) VALUES ('satyam','sataga','faculty');

-- Inserting some sample data in emp_info table

INSERT INTO emp_info (username,name,designation,department,address,email_id,joining_year) 
VALUES ('admin', 'Administrator','IT specialist','IT Department','Lab 01, S. Ramanujan Block, IIT Ropar Main Campus, Punjab, India','info@iitrpr.ac.in','2008');

INSERT INTO emp_info (username,name,designation,department,address,email_id,joining_year) 
VALUES ('rajeev', 'Rajeev Ahuja','Director','Physics Department','Director Office, IIT Ropar Main Campus, Punjab, India','director@iitrpr.ac.in','2021');

INSERT INTO emp_info (username,name,designation,department,address,email_id,joining_year) 
VALUES ('anupam', 'Anupam Agarwal','Associate Professor','ME','Room 224, Admin Block, IIT Ropar Main Campus, Punjab, India','anupam@iitrpr.ac.in','2015');

INSERT INTO emp_info (username,name,designation,department,address,email_id,joining_year) 
VALUES ('vgunturi', NULL,NULL,'CSE',NULL,NULL,NULL);

INSERT INTO emp_info (username,name,designation,department,address,email_id,joining_year) 
VALUES ('ravi', 'Dr. Ravibabu Mulaveesala','Associate Professor','EE','Room 305, J.C. Boss Block, IIT Ropar Main Campus, Punjab, India','ravi@iitrpr.ac.in','2011');

INSERT INTO emp_info (username,name,designation,department,address,email_id,joining_year) 
VALUES ('ekta', NULL,NULL,'ME',NULL,NULL,NULL);

INSERT INTO emp_info (username,name,designation,department,address,email_id,joining_year) 
VALUES ('satyam', 'Satyam Agarwal','Assistant Professor','EE','Room 106, S. Ramanujan Block, IIT Ropar Main Campus, Punjab, India','satyam@iitrpr.ac.in','2017');


-- Inserting some sample data in leaves_count table

INSERT INTO leaves_count (username, used_leaves) VALUES ('admin', 0);
INSERT INTO leaves_count (username, used_leaves) VALUES ('rajeev', 0);
INSERT INTO leaves_count (username, used_leaves) VALUES ('anupam', 0);
INSERT INTO leaves_count (username, used_leaves) VALUES ('vgunturi', 0);
INSERT INTO leaves_count (username, used_leaves) VALUES ('ravi', 0);
INSERT INTO leaves_count (username, used_leaves) VALUES ('ekta',0);
INSERT INTO leaves_count (username, used_leaves) VALUES ('satyam',0);

INSERT INTO login_sessions VALUES ('admin', NULL,NULL);
INSERT INTO login_sessions VALUES ('rajeev', NULL,NULL);
INSERT INTO login_sessions VALUES ('anupam', NULL,NULL);
INSERT INTO login_sessions VALUES ('vgunturi', NULL,NULL);
INSERT INTO login_sessions VALUES ('ravi', NULL,NULL);
INSERT INTO login_sessions VALUES ('ekta',NULL,NULL);
INSERT INTO login_sessions VALUES ('satyam',NULL,NULL);


INSERT INTO applied_leaves (username, start_date, end_date, leave_type, reason, comments, approved_by, result) VALUES ('vgunturi', '2021-03-02', '2021-03-03', 'NL', 'Important Work',NULL,NULL,'Pending');
INSERT INTO applied_leaves (username, start_date, end_date, leave_type, reason, comments, approved_by, result) VALUES ('vgunturi', '2021-04-20', '2021-04-27', 'NL', 'Detected Corona Positive',NULL,NULL,'Approved');
INSERT INTO applied_leaves (username, start_date, end_date, leave_type, reason, comments, approved_by, result) VALUES ('satyam', '2021-03-02', '2021-03-03', 'NL', 'Important Work',NULL,NULL,'Pending');
INSERT INTO applied_leaves (username, start_date, end_date, leave_type, reason, comments, approved_by, result) VALUES ('satyam', '2021-04-20', '2021-04-27', 'NL', 'Detected Corona Positive',NULL,'hod_ee','Approved');
INSERT INTO applied_leaves (username, start_date, end_date, leave_type, reason, comments, approved_by, result) VALUES ('anupam', '2021-03-02', '2021-03-03', 'NL', 'Important Work',NULL,NULL,'Pending');
INSERT INTO applied_leaves (username, start_date, end_date, leave_type, reason, comments, approved_by, result) VALUES ('anupam', '2021-04-20', '2021-04-27', 'NL', 'Detected Corona Positive',NULL,NULL,'Approved');
INSERT INTO applied_leaves (username, start_date, end_date, leave_type, reason, comments, approved_by, result) VALUES ('ankit', '2021-04-20', '2021-04-22', 'RL', 'Emergency',NULL,'dean_fa','Pending');
INSERT INTO applied_leaves (username, start_date, end_date, leave_type, reason, comments, approved_by, result) VALUES ('ankit', '2021-04-23', '2021-04-23', 'RL', 'Cold and fever',NULL,'director','Approved');
INSERT INTO applied_leaves (username, start_date, end_date, leave_type, reason, comments, approved_by, result) VALUES ('satyam', '2021-04-25', '2021-04-27', 'NL', 'Urgent work at home;',NULL,'hod_ee','Pending');


-- Inserting some sample data in appoint_info table
#INSERT INTO appoint_info (username, start_date, end_date) VALUES ('raviname', '2021-06-01', '2023-06-01');

-- SELECT * FROM login_info li, emp_info ei, applied_leaves al WHERE li.username = ei.username AND ei.username = al.username AND ei.department = 'CSE' AND al.result = 'Pending' AND li.profile_type <> 'hod_cse';
