## Infinite Playgrounds

## Project Setup steps
- get project git and clone the project
- Copy the ***.env.example*** file and rename it to ***.env***

- Update the .env to connect with database.
```
  DB_CONNECTION=mysql (recommended)
  DB_HOST=<DATABASE HOST>
  DB_PORT=<DATABASE PORT>
  DB_DATABASE=<DATABASE NAME>
  DB_USERNAME=<DATABASE USERNAME>
  DB_PASSWORD=<DATABASE PASSWORD>
```
- Run the command on terminal `composer install`. This installs all PHP dependencies.
- Migrate the databases. Run the command `php artisan migrate`.
- Seed data in the database. Run `php artisan db:seed`.
- To access storage files, run the command `php artisan storage:link`.
- To serve the project, run the command `php artisan serve`.
- Run `php artisan queue:listen` to run background jobs.
- Run `npm install` to install JavaScript dependencies.
- Run `npm run dev` to start the development server.
