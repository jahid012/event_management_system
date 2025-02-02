# Simple Event Management System

This project is a web-based event management system that allows users to create, manage, and view events, register attendees, and generate event reports.  It's built with Row PHP, HTML, CSS, and Bootstrap.

**Live URL:** The Live URL is available at `https://event.chromesurfer.com`

## Project Overview

This system provides a platform for managing events efficiently.  Users can create new events, update existing ones, view event details, and delete events they manage.  Attendees can register for events, and the system prevents overbooking by enforcing maximum capacity limits.  An event dashboard provides a clear overview of all events, with filtering, sorting, and pagination for easy navigation.  Finally, administrators can download attendee lists in CSV format for reporting purposes.

## Features

*   **User Authentication:** Secure user login and registration with password hashing.
*   **Event Management:** Create, update, view, and delete events with details like name, description, date, time, location, and maximum capacity.
*   **Attendee Registration:**  Form-based event registration with capacity management.
*   **Event Dashboard:** Paginated, sortable, and filterable display of events.
*   **Event Reports:** CSV download of attendee lists for specific events

## Installation Instructions

1.  **Clone the Repository On Your Server Or Local Environment:**
    ```bash
    git clone [https://github.com/](https://github.com/)[your-username]/[your-repository-name].git
    ```

2.  **Configure Database:**
        ```
        Create a database named `event_management` in your MySQL server.
        Import the SQL file to your database. The file is located at `database` folder.
        Update the database credentials in the `core/user/db_connect.php` file
        
        ```

3.  **Access the Application:**
    Open your web browser and navigate to `http://localhost/` (or the appropriate URL).

## Testing Login Credentials

For testing purposes, you can use the following credentials:

*   **User Credentials For Login:**
    *   Email: `admin@gmail.com`
    *   Password: `admin`