# RestFul Api - example by Gligorije
	* Custom PHP API example witout any framework
	* This example shows how one should restful service work
	* Database Wrapper with the Singleton Pattern
	* Through the developing process, I use Postman for testing endpoints 
	* RestFul Api support method: GET (data display), POST (data entry), PUT (updating data), DELETE (deleting data)

### How to install
	* Clone/Download this repository to local machine or in some server
	* Find in root folder database file (restful.sql) and import 
	* In database.php from line 7 add your logins/database parameters for postgreSQL
	* If you run on local please uncomment on php.ini ( for postgres ):
		● extension=pgsql
		● extension=pdo_pgsql
	* Use Postman collection for endpoints: https://www.getpostman.com/collections/98f063019960261f48e8 (replace local ip if you tested on server)
	* You need to have PHP 8 version or above 

### Other information
	* This is a simple example of creating Api from scratch without using some framework
	* Api contains data processing for users ( I took as an example how endpoints should work )
	* I use Google Authenticator for 2fa authorization ( only generate code ) and use for login entry ( expired 2 minutes )
		● There is an option to send code to email ( whttps://www.php.net/manual/en/function.mail.php ), but of course can integrate some smtp solutions.
		● I added the 2fa folder for Google Authenticator but if you have a problem with it, please run on composer ( composer require vectorface/googleauthenticator ) and save it on 2fa folder ( in root directory of this project )

	* User:
		● Can complete the registration step
		● Can login
		● Can update their name
		
	* Administrator
		● Can do everything a User can do
		● Can create a new account (Users and Administrators)
		● Can deactivate an account 