## About 

This project is running on PHP 8.2 + Laravel 10. It provides a private API for acquiring the day/week difference
between two dates, which are both optional to specify timezones for. To access the private API:
1. Navigate to the project folder via terminal. 
2. Enter "php artisan serve". The server will be running on http://{host}:{port}/api/register. Default: http://127.0.0.1:8000/api/register 
3. Create the database tables via command "php artisan migrate".
4. Register an account via POST "name, email, password, password_confirmation" to http://{host}:{port}/api/register. Once successful, it would return a private token for accessing the functions.
5. By default, a token does not expire until logging out by POST "bearer token" to http://127.0.0.1:8000/api/logout.
6. The expiration time of a token can be set by modifying config/sanctum.php: set 'expiration' => n seconds (default null).
7. To acquire a new token, log in to your account by POST "email, password" to http://127.0.0.1:8000/api/login.

To use the API, POST the private token, with 
- start_date (required; must be a date format using PHP standard)
- end_date (required; must be a date format using PHP standard)
- start_timezone (optional)
- end_timezone (optional)

to http://127.0.0.1:8000/api/days to find out the number of days
or http://127.0.0.1:8000/api/weeks to find out the number of whole weeks 
between start_date and end_date. 

Each API access record will be stored in the table date_time_api.

(Supported timezones are available at https://www.php.net/manual/en/timezones.php. If there is no timezone entry,
it sets "UTC" as the default timezone.)


