# Laravel Blog CMS

A Laravel 5.8–based blog and content management system that provides a public-facing blog with comments and an authenticated backend for managing posts, categories, tags, and users.

## Features

- **Public blog experience**
  - Paginated listings with search plus month/year archive filters, and routes for viewing posts by category, author, or tag.
  - Post detail pages increment view counts, render markdown content, and expose a validated comment form with paginated comment threads.
- **Content authoring & moderation**
  - Backend CRUD for posts, including create/edit forms, soft deletion to trash, restore, and permanent deletion flows.
  - Status filters for published, scheduled, draft, own posts, or trashed posts to simplify editorial views.
  - Category, tag, and user management via dedicated resource controllers and account profile update routes.
- **Rich post model**
  - Relationships to authors, categories, tags, and comments, plus helpers for tag lists, comment counts, and publication labels.
  - Markdown rendering for body/excerpt, archive scopes, search filters, and publication state scopes (published/scheduled/draft).
  - Image upload pipeline that stores originals and generates thumbnails based on configurable dimensions.
- **Roles and permissions** powered by Laratrust for gated backend access (see `app/Helpers/permissions.php`).

## Architecture

- **Framework:** Laravel 5.8 application using Blade views, Eloquent models, and form-builder based forms for both frontend comments and backend CRUD flows.
- **Domain models:** `Post` drives publication logic, tagging, image management, and scopes for filtering and archives; `Category`, `Tag`, `User`, and `Comment` support taxonomy and user-generated content.
- **Routing:** Public blog routes are open while authentication-protected backend routes are grouped under `/backend`, with registration disabled by default.

## Tech Stack & Dependencies

- PHP 7.1+ with Laravel 5.8.
- Key packages: graham-campbell/markdown for rendering, intervention/image for image processing, kris/laravel-form-builder for dynamic forms, and santigarcor/laratrust for roles/permissions.
- Dev tooling includes Laravel Debugbar, Whoops, Faker, Mockery, Collision, and PHPUnit for testing.

## Running the Project

1. Install PHP and Composer dependencies:
   ```bash
   composer install
   npm install
   ```
2. Copy `.env.example` to `.env`, set your database credentials, and generate the app key:
   ```bash
   php artisan key:generate
   ```
3. Run migrations and seed any initial data you require:
   ```bash
   php artisan migrate --seed
   ```
4. Serve the application:
   ```bash
   php artisan serve
   ```

## Extensibility Ideas

- Add media library management, scheduled publishing queues, or WYSIWYG/markdown hybrid editing for richer authoring.
- Introduce API endpoints for headless usage or mobile clients.
- Expand permissions and workflow states for editorial review.
- Enhance comment moderation with spam detection or approval queues.
