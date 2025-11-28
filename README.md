# Recipe

## 🚀 Quick Start

Follow these steps to get the project up and running on your local machine:

### 1. Environment Configuration

```bash
# Copy the environment configuration template
cp .env.example .env
```

Edit the `.env` file and update the administrator settings if needed:
```env
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=secure_password_123
```

### 2. Build Configuration

```bash
# Set up the build configuration for development
cp test.vite.config.js vite.config.js
```

### 3. Docker Configuration

```bash
# Activate the Docker Compose configuration
cp test.docker-compose.yml docker-compose.yml
```

### 4. Application Deployment

```bash
# Start all services in detached mode
docker-compose up -d
```

### 5. Service Initialization

Wait for all tasks in the **translator** service to complete. You can monitor the progress using:

The application is ready when you see completion messages in the logs (Starting PHP-FPM...).

### 6. Database Seeding (Optional)

To populate the cuisines reference data, run:

```bash
# Execute database seeder
docker-compose exec translator php artisan db:seed
```

## 🌐 Access the Application

Once all services are running, access the application at:  
**http://localhost**


## 📁 Project settings structure

```
├── app/                 # Application source code
├── docker-compose.yml   # Container orchestration
├── vite.config.js      # Frontend build configuration
├── .env                # Environment variables
└── ...                 # Other project files
