# Strive

## Overview
Strive is a web-based Job Board system built with Laravel, designed to connect Employers, Candidates, and Admins through a streamlined workflow of job posting, job searching, and job application management.

The system solves the difficulty job seekers face in discovering suitable job opportunities and provides employers with a centralized platform to publish and manage job listings. Admins ensure quality control by reviewing and approving job posts before they appear publicly.

## Problem Identification
Our research revealed that job seekers struggled with fragmented information sources, making it difficult to stay informed about upcoming job opportunities.
Traditional job search methods were ineffective in reaching the job seeker community, and job management was often disorganized.
This created a gap in communication between employers and candidates, leading to missed opportunities for employment.

## Solution
Strive addresses these challenges by providing a unified platform that allows candidates to easily discover, browse, and apply for jobs in one place.
Whether it's entry-level positions, internships, or full-time roles, Strive simplifies the process, offering an intuitive and efficient way for candidates to engage with the job market.

## Features

### 1. Public Features

#### 1.1 Job Listings
- **Description**: Displays a comprehensive list of available job posts from various employers.

#### 1.2 Job Details
- **Description**: Provides detailed information about each job, including description, requirements, location, and application instructions.

#### 1.3 Company Profiles
- **Description**: Allows viewing of employer profiles to learn more about companies.

#### 1.4 Categories and Employers Listings
- **Description**: Browse jobs by categories and view lists of employers.

#### 1.5 About and Contact Pages
- **Description**: Static pages providing information about the platform and contact details.

### 2. Candidate Features

#### 2.1 Job Applications
- **Description**: Candidates can apply to jobs and cancel applications if needed.

#### 2.2 Job Comments
- **Description**: Candidates can leave comments on job posts.

#### 2.3 Profile Management
- **Description**: Candidates can edit, update, and delete their profiles.

#### 2.4 Notifications
- **Description**: Candidates receive notifications about job updates, application status, etc., and can manage them (view, mark as read).

### 3. Employer Features

#### 3.1 Dashboard
- **Description**: Employers have a personalized dashboard to manage their activities.

#### 3.2 Job Management
- **Description**: Employers can create, view, edit, update, and delete job posts.

#### 3.3 Application Management
- **Description**: Employers can view applications for their jobs, update application status, download resumes, and preview applications.

#### 3.4 Comment Management
- **Description**: Employers can view comments on their jobs and manage them.

#### 3.4 Notifications
- **Description**: Employers receive notifications about job Post approval or rejection updates, application status, etc., and can manage them (view, mark as read).

#### 3.5 Analytics
- **Description**: Emplolyers can access analytics data.

#### 3.5 Candidate Viewing
- **Description**: Employers can view candidate profiles.

#### 3.6 Profile Management
- **Description**: Employers can edit, update, and delete their profiles.

### 4. Admin Features

#### 4.1 Dashboard
- **Description**: Admins have a dashboard to oversee the platform.

#### 4.2 User Management
- **Description**: Admins can view, edit, update, and delete user accounts.

#### 4.3 Job Post Management
- **Description**: Admins can view, edit, update, and delete job posts.

#### 4.4 Comment Management
- **Description**: Admins can view and delete comments.

#### 4.5 Notifications
- **Description**: Admins can view notifications.

#### 4.6 Analytics
- **Description**: Admins can access analytics data.


## Used Libraries:
- **Web Auth With Breeze**

## ROUTS

