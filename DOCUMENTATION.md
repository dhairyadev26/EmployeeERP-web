# Employee ERP System - Technical Documentation

## Architecture Overview

This Employee ERP System follows the Model-View-Controller (MVC) architecture pattern using the CodeIgniter PHP framework. The application is designed with separation of concerns and role-based access control.

## Database Schema

### Tables Structure

#### employee_details
- **Purpose:** Stores all user accounts (both admin and employees)
- **Key Fields:**
  - `id`: Primary key
  - `employee_id`: Unique employee identifier
  - `role`: User role (Admin/Employee)
  - `first_name`, `last_name`: User names
  - `contact_email`: Login email
  - `contact_number`: Phone number (also used as employee password)
  - `password`: MD5 hashed password
  - `status`: Account status (0=active, 1=inactive)

#### project_details
- **Purpose:** Stores customer project information
- **Key Fields:**
  - `project_id`: Unique project identifier
  - `first_name`, `last_name`: Customer names
  - `contact_email`, `contact_number`: Customer contact info
  - `deadline`: Project deadline
  - `employee_id`: Assigned employee
  - `status`: Project status

#### update_work
- **Purpose:** Stores daily work updates from employees
- **Key Fields:**
  - `project_id`: Reference to project
  - `employee_id`: Employee who submitted update
  - `description`: Work description
  - `created_time`: Timestamp of update

## Application Flow

### Authentication Flow
1. User accesses application root
2. `route/index` checks for existing session
3. If authenticated, redirect to appropriate dashboard
4. If not, show login form
5. Login form submits to `admin/index`
6. Credentials validated against database
7. Session created with user role and details

### Admin Workflow
1. **Dashboard Access:** View employee and project summaries
2. **Employee Management:**
   - Add new employees
   - Edit existing employee details
   - View employee work history
3. **Project Management:**
   - Create customer projects
   - Assign projects to employees
   - Monitor project progress
4. **Financial Tracking:**
   - View transaction history
   - Generate balance sheets

### Employee Workflow
1. **Dashboard Access:** View assigned projects
2. **Work Updates:**
   - Submit daily work descriptions
   - View personal work history
3. **Project Tracking:**
   - See project deadlines
   - Monitor project details

## Code Structure

### Controllers

#### admin.php
- **Responsibility:** Handles all administrative functions
- **Key Methods:**
  - `index()`: Login processing
  - `addemployee()`: Employee creation
  - `editemployee()`: Employee modification
  - `addproject()`: Project creation
  - `addtransaction()`: Financial transactions

#### route.php
- **Responsibility:** Application routing and session management
- **Key Methods:**
  - `index()`: Entry point and login page
  - `dashboard()`: Role-based dashboard routing
  - `logout()`: Session destruction

### Models

#### admin_model.php
- **Responsibility:** Database operations for admin functions
- **Key Methods:**
  - `login()`: User authentication
  - `fetch_employee()`: Employee data retrieval
  - `fetch_project()`: Project data retrieval
  - `add_employee()`: New employee creation
  - `update_employee()`: Employee data updates

#### employee_model.php
- **Responsibility:** Database operations for employee functions
- **Key Methods:**
  - `fetch_project()`: Get assigned projects
  - `addwork()`: Submit work updates
  - `fetch_project_id()`: Get available project IDs

### Views

#### Dashboard Views
- `dashboard.php`: Admin dashboard with comprehensive overview
- `employeedashboard.php`: Employee dashboard with personal data

#### Employee Management Views
- `addemployee.php`: Employee creation form
- `editemployee.php`: Employee modification form

#### Project Management Views
- `addproject.php`: Project creation form
- `editproject.php`: Project modification form

#### Transaction Views
- `addtransaction.php`: Work update submission
- `viewbalance.php`: Financial summary
- `viewemployeehistory.php`: Employee work history
- `viewprojecthistory.php`: Project progress history

## Security Features

### Authentication
- MD5 password hashing (Note: Consider upgrading to stronger hashing)
- Session-based authentication
- Role-based access control

### Access Control
- Session validation on all protected pages
- Role-based view rendering
- Direct access prevention to unauthorized areas

### Data Validation
- Form validation using CodeIgniter validation library
- SQL injection prevention through query binding
- XSS protection through input filtering

## Configuration Files

### Database Configuration
- **File:** `application/config/database.php`
- **Purpose:** Database connection settings
- **Key Settings:**
  - Hostname, username, password
  - Database name
  - Character set and collation

### Routes Configuration
- **File:** `application/config/routes.php`
- **Purpose:** URL routing rules
- **Default Route:** Points to route controller

### Form Validation
- **File:** `application/config/form_validation.php`
- **Purpose:** Validation rules for forms
- **Rules:** Login validation, employee form validation

## Asset Management

### CSS Stylesheets
- Located in `Assest/Css/` directory
- Separate stylesheets for different modules:
  - `styledashboard.css`: Admin dashboard styling
  - `styleemployeedashboard.css`: Employee dashboard styling
  - `styleemployee.css`: Employee form styling
  - `styleproject.css`: Project management styling

### JavaScript Dependencies
- jQuery: Loaded via CDN for DOM manipulation
- Google Fonts: Loaded via CDN for typography

## Deployment Considerations

### System Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache with mod_rewrite enabled
- Internet connection for CDN resources

### Performance Optimization
- Enable PHP OPcache for better performance
- Use database indexing for frequently queried fields
- Implement caching for static assets
- Consider minifying CSS/JS files

### Security Hardening
- Update password hashing to bcrypt/Argon2
- Implement CSRF protection
- Add input sanitization
- Use prepared statements consistently
- Enable HTTPS in production

## Maintenance Guidelines

### Regular Tasks
- Monitor database performance
- Check error logs regularly
- Update dependencies
- Backup database regularly

### Code Quality
- Follow PSR coding standards
- Implement automated testing
- Use version control effectively
- Document code changes thoroughly

## Future Enhancements

### Suggested Improvements
1. **Modern Authentication:** Implement JWT or OAuth
2. **API Development:** Create REST API for mobile integration
3. **Real-time Updates:** Add WebSocket support
4. **Advanced Reporting:** Implement comprehensive analytics
5. **File Management:** Add document upload/download features
6. **Email Notifications:** Automated project deadline reminders
7. **Mobile Responsiveness:** Improve mobile user experience
