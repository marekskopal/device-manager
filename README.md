# Device Manager

## Install & Run

1) Clone this repository

2) Create `.env` file from `.env.example`

    `
       cp .env.example .env
    `

3) Build and run containers

    `
       docker compose up -d --build
    `

4) run migrations

   `
       docker compose exec backend bin/console migration:run
   `

4) Open application on http://localhost:4100

5) Login as `admin@example.com` with password `admin123`