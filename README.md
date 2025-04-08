# Video Platform

A video streaming platform built with Laravel that allows users to share and watch videos.

## Setup Instructions

1. Clone the repository
```bash
git clone https://github.com/tweacktech/Video-platform-backend.git
cd video-platform
```

2. Install dependencies
```bash
composer install
```

3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Setup database
```bash
php artisan migrate
php artisan db:seed
```

5. Start the development server
```bash
php artisan serve
php artisan queue:work (for the job to run after uploading)
```

## Features Implemented

- User authentication and authorization
- Video upload and streaming
- Video categorization and search

## Technologies Used

- **Backend**: Laravel 10.x, PHP 8.2
- **Database**: MySQL
- **Storage**: Local storage
- **Video Processing**: FFmpeg
- **Authentication**: Laravel Sanctum

## Architecture Decisions

- **MVC Pattern**: Following Laravel's architecture for clean code separation
- **Repository Pattern**: For abstracting data layer operations
- **Queue System**: Using Laravel jobs for video processing
- **API Design**: RESTful API with versioning for frontend communication
- **Storage**: local storage for scalable video testing
- **Caching**: Redis for improved performance



## Features will have love to enhance 

- **User interface**: will be improved for better user experience using laravel and vue starter kid
- **Video player**: was just a rush work 
- **Update upload**:user should be able to update the video
- **API Design**: RESTful API with versioning for frontend communication
- **Storage**: will have preferred AWS S3 for scalable video storage