| HTTP Method | EndPoint                    | Description                                                    |
|-------------|-----------------------------|----------------------------------------------------------------|
| GET         | /                           | Job listings index                                             |
| GET         | /jobs/{jobPost}             | Show specific job details                                      |
| GET         | /companies/{employer}       | Show employer profile                                          |
| GET         | /categories                 | Public categories index                                        |
| GET         | /employers                  | Public employers index                                         |
| GET         | /about                      | About page                                                     |
| GET         | /contact                    | Contact page                                                   |
| POST        | /contact                    | Store contact form                                             |
| POST        | /comments                   | Store job comment                                              |
| POST        | /applications               | Store job application                                          |
| POST        | /applications/cancel/{id}   | Cancel application                                             |
| GET         | /profile                    | Edit profile                                                   |
| PATCH       | /profile                    | Update profile                                                 |
| DELETE      | /profile                    | Destroy profile                                                |
| GET         | /notifications/page         | Notifications page                                             |
| GET         | /notifications              | Get notifications                                              |
| GET         | /notifications/count        | Get notifications count                                        |
| POST        | /notifications/{id}/read    | Mark notification as read                                      |
| POST        | /notifications/read-all     | Mark all notifications as read                                 |
| DELETE      | /notifications/{id}         | Delete notification                                            |
| GET         | /auth/linkedin/redirect     | LinkedIn auth redirect                                         |
| GET         | /admin/dashboard            | Admin dashboard                                                |
| GET         | /admin/users                | Admin users index                                              |
| GET         | /admin/users/{user}         | Admin show user                                                |
| GET         | /admin/users/{user}/edit    | Admin edit user                                                |
| PUT         | /admin/users/{user}         | Admin update user                                              |
| DELETE      | /admin/users/{user}         | Admin destroy user                                             |
| GET         | /admin/posts                | Admin job posts index                                          |
| GET         | /admin/posts/{post}         | Admin show job post                                            |
| GET         | /admin/posts/{post}/edit    | Admin edit job post                                            |
| PUT         | /admin/posts/{post}         | Admin update job post                                          |
| DELETE      | /admin/posts/{post}         | Admin destroy job post                                         |
| GET         | /admin/comments             | Admin comments index                                           |
| GET         | /admin/comments/{comment}   | Admin show comment                                             |
| DELETE      | /admin/comments/{comment}   | Admin destroy comment                                          |
| GET         | /admin/notifications        | Admin notifications                                            |
| GET         | /admin/analytics            | Admin analytics index                                          |
| GET         | /employer/dashboard         | Employer dashboard                                             |
| GET         | /employer/profile           | Employer edit profile                                          |
| PUT         | /employer/profile           | Employer update profile                                        |
| DELETE      | /employer/profile           | Employer destroy profile                                       |
| GET         | /employer/jobs              | Employer jobs index                                            |
| GET         | /employer/jobs/create       | Employer create job                                            |
| GET         | /employer/jobs/{job}/edit   | Employer edit job                                              |
| GET         | /employer/jobs/{job}        | Employer show job                                              |
| POST        | /employer/jobs              | Employer store job                                             |
| PUT         | /employer/jobs/{job}        | Employer update job                                            |
| DELETE      | /employer/jobs/{job}        | Employer destroy job                                           |
| GET         | /employer/applications      | Employer applications index                                    |
| GET         | /employer/applications/{application} | Employer show application                             |
| PATCH       | /employer/applications/{application}/status | Employer update application status             |
| GET         | /employer/applications/{application}/download | Employer download application                |
| GET         | /employer/applications/{application}/preview | Employer preview application                  |
| GET         | /employer/comments          | Employer comments index                                        |
| GET         | /employer/comments/{comment}| Employer show comment                                          |
| GET         | /employer/jobs/{job}/comments | Employer comments for job                                    |
| GET         | /employer/candidates/{user} | Employer show candidate                                        |



## Installation Instructions

### Prerequisites
Ensure that you have the following installed on your local machine:

- [XAMPP](https://www.apachefriends.org/) (which includes PHP, MySQL, and Apache)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) and npm (for frontend assets)


### Installation Steps

1. Clone the repository from GitHub:

    ```bash
    git clone https://github.com/Abdelrohmanaliabas/strive.git
    ```

2. Install the PHP dependencies using Composer:

    ```bash
    composer install
    ```

3. Copy the `.env.example` file to create your environment configuration:

    ```bash
    cp .env.example .env
    ```

4. Generate an application key:

    ```bash
    php artisan key:generate
    ```

5. Install Laravel Breeze:

    ```bash
    composer require laravel/breeze --dev
    ```

6. Install Breeze and run the scaffolding (depending on whether you are using Blade or Inertia):

    For Blade:

    ```bash
    php artisan breeze:install
    ```


7. Create a database and configure your `.env` file:

    - Create a new database in your XAMPP (or other MySQL setup).
    - Open the `.env` file and update the following lines with your database details:

    ```env
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

    Once the `.env` file is updated with the correct database information, run the database migrations:

    ```bash
    php artisan migrate
    ```

8. Configure LinkedIn and Mail settings in your `.env` file:

    For LinkedIn authentication:

    ```env
    LINKEDIN_CLIENT_ID=your_linkedin_client_id
    LINKEDIN_CLIENT_SECRET=your_linkedin_client_secret
    LINKEDIN_REDIRECT_URI=http://localhost:8000/auth/linkedin/callback
    ```

    For Mail configuration:

    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=your_smtp_host
    MAIL_PORT=587
    MAIL_USERNAME=your_email@example.com
    MAIL_PASSWORD=your_email_password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=your_email@example.com
    MAIL_FROM_NAME="${APP_NAME}"
    ```

9. Install Node.js dependencies and build the frontend assets:

    ```bash
    npm install
    npm run dev
    ```

### Running the Application

1. Start the local development server:

    ```bash
    php artisan serve
    ```

2. Open your browser and navigate to:

    ```
    http://localhost:8000
    ```





