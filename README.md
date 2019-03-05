## User management system
###   This application Stories

There are always many improvement possible in this application. As this has been created in a very tight time.
That's why all types of tests and validation was not possible to implement.
But I have tried to create a perfect Symfony 4.2 and high quality structure for the application which can be extended. As it is based on SOLID principal.

   `As an admin I can add users — a user has a name.`

   `As an admin I can delete users.`

   `As an admin I can assign users to a group they aren’t already part of.`

   `As an admin I can remove users from a group.`

   `As an admin I can create groups.`

   `As an admin I can delete groups when they no longer have members.`

### All documents are in </documents/> folder

### How to install and run

1. clone this repository
2. cd to your clone directory
3. Run: composer install
4. Run symfony server by: ./bin/console server:run
5. Check as per the direction from above command output
6. You can use sql to create your database from documents folder. Also can use migration script to create database.

### How to run tests

1. You need to install phpunit
<<<<<<< HEAD
2. Update userid and/or groupid with appropriate values from your DB [if no value then create from APIs]
=======
2. Update userid and/or groupid with appropriate values from your DB
>>>>>>> e5ace3e7d2fbb6a272d3b4280776b7ab18222bfd
3. To tests all 3 files run following commands:

[change this value as per your DB] eg. private $id = 37;

`./bin/phpunit tests/Usermanagement/Controller/Rest/GroupControllerTest.php`

[change this value as per your DB] eg. private $id = 37;

`./bin/phpunit tests/Usermanagement/Controller/Rest/UserControllerTest.php`

[change this value as per your DB] eg. private $userid = 29;
private $groupid = 38;

`./bin/phpunit tests/Usermanagement/Controller/Rest/GroupuserControllerTest.php`

### REST API with payload
Header: content-type: application/json

1.	http://localhost:8000/api/group [create group]
	Method: POST
	{"groupname": "admin"}
	[Vaidation: at least 5 character long. no space. no duplicate]

2.	http://localhost:8000/api/group [delete group]
	Method: DELETE
	{"groupid": "4"}
	[Vaidation: if user associated with this group then not delete]

3.	http://localhost:8000/api/user [create user]
	Method: POST
	{"username": "dhirajatra"}
	[Vaidation: at least 5 character long. no space. no duplicate]

4.	http://localhost:8000/api/user [delete user]
	Method: DELETE
	{"userid": "1"}
	[Vaidation: if user associated with a group that record also be delete]

5.	http://localhost:8000/api/groupuser[assigning a user to a group]
	Method: POST
	{"userid": "1", "groupid": "5"}
	[Validation: user and group must exist. association must not be duplicated.]

6.	http://localhost:8000/api/groupuser  [deassigning a user from a group]
	Method: DELETE
	{"userid": "1", "groupid": "5"}
	[Validation: user and group must exist.]






