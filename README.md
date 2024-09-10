# **Quick Bill**

## Table of Contents
1. Features
2. Technology Stack
3. Database Structure
4. Installation Guide
5. How to Prepare the Database
6. License

## Features
Quick Bill is the best ticket management application on the market. Users can buy tickets, view their available tickets, and check expired ones to keep track of their tickets usage efficiently. Administrators can manage the system by adding new providers, specifying locations, defining transport types, and creating ticket types with custom expiration times. This allows administrators to configure and maintain the system’s transportation options and ticketing rules, ensuring the system meets operational needs.

## Technology Stack
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: PostgreSQL
- **Containerization**: Docker
- **Web Server**: Nginx

## Database Structure
The database schema is represented by the following diagram:

![Database Structure](https://github.com/grelory/WDPAI/blob/main/WDPAI_DOCKER/resources/qb-erd.png?raw=true)

## Installation Guide
To set up the application locally, follow these steps:

1. Clone the repository to your local machine:
    ```bash
    git clone git@github.com:Grelory/WDPAI.git
    ```
2. Navigate to the project directory:
    ```bash
    cd WDPAI/WDPAI_DOCKER
    ```
3. Build and run the Docker containers:
    ```bash
    docker-compose build
    docker-compose up
    ```

## How to Prepare the Database
1. Log in to **pgAdmin** by visiting [http://localhost:5050](http://localhost:5050).
2. Use the following credentials to log in:
    - Username: `admin@example.com`
    - Password: `admin`
3. Once logged in, open the **Query Tool** from the navigation menu.
4. Copy the SQL file **`WDPAI/WDPAI_DOCKER/db-scripts/database.sql`** and execute it in the query tool.

## Demo

### Endpoints:
- **`/user/buy`**: 
    - Allows users to purchase tickets. Users specify the location, transport type, ticket type, and other details during the purchase process.

- **`/user/available`**: 
    - Displays all active tickets purchased by the user. 

- **`/user/expired`**: 
    - Shows all tickets that have expired and are no longer valid for use.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
