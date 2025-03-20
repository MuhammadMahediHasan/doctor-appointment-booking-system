
## Doctor appointment booking system.

Setup instructions

- Clone the repository
```bash
  git clone 
```
- Copy .env.example to .env
```bash
  cp .env.example .env 
```
- Go to project root and run composer install
```bash
  cd ./project-directory && composer intall
```
- Configure database connection

- Run database migration and seeder
```bash
    php artisan migrate && php artisan db:seed
```

### API endpoints
- /api/v1/doctor/availability
- /api/v1/doctor/{id}/availability
- /api/v1/appointment/book
- /api/v1/appointments/{patientId}
- /api/v1/doctor-appointments/{doctorId}
