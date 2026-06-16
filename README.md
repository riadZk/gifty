# 🐳 Docker Setup — PCC Fidélité (Laravel 13 + PostgreSQL)

## 📁 Structure

```text
pcc-docker/
├── docker-compose.yml
├── .env.example
├── docker/
│   └── php/
│       ├── Dockerfile
│       └── php.ini
├── nginx/
│   └── conf.d/
│       └── default.conf
└── laravel/          ← Place your Laravel project here
```

---

## 🚀 Getting Started

### 1. Clone your Laravel project into the `laravel/` directory

```bash
git clone https://github.com/your-repo/pcc-backend.git laravel
```

### 2. Copy the `.env` file

```bash
cp .env.example laravel/.env
```

### 3. Build and start the containers

```bash
docker compose up -d --build
```

### 4. Install Laravel dependencies

```bash
docker exec pcc_app composer install
```

### 5. Generate the application key

```bash
docker exec pcc_app php artisan key:generate
```

### 6. Run migrations and seed the database

```bash
docker exec pcc_app php artisan migrate --seed
```

### 7. Open the application in your browser

```text
http://localhost:8000
```

---

## 🛠️ Useful Commands

| Command                                      | Description                        |
| -------------------------------------------- | ---------------------------------- |
| `docker compose up -d`                       | Start all containers               |
| `docker compose down`                        | Stop all containers                |
| `docker compose down -v`                     | Stop containers and remove volumes |
| `docker compose logs -f app`                 | View Laravel logs                  |
| `docker exec -it pcc_app bash`               | Access the PHP container           |
| `docker exec -it pcc_mysql bash`             | Access the MySQL container         |
| `docker exec pcc_app php artisan migrate`    | Run migrations                     |
| `docker exec pcc_app php artisan queue:work` | Start the queue worker             |
| `docker compose restart app`                 | Restart the Laravel application    |

---

## 🗄️ Connect to PostgreSQL from Outside Docker

* **Host:** `127.0.0.1`
* **Port:** `5432`
* **Database:** `pcc_fidelite`
* **User:** `pcc_user`
* **Password:** `pcc_password_2026`

You can use tools such as:

* **TablePlus**
* **DBeaver**
* **pgAdmin**
* **DataGrip**

---

## ⚠️ Important Note

Inside Laravel's `.env` file:

```env
DB_HOST=db         ✅ Correct (Docker service name)
DB_HOST=localhost  ❌ Incorrect
```

**Why?**
Inside Docker, Laravel must connect to the database using the Docker service name (`db`) rather than `localhost`. Using `localhost` points to the current container itself, not the PostgreSQL container.
