# Project Name: The Enchanted Cauldron

## Project Description
The Enchanted Cauldron is a PHP and MySQL web application designed as an online magic-themed store. The application allows users to browse products stored in a MySQL database, add products to a shopping cart, increase or decrease product quantities, remove products, and complete the checkout process. The application uses the Model-View-Controller (MVC) architecture to separate database processing, application logic, and the user interface.

The shopping cart calculates individual item totals, the total number of items ordered, subtotal, 5% tax, 10% shipping and handling, and the final order total.

## Project Tasks
- **Task 1: Plan the online store**
  - Determine the information needed for products in the store
  - Plan the catalog, shopping cart, navigation, and database structure

- **Task 2: Create the MySQL database**
  - Create the `kuhnke_magic_shop` database
  - Create the `products` table
  - Add five products with product IDs, names, descriptions, and prices
  - Create an SQL script that can recreate the database and product data

- **Task 3: Create the store interface**
  - Create a home page for The Enchanted Cauldron
  - Create a catalog that displays products from the database
  - Add product images and store styling using CSS
  - Add navigation between the Home, Catalog, and Shopping Cart pages

- **Task 4: Develop the shopping cart**
  - Allow products to be added to the shopping cart
  - Allow quantities to be increased or decreased
  - Prevent quantities from going below zero
  - Allow products to be removed from the cart
  - Maintain cart information using PHP sessions

- **Task 5: Apply MVC architecture**
  - Move database and product processing into the Model
  - Organize the catalog and shopping cart interfaces into Views
  - Create Controllers to process catalog and shopping cart actions
  - Preserve existing store functionality after converting the application to MVC

- **Task 6: Complete cart calculations**
  - Calculate individual product totals
  - Display the total number of items ordered
  - Calculate the cart subtotal
  - Calculate 5% tax
  - Calculate 10% shipping and handling
  - Calculate the final order total

- **Task 7: Complete checkout**
  - Allow the user to complete the checkout process
  - Clear the shopping cart after checkout
  - Return the user to the catalog page

- **Task 8: Test the application**
  - Test product display and navigation
  - Test adding and removing products
  - Test increasing and decreasing quantities
  - Verify quantities cannot go below zero
  - Verify cart calculations
  - Test checkout and cart clearing
  - Verify the SQL script can create the required database structure

- **Task 9: Document and manage the project**
  - Maintain the project using Git and GitHub
  - Update the project plan throughout development
  - Document application testing
  - Create GitHub tags for project phases
  - Complete the final project documentation

## Project Skills Learned
- PHP web application development
- MySQL database creation and management
- Connecting PHP applications to MySQL
- Model-View-Controller (MVC) architecture
- PHP session management
- Shopping cart development
- HTML and CSS web design
- Application testing and debugging
- SQL database exporting and importing
- Version control with Git and GitHub
- Iterative project planning and development
- Technical documentation

## Language Used
- **PHP**: Server-side application processing, controllers, models, shopping cart functionality, and session management
- **HTML**: Structure and content of the web application
- **CSS**: Styling and visual design of The Enchanted Cauldron
- **JavaScript**: Updating shopping cart quantities and content without navigating away from the page
- **SQL/MySQL**: Storing and retrieving product information

## Development Process Used
- **Agile Methodology**: The application was developed incrementally throughout the course. Features were planned, developed, tested, and improved each week. The project progressed from the initial store framework and database to database-supported functionality, MVC architecture, final calculations, checkout, testing, and documentation.

## Notes
- XAMPP is used to run Apache and MySQL locally.
- The project should be placed inside the XAMPP `htdocs` directory.
- Apache and MySQL must be running in XAMPP before opening the application.
- Import the included `kuhnke_magic_shop.sql` file into MySQL/phpMyAdmin before running the database-supported portions of the application.
- The SQL script includes the `CREATE DATABASE IF NOT EXISTS kuhnke_magic_shop` statement and creates the required product table and product records.
- The application uses PHP sessions to maintain shopping cart information.
- The application is designed to run locally using a `localhost` URL.

## Link to Project
[The Enchanted Cauldron Repository](https://github.com/KerrKuh7439/SimpleWebApplication.git)

## License
This project is licensed under the GNU License - see the [LICENSE](LICENSE) file for details.
