Sure, here's a revised version of the README.md file:

---

# Tech Jobs Website

Tech Jobs Website is a job portal focusing on technology-related positions. It allows users to search for jobs in various technology fields such as development, UI/UX design, app development, web development, software development, database administration, network engineering, embedded systems, and Internet of Things (IoT). Employers can also search for talented professionals to join their teams.

## How to Run

1. **Download the Project:**
   - Clone or download the project from [this GitHub repository](https://github.com/Ziad-Abaza/project-web.git).

2. **Set Up the Database:**
   - Execute the SQL script `database/job_seekers_db.sql` to set up the `job_seekers_db` database.

3. **Server Setup:**
   - Place the project in your server's directory.

4. **Start the Server:**
   - Start your web server (e.g., Apache, Nginx).

5. **Access the Website:**
   - Open a web browser and navigate to the URL where the project is hosted to view the website.

## Code Explanation

### Traits

#### ValidatorTrait

- Provides functions for validating input data.
- Functions include `validateRequestData`, `makeValidator`, and `validateField`.

#### HandleFileTrait

- Enables file uploading to the server and file deletion.
- Functions include `UploadFiles`, `getFolderByFileType`, `uploadFile`, and `deleteFile`.

#### CrudOperationsTrait

- Provides functions for basic database operations (CRUD).
- Functions include `createRecord`, `getRecord`, `getByCategory`, `getWithRelations`, `findWithRelationsByID`, `updateRecord`, and `deleteRecord`.

### Classes

#### UserLogin and UserRegistration

- Functions for user authentication (login and registration) and permission checks.

## Files

- `index.php`: Displays the website's homepage with the navbar, header, job list, top companies list, and footer.
- Other PHP files: Handle specific functionalities such as job details, company details, job search, user login, and registration.

## Dependencies

- This project uses PHP for server-side scripting.
- It also utilizes MySQL for the database.
- Some frontend libraries such as Bootstrap and Font Awesome are used for styling.

## Contributing

- Contributions are welcome! Feel free to fork the repository and submit pull requests with improvements or bug fixes.

---

This README.md provides an overview of the Tech Jobs Website project, how to run it, explanations of key code components, and information on contributing and licensing.
