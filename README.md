🌸 LAVENDA BEAUTY

LAVENDA BEAUTY is a web-based beauty and skincare store designed to provide customers with a simple and convenient way to explore beauty products, create accounts, and manage their orders.

The project is built using PHP and MySQL, with a responsive frontend developed using HTML, CSS, and JavaScript.

⸻

📌 Table of Contents

* About the Project
* Features
* Technologies Used
* Project Structure
* Requirements
* Installation and Setup
* Database Configuration
* Usage
* Future Improvements
* Copyright

⸻

💗 About the Project

LAVENDA BEAUTY is an online store focused on beauty and skincare products. It provides a user-friendly interface where visitors can browse the website, explore available products, register for an account, log in, and access order-related functionality.

The project aims to combine a clean design with basic e-commerce functionality using a straightforward PHP and MySQL architecture.

⸻

✨ Features

* Homepage: Introduces the store and provides access to its main sections.
* Product Browsing: Allows visitors to explore available beauty and skincare products.
* User Registration: Enables new customers to create an account.
* User Authentication: Allows registered customers to log in and log out.
* Order Management: Provides order-related functionality through the website.
* Contact Page: Offers a dedicated page for customer inquiries.
* Reusable Components: Uses shared header and footer files to maintain consistency across pages.
* Database Integration: Uses MySQL to store and manage application data.
* Custom Styling: Includes dedicated CSS and JavaScript files for the website’s appearance and interactions.

⸻

🛠️ Technologies Used

Technology	Purpose
HTML5	Structures the website’s content.
CSS3	Controls the layout, styling, and visual appearance.
JavaScript	Adds client-side interactivity.
PHP	Handles server-side logic and page processing.
MySQL	Stores and manages application data.
XAMPP	Provides a local development environment for PHP and MySQL.

⸻

📂 Project Structure

The project is organized into the following directories and files:

meme-lavenda-main/
│
├── assets/
│   ├── css/
│   │   └── style.css
│   │
│   └── js/
│       └── script.js
│
├── config/
│   └── db.php
│
├── database/
│   └── lavenda_db.sql
│
├── includes/
│   ├── header.php
│   └── footer.php
│
├── cart.php
├── contact.php
├── index.php
├── login.php
├── logout.php
├── order.php
├── products.php
├── register.php
│
└── README.md

Directory and File Description

assets/

Contains the static resources used by the website.

* css/style.css — Contains the website’s styling and layout rules.
* js/script.js — Contains client-side JavaScript functionality.

config/

Contains configuration files required by the application.

* db.php — Defines the database connection settings used by the PHP application.

database/

Contains the SQL file used to initialize the database.

* lavenda_db.sql — Contains the database structure and any data included in the provided SQL file.

includes/

Contains reusable PHP components shared across multiple pages.

* header.php — Provides the shared website header.
* footer.php — Provides the shared website footer.

Main PHP Files

File	Description
index.php	The main homepage of the store.
products.php	Displays the available products.
cart.php	Handles the cart-related functionality provided by the project.
order.php	Handles order-related functionality.
contact.php	Provides the contact page.
register.php	Handles customer registration.
login.php	Handles user login.
logout.php	Handles user logout.
README.md	Documents the project, its structure, and setup instructions.

⸻

💻 Requirements

Before running the project, make sure you have the following installed:

* XAMPP or another compatible local server environment.
* PHP, supported by your chosen server environment.
* MySQL or MariaDB.
* A modern web browser.
* A code editor, such as Visual Studio Code, for optional modifications.

⸻

🚀 Installation and Setup

Follow these steps to run LAVENDA BEAUTY locally.

1. Download the Project

Download or clone the project repository to your computer.

If you downloaded the project as a ZIP file, extract it first.

2. Move the Project to the Server Directory

If you are using XAMPP, move the project folder into the htdocs directory.

For example:

C:\xampp\htdocs\meme-lavenda-main\

Make sure the main project files, including index.php, are inside the project directory.

3. Start Apache and MySQL

Open the XAMPP Control Panel and start these services:

* Apache
* MySQL

Both services should be running before proceeding.

4. Create the Database

Open phpMyAdmin in your browser:

http://localhost/phpmyadmin/

Import the provided SQL file:

database/lavenda_db.sql

To import the file:

1. Open phpMyAdmin.
2. Select the Import tab.
3. Choose lavenda_db.sql from the project directory.
4. Execute the import.
5. Confirm that the database and its tables have been created successfully.

If the SQL file does not create the database automatically, create the database with the name expected by the SQL file or the application’s database configuration before importing it.

5. Configure the Database Connection

Open the following file:

config/db.php

Check the database connection settings and update them to match your local environment.

Typical settings include:

* Database host
* Database name
* Database username
* Database password

For a standard local XAMPP installation, the host is often localhost, and the default MySQL username is commonly root. The password depends on your local configuration.

Use the actual database name defined in the SQL file and expected by the application.

6. Run the Website

Open the following address in your browser:

http://localhost/meme-lavenda-main/

If you renamed the project folder, replace meme-lavenda-main with the new folder name.

The LAVENDA BEAUTY homepage should now appear.

⸻

⚙️ Database Configuration

The project uses MySQL to store application data.

The database connection is configured in:

config/db.php

The database initialization file is located at:

database/lavenda_db.sql

Before using the website, ensure that:

* The MySQL service is running.
* The database has been imported successfully.
* The database name matches the application configuration.
* The username and password are correct.
* The PHP application has permission to connect to the database.

Security note: Do not publish database credentials, production passwords, or other sensitive configuration details in a public repository.

⸻

📖 Usage

Once the website is running, visitors can navigate through the available pages to explore the store’s functionality.

1. Open the homepage to access the main website sections.
2. Visit the products page to browse available beauty and skincare products.
3. Create an account through the registration page.
4. Log in using an existing account.
5. Access the order-related pages and functionality provided by the application.
6. Visit the contact page to access the store’s contact interface.
7. Log out when finished using the account.

The available functionality depends on the implementation of each page and the database configuration.

⸻

🔮 Future Improvements

The project could be extended with additional features, including:

* Online payment integration.
* Product search, filtering, and sorting.
* Product categories and detailed product pages.
* Improved cart and checkout functionality.
* Order status tracking.
* An administrative dashboard for managing products and orders.
* Product reviews and customer ratings.
* Enhanced security, input validation, and error handling.
* Responsive design improvements for mobile devices.
* Automated testing and deployment.

These are potential future enhancements and are not necessarily implemented in the current version.

⸻

© Copyright

جميع الحقوق محفوظة منهل عبدالمعطي.

All rights reserved to Manhal Abdelmoaty.

Unauthorized copying, redistribution, or modification of this project without prior permission from the copyright holder is prohibited.
