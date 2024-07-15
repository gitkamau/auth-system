ReadMe.md
## Authentication & Authorization
This involves implementing a comprehensive authentication and authorization system for a web application. Below are the key components and steps involved:

# User Registration Process
Students: Implement a registration form that collects necessary details (e.g., name, email, university, major) and verifies their email address.
University Admins: Require email verification.
Company Recruiters: Implement a business email verification process.

# Login Mechanisms
Email/Password: Use secure password storage techniques and implement account lockout mechanisms to prevent brute-force attacks.
OAuth:  Utilize Laravel Passport for OAuth and SSO implementation.

# Role-Based Access Control (RBAC)
Define Roles: Define roles (e.g., student, university admin, recruiter) and permissions for each role.
Enforce RBAC: Implement middleware to enforce RBAC on routes and resources.
# Security Measures
HTTPS: Use HTTPS for all communications.
Update and Patch: Regularly update and patch dependencies.
Security Considerations: Use JWT tokens with short expiry times and implement refresh tokens. Ensure tokens are signed and encrypted.

## Instructions to Run Authentication & Authorization
Prerequisites
- Laravel Framework: Make sure you have Laravel installed.
- Database: Set up a PostgreSQL .env file accordingly.

## Step-by-Step Backend Setup
1. Clone the repository to your local machine:
- git clone https://github.com/mary-kamau/auth-system.git
- cd backend

2. Install Dependencies
Install the necessary dependencies using Composer:
- composer install

3. Generate Application Key

Generate the application key:
- php artisan key:generate

4. Environment Configuration
Copy the .env.example file to .env and configure your environment settings:
- cp .env.example .env

Update the .env file with your database credentials and email verification and other necessary configurations:

DB_CONNECTION=pgsql
DB_HOST=db_host
DB_PORT=5432
DB_DATABASE=database
DB_USERNAME=db_username
DB_PASSWORD=db_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME="mail_from"
MAIL_PASSWORD="mail_from_password"
MAIL_ENCRYPTION=TLS
MAIL_FROM_ADDRESS="mail_from"
MAIL_FROM_NAME="${APP_NAME}"

5. Run Migrations

Run the database migrations to create the necessary tables:
- php artisan migrate

6. Passport Configuration for Oauth
- php artisan passport:install
- php artisan migrate
Generate a client for issuing tokens to users based on their password. This is suitable for first-party clients where the client can securely store and handle user credentials.
 - php artisan passport:client --password

Add these to .env for passprt configuration
PASSPORT_PRIVATE_KEY="path/to/passport/private key"
PASSPORT_PUBLIC_KEY="path/to/passport/public key"
PASSPORT_CLIENT_ID=passport client id
PASSPORT_CLIENT_SECRET=passport client secret(ensure this is exactly the same as it appears in the oauth_clients table in the databse for the abbove respective client id)

7. Run the application
- php artisan serve

## Step-by-Step Frontend Setup
Prerequisites
- Vue Framework: Make sure you have Vue installed.
- cd frontend
- cd auth-frontend

2. Install Dependencies
Install the necessary dependencies using npm:
- npm install

3. Environment Configuration
Copy the .env.example file to .env and configure your environment settings:
- cp .env.example .env
- Fill in the backend host

VUE_APP_BACKEND_API_URL={backend-host}/api/

4. Run the application
- npm run se4rve