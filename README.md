# VGCDB: Video Game Characters DataBase

> Website providing information about characters from video games of various universes (or series/franchises).

## Technologies Used

- HTML (client-side)
- CSS (stylesheets)
- JavaScript (scripting)
- PHP (server-side)
- AJAX (+ PHP) (for asynchronous communication with the server for search results and adding a character to favorites)
- PostgreSQL (+ SQL & pgAdmin) (relational database management)

## External Libraries

- JQuery (scripting)
- Three.js (3D graphics visualization and animations on the site's homepage)

## Additional Tools

- Blender (3D graphics software for modeling the 3D character "Super Mario" and its animations, rigging, texturing, etc.)
- Adobe Illustrator (initial page design/mockup, image manipulation, SVG manipulation, and creating icons for site elements)
- Google Sheets (handling and creating character data for the database, later imported into the database as CSV)
- Wikipedia (source of information for characters in the database)

## Team Members

- Valerio Di Stefano (student ID: 1898728)
- Giuseppe Prisco (student ID: 1895709)

## General Functionality Description of the Site

The website allows users to search for characters by name and other additional filters (name, universe of origin, year of first appearance, role in the game, gender, hair color, and eye color) from the Advanced Search, HomePage (using the character name search bar), and Results Page (using the side filters).

Various data integrity checks and format validations have been implemented on the character search filter form (e.g., checks on the year of first appearance range).

Character information and details are stored in a local relational database managed with PostgreSQL.

The site allows users to view information about a character on a dedicated page, including name, universe of origin, description, character and banner images, year of first appearance, role in the game, gender, hair color, and eye color. It also displays related characters from the same universe.

Users can register and log in with a user account, which includes personalized username and profile image options. They can add a character to their favorites list (from the character image view page) and suggest adding a character to the site's database.

Various data integrity checks and format validations have been implemented on the user registration form (e.g., checking username availability on the site, password format with regular expressions).

Similarly, the login form has been equipped with various data integrity checks (e.g., verifying the existence of the username on the site, checking the correctness of the user's password).

User data is saved in the database (encrypted), and user access control is managed through PHP using session storage on the server.

The user's profile page allows them to view their current site status, including username, profile icon, number of characters added to favorites, the list of favorite characters, and the number of characters suggested to the site.

The site includes options to enable/disable page transition animations and a "dark mode" for the site, displayed in the menu bar and managed through local storage in the browser.

All pages of the site are responsive, utilizing CSS only to handle responsiveness (not using the Bootstrap library to provide more customized styles, animations, and controls). Media queries, flexbox, and grid have been used to rearrange page layouts.

CSS stylesheets have also been utilized for various site animations (in addition to simple animations like page transition and interactions with buttons, checkboxes, clickable cards, links, etc.). More complex animations include the homepage "loader" animation, star "pop" animation when adding a character to favorites, appearance/disappearance and management of password fields and other form fields, etc.

JavaScript has been used not only for data validation in various site forms but also for controlling site element behavior upon user interaction (working with CSS animations for page transitions, among others). JavaScript, along with the external library Three.js, has been used to control the loading, display, and other aspects of the 3D model on the homepage, as well as interaction animations (e.g., "follow" animation of the user's pointer, greeting animation toward the user upon clicking the 3D model).
