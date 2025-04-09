# Laravel Forum Discussion Platform

[![Laravel](https://img.shields.io/badge/Laravel-v12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-v3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![Vue.js](https://img.shields.io/badge/Vue.js-v3.x-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)](https://vuejs.org)

A modern, feature-rich forum and discussion platform built with Laravel, Tailwind CSS, Alpine.js, and Vue.js. This application provides a robust environment for community discussions with an intuitive user interface and responsive design.

## Features

- **User Authentication & Profiles**
  - Secure login and registration
  - Customizable user profiles
  - Avatar support
  - Activity history

- **Forum & Discussion**
  - Create, edit, and delete posts
  - Rich post content with image support
  - Commenting system with threading
  - Voting system for posts and comments

- **UI/UX**
  - Responsive design works on all devices
  - Dark mode support
  - Toast notifications
  - AJAX-powered interactions
  
- **Performance & Security**
  - Optimized database queries
  - CSRF protection
  - Input validation
  - Rate limiting

## Screenshots

[Coming soon]

## Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL or PostgreSQL
- Laravel requirements

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/forum-project.git
   cd forum-project
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install NPM dependencies:
   ```bash
   npm install
   ```

4. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

5. Generate an application key:
   ```bash
   php artisan key:generate
   ```

6. Configure your database in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

7. Run database migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

8. Create a symbolic link for storage:
   ```bash
   php artisan storage:link
   ```

9. Compile assets:
   ```bash
   npm run dev
   ```

10. Start the development server:
    ```bash
    php artisan serve
    ```

## Configuration

### Environment Variables

Important environment variables you may want to modify:

- `APP_NAME` - The name of your forum
- `APP_ENV` - Set to `production` for deployment
- `APP_DEBUG` - Set to `false` in production
- `APP_URL` - Your application's URL
- `MAIL_*` - Mail configuration for notifications
- `FILESYSTEM_DISK` - For storing uploaded files

### Custom Configuration

You can customize the forum appearance by modifying the Tailwind configuration in `tailwind.config.js`.

## Development

### Compiling Assets

During development:
```bash
npm run dev
```

For production:
```bash
npm run build
```

### Adding Components

The project uses a component-based architecture:

- Laravel Blade components in `resources/views/components/`
- Vue components in `resources/js/components/`

### Testing

Run the tests with:
```bash
php artisan test
```

## Deployment

For production deployment:

1. Set appropriate environment variables
2. Optimize Laravel:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
3. Compile assets for production:
   ```bash
   npm run build
   ```

## License

[MIT License](LICENSE.md)

## Credits

This project uses the following open-source packages:

- [Laravel](https://laravel.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Alpine.js](https://alpinejs.dev/)
- [Vue.js](https://vuejs.org/)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request
