# Event Management System

Sir my project allows users to create, manage, and view events, register attendees, and generate event reports.  It's built with Pure PHP, HTML, CSS, and Bootstrap.

**Live URL:** The Live URL is available at `https://chromesurfer.net/`

## Testing Login Credentials

*   **User Credentials For Login:**
    *   Email: `admin@gmail.com`
    *   Password: `admin`

## Project Overview

This system provides a platform for managing events efficiently.  Users can create new account, events, update, view event details, and delete events.  Attendees can register for events, it prevents overbooking by enforcing maximum capacity limits.  An event dashboard provides a clear overview of all events, with filtering, sorting, and pagination for easy navigation.  Finally, users can download attendee lists in CSV format for reporting purposes.

## Features

*   **User Authentication:** Secure user login and registration with password hashing.
*   **Event Management:** Create, update, view, and delete events with details like name, description, date, time, address, and maximum capacity.
*   **Attendee Registration:**  Form-based event registration with capacity management.
*   **Event Dashboard:** Paginated, sortable, and filterable display of events.
*   **Event Reports:** CSV download of attendee lists for specific events

## Installation Instructions

1.  **Clone the Repository On Your Server Or Local Environment:**
    ```bash
    git clone https://github.com/jahid012/event_management_system.git
    ```

2.  **Configure Database:**
        Please create a database named `event_management` in your MySQL server.
        Import the SQL file to your database. The file is located at `database` folder in the source code after that
        Update the database credentials in the `core/user/db_connect.php` file


3.  **Access the Application:**
    Please navigate to `http://localhost/` **(or the appropriate URL)** to open the project.


## Server requirements

PHP Version above 7.4
MySQL Version 5.7+ or MariaDB version 10.3+

```bash
MD. Jahid Hasan Badhon 
Phone: +8801795891261 
Email: jahid11.bgd@gmail.com
```