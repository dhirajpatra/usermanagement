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

4. You can use sql to create your database from documents folder. Also can use migration script to create database.
[Datafixutre with test not beed completed due to lack of time]
But better to Run following ORM commands [later we can create a app command for these commands as well]:

`./bin/console doctrine:database:drop --force`

`./bin/console doctrine:database:create`

`./bin/console doctrine:schema:create`

`./bin/console doctrine:fixtures:load`
[Ans: yes]

5. Run symfony server by: `./bin/console server:run`

6. Check as per the direction from above command output

### How to run tests

1. You need to install lib curl & phpunit. While testing server should be running.
2. Run above ORM commands in order
3. Start server `./bin/console server:run`
4. To tests all 3 files run following command:  `./bin/phpunit`

### REST API with eg. payload
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






