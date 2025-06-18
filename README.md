# Laravel CRUD With Auth

## Cara Menjalankan Project Ini

1. **Clone repository dari GitHub**
    ```bash
    git clone https://github.com/username/nama-repo.git
    cd nama-repo
    ```

2. **Install dependency PHP**
    ```bash
    composer require laravel/ui
    composer install
    php artisan ui vue --auth
    ```

3. **Install dependency frontend (jika menggunakan npm)**
    ```bash
    npm install
    # atau
    yarn install
    ```

4. **Copy file environment**
    ```bash
    cp .env.example .env
    ```
    > **Catatan:** Jika file `.env` sudah ada di repo, cukup edit saja.

5. **Atur konfigurasi database di file `.env`**
    ```
    DB_DATABASE=nama_database
    DB_USERNAME=username_mysql
    DB_PASSWORD=password_mysql
    ```

6. **Generate application key**
    ```bash
    php artisan key:generate
    ```

7. **Jalankan migrasi database**
    ```bash
    php artisan migrate
    ```

8. **(Opsional) Jalankan seeder jika ada**
    ```bash
    php artisan db:seed
    ```

9. **Jalankan server Laravel**
    ```bash
    php artisan serve
    ```
    Buka browser ke [http://127.0.0.1:8000](http://127.0.0.1:8000)

10. **(Opsional) Jika ingin fitur email (reset password/verifikasi) aktif, atur konfigurasi MAIL di `.env`**

---

**Catatan:**
- Pastikan sudah install PHP, Composer, Node.js, dan MySQL di laptop.
- Untuk fitur email, gunakan App Password Gmail atau Mailtrap untuk development.

---

Selamat
