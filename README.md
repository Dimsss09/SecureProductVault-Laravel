# SecureProductVault

SecureProductVault adalah aplikasi demo **Laravel Product CRUD dengan autentikasi pengguna** untuk kebutuhan pembelajaran keamanan data dan informasi. Project ini menyediakan proses register, login, logout, verifikasi email, serta manajemen data produk yang hanya dapat diakses oleh pengguna yang sudah terautentikasi.

Aplikasi ini mensimulasikan sistem sederhana untuk mengelola data produk. Pengguna dapat membuat akun, masuk ke dashboard, lalu melakukan operasi **Create, Read, Update, dan Delete (CRUD)** pada data produk. Laravel menangani autentikasi, session, CSRF protection, validasi request, routing, migration database, dan rendering halaman melalui Blade template.

---

## Architecture

```mermaid
flowchart LR
    User[User / Browser] -->|HTTP Request| Laravel[Laravel 10 Application]

    subgraph Laravel_App[Laravel Application Layer]
        Routes[web.php Routes]
        Auth[Laravel UI Auth]
        Controllers[HomeController & ProductController]
        Validation[Request Validation]
        Blade[Blade Views]
        Session[Session, CSRF, Flash Message]
    end

    subgraph Data_Layer[Data Layer]
        Models[User & Product Models]
        DB[(MySQL / MariaDB Database)]
        Migrations[Database Migrations]
    end

    Laravel --> Routes
    Routes --> Auth
    Routes --> Controllers
    Controllers --> Validation
    Controllers --> Models
    Models --> DB
    Migrations --> DB
    Controllers --> Blade
    Blade --> User
    Laravel --> Session
```

Secara alur, browser mengirim request ke Laravel melalui route di `routes/web.php`. Route autentikasi dibuat oleh Laravel UI, sedangkan route produk diarahkan ke `ProductController` dan dibatasi middleware `auth`. Controller memvalidasi input, mengakses model `Product`, menyimpan atau mengambil data dari database, lalu mengembalikan halaman Blade kepada pengguna.

---

## Tech Stack

| Kategori                        | Teknologi                     |
| ------------------------------- | ----------------------------- |
| Backend Framework               | Laravel 10                    |
| Bahasa Backend                  | PHP `^8.1`                    |
| Autentikasi                     | Laravel UI `^4.6`             |
| Frontend View                   | Blade Template                |
| UI Styling                      | Bootstrap 5, Font Awesome     |
| Frontend Build Tool             | Vite 4                        |
| JavaScript Framework Dependency | Vue 3                         |
| HTTP Client Dependency          | Axios                         |
| Database                        | MySQL / MariaDB               |
| ORM                             | Eloquent ORM                  |
| Testing                         | PHPUnit / Laravel Test Runner |
| Package Manager                 | Composer, npm                 |

---

## Implemented Features

- **User Authentication**
    - Register akun pengguna.
    - Login dan logout.
    - Password reset route dari Laravel UI.
    - Email verification route aktif melalui `Auth::routes(['verify' => true])`.

- **Protected Product CRUD**
    - Halaman produk hanya dapat diakses oleh user yang sudah login.
    - Menampilkan seluruh produk.
    - Menambahkan produk baru.
    - Melihat detail produk.
    - Mengubah data produk.
    - Menghapus produk dengan modal konfirmasi.

- **Product Data Validation**
    - `name` wajib diisi dan maksimal 191 karakter.
    - `description` wajib diisi dan maksimal 191 karakter.
    - `price` wajib diisi dan harus numerik.

- **Security-Oriented Laravel Defaults**
    - Middleware `auth` untuk route produk.
    - CSRF token pada form Blade.
    - Password hashing melalui sistem autentikasi Laravel.
    - Session-based authentication.
    - Flash message untuk feedback sukses/gagal.

- **UI/UX**
    - Tampilan dark theme berbasis Bootstrap.
    - Navbar responsif.
    - Tombol aksi produk dengan ikon Font Awesome.
    - Alert untuk pesan sukses dan error.

---

## Cara Instal di New Device / Quick Start

### 1. Prasyarat

Pastikan perangkat sudah memiliki:

- PHP minimal 8.1
- Composer
- Node.js dan npm
- MySQL atau MariaDB
- Git

### 2. Clone Repository

```bash
git clone https://github.com/Dimsss09/Project_Matkul_Keamanan_Data_Dan_Informasi.git
cd Project_Matkul_Keamanan_Data_Dan_Informasi
```

Jika repository sudah diganti mengikuti rekomendasi nama:

```bash
git clone https://github.com/username/SecureProductVault-Laravel.git
cd SecureProductVault-Laravel
```

### 3. Install Dependency Backend

```bash
composer install
```

> Tidak perlu menjalankan `composer require laravel/ui` lagi karena dependency `laravel/ui` sudah ada di `composer.json`.

### 4. Install Dependency Frontend

```bash
npm install
```

### 5. Setup File Environment

Windows Command Prompt:

```cmd
copy .env.example .env
```

Git Bash / Linux / macOS:

```bash
cp .env.example .env
```

### 6. Generate Application Key

```bash
php artisan key:generate
```

### 7. Buat Database

Buat database baru di MySQL/MariaDB, contoh:

```sql
CREATE DATABASE secure_product_vault;
```

### 8. Konfigurasi Database di `.env`

Sesuaikan konfigurasi berikut:

```env
APP_NAME="SecureProductVault"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=secure_product_vault
DB_USERNAME=root
DB_PASSWORD=
```

### 9. Konfigurasi Email Verification / Reset Password

File `.env.example` sudah menyediakan konfigurasi email development yang aman:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@secureproductvault.test"
MAIL_FROM_NAME="${APP_NAME}"
```

Dengan konfigurasi `log`, link email verification dan reset password akan ditulis ke `storage/logs/laravel.log`. Ini cocok untuk demo lokal karena tidak membutuhkan credential SMTP.

Jika ingin mengirim email ke inbox sandbox atau email sungguhan, ganti konfigurasi mail di `.env` lokal menjadi SMTP. Contoh Mailtrap:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@secureproductvault.test"
MAIL_FROM_NAME="SecureProductVault"
```

Setelah mengubah konfigurasi email, jalankan:

```bash
php artisan optimize:clear
```

Flow pengiriman email juga sudah ditutup automated test di `tests/Feature/EmailSendingTest.php` untuk memastikan registrasi mengirim notifikasi verifikasi email dan forgot password mengirim notifikasi reset password.

### 10. Jalankan Migration

```bash
php artisan migrate
```

### 11. Build atau Jalankan Asset Frontend

Untuk development:

```bash
npm run dev
```

Untuk production build:

```bash
npm run build
```

> Saat ini layout juga menggunakan asset Bootstrap lokal di `public/css/bootstrap.min.css` dan `public/js/bootstrap.bundle.min.js`, sehingga halaman utama tetap dapat tampil walaupun Vite tidak dijalankan. Namun `npm install` tetap direkomendasikan agar environment project lengkap.

### 12. Jalankan Server Laravel

```bash
php artisan serve
```

Buka aplikasi di browser:

```text
http://127.0.0.1:8000
```

---

## Stop and Reset

### Stop Server

Untuk menghentikan server Laravel atau Vite, tekan:

```text
CTRL + C
```

pada terminal yang sedang menjalankan proses tersebut.

### Reset Database dari Awal

Perintah berikut akan menghapus seluruh tabel lalu menjalankan migration ulang:

```bash
php artisan migrate:fresh
```

Project sudah menyediakan seeder produk contoh, sehingga database dapat di-reset sekaligus diisi data demo dengan perintah:

```bash
php artisan migrate:fresh --seed
```

### Bersihkan Cache Laravel

```bash
php artisan optimize:clear
```

### Reset Dependency Frontend

Windows Command Prompt:

```cmd
rmdir /s /q node_modules
del package-lock.json
npm install
```

Git Bash / Linux / macOS:

```bash
rm -rf node_modules package-lock.json
npm install
```

---

## Runtime URLs

| URL                   | Method   | Akses  | Keterangan                         |
| --------------------- | -------- | ------ | ---------------------------------- |
| `/`                   | GET      | Public | Redirect ke `/home`                |
| `/login`              | GET/POST | Guest  | Login user                         |
| `/register`           | GET/POST | Guest  | Registrasi user                    |
| `/password/reset`     | GET      | Guest  | Halaman reset password             |
| `/email/verify`       | GET      | Auth   | Halaman instruksi verifikasi email |
| `/home`               | GET      | Auth   | Dashboard setelah login            |
| `/products`           | GET      | Auth   | List seluruh produk                |
| `/products/create`    | GET      | Auth   | Form tambah produk                 |
| `/products`           | POST     | Auth   | Simpan produk baru                 |
| `/products/{id}`      | GET      | Auth   | Detail produk                      |
| `/products/{id}/edit` | GET      | Auth   | Form edit produk                   |
| `/products/{id}`      | PUT      | Auth   | Update produk                      |
| `/products/{id}`      | DELETE   | Auth   | Hapus produk                       |

---

## Screenshot Evidence

Screenshot evidence aktual sudah tersedia di `docs/screenshots/`:

```text
docs/screenshots/
|-- 01-login-page.png
|-- 02-register-page.png
|-- 03-email-verification-notice.png
|-- 04-products-index.png
|-- 05-create-product.png
|-- 06-product-detail.png
|-- 07-update-product.png
`-- 08-delete-confirmation-modal.png
```

![Login Page](docs/screenshots/01-login-page.png)
![Register Page](docs/screenshots/02-register-page.png)
![Email Verification Notice](docs/screenshots/03-email-verification-notice.png)
![Products Index](docs/screenshots/04-products-index.png)
![Create Product](docs/screenshots/05-create-product.png)
![Product Detail](docs/screenshots/06-product-detail.png)
![Update Product](docs/screenshots/07-update-product.png)
![Delete Confirmation Modal](docs/screenshots/08-delete-confirmation-modal.png)

Screenshot diambil dari aplikasi Laravel yang dijalankan lokal dengan data demo produk dari seeder.

---

## Recommended Screenshots for Documentation

Screenshot dokumentasi final yang sudah tersedia:

1. **Login Page** — bukti halaman login berjalan.
2. **Register Page** — bukti registrasi user tersedia.
3. **Email Verification Notice** — bukti fitur verifikasi email aktif.
4. **Product Index** — bukti list produk tampil setelah login.
5. **Create Product Form** — bukti form tambah produk tersedia.
6. **Product Detail Page** — bukti fitur read/detail berjalan.
7. **Update Product Form** — bukti fitur update berjalan.
8. **Delete Confirmation Modal** — bukti hapus produk memakai konfirmasi.

---

## Documentation

Dokumentasi internal project:

- `README.md` — dokumentasi final project, instalasi, fitur, runtime URL, dan status.
- `Gist.md` — catatan/tutorial referensi lama untuk pembuatan CRUD Laravel.
- `routes/web.php` — daftar route utama aplikasi.
- `app/Http/Controllers/ProductController.php` — logic CRUD produk.
- `app/Models/Product.php` — model produk.
- `database/migrations/2023_08_11_154605_create_products_table.php` — struktur tabel produk.
- `database/seeders/ProductSeeder.php` — seed data produk contoh untuk demo.
- `database/factories/ProductFactory.php` — factory data produk untuk automated test.
- `tests/Feature/ProductControllerTest.php` — automated feature test untuk auth guard dan CRUD produk.
- `tests/Feature/EmailSendingTest.php` — automated feature test untuk notifikasi email verification dan reset password.
- `.env.example` — template environment aman, termasuk konfigurasi email development.
- `resources/views/product/` — halaman Blade untuk CRUD produk.
- `resources/views/layouts/app.blade.php` — layout utama aplikasi.

Dokumentasi eksternal yang relevan:

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Authentication](https://laravel.com/docs/authentication)
- [Laravel UI](https://github.com/laravel/ui)
- [Laravel Migrations](https://laravel.com/docs/migrations)
- [Bootstrap Documentation](https://getbootstrap.com/docs)

---

## Production Deployment

Panduan ringkas deployment ke server/cloud PHP standar:

1. Siapkan server dengan PHP 8.1+, Composer, web server Nginx/Apache, MySQL/MariaDB, Node.js, dan Git.
2. Clone repository ke server.
3. Install dependency production:

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

4. Buat file `.env` production dan sesuaikan konfigurasi berikut:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=secure_product_vault
DB_USERNAME=production_user
DB_PASSWORD=strong_password
```

5. Generate key jika belum ada:

```bash
php artisan key:generate
```

6. Jalankan migration dan, bila diperlukan, seed data demo:

```bash
php artisan migrate --force
php artisan db:seed --force
```

7. Optimasi konfigurasi Laravel:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

8. Arahkan document root web server ke folder `public/`.
9. Pastikan permission folder `storage/` dan `bootstrap/cache/` dapat ditulis oleh user web server.

Checklist keamanan production:

- [ ] `APP_DEBUG=false`.
- [ ] `APP_KEY` sudah dibuat dan tidak dibagikan publik.
- [ ] Credential database dan SMTP tidak di-commit ke Git.
- [ ] HTTPS aktif.
- [ ] Backup database disiapkan.
- [ ] Permission folder Laravel sudah benar.

---

## Current Status

| Area                  | Status                 | Catatan                                                                               |
| --------------------- | ---------------------- | ------------------------------------------------------------------------------------- |
| Laravel App           | ✅ Implemented         | Project menggunakan Laravel 10.                                                       |
| Authentication        | ✅ Implemented         | Login, register, logout, password reset route, dan email verification route tersedia. |
| Product CRUD          | ✅ Implemented         | Create, read/detail, update, delete produk tersedia dan dilindungi middleware `auth`. |
| Database Migration    | ✅ Implemented         | Tabel `users`, password reset, jobs, token, dan `products` tersedia.                  |
| Input Validation      | ✅ Implemented         | Validasi produk tersedia di `store` dan `update`.                                     |
| UI Styling            | ✅ Implemented         | Menggunakan Bootstrap dark theme dan Font Awesome.                                    |
| Email Sending         | ✅ Implemented & Tested | `.env.example` memakai mailer `log` untuk demo; SMTP bisa diaktifkan di `.env`.       |
| Seeder Data           | ✅ Implemented         | `ProductSeeder` tersedia dan dipanggil dari `DatabaseSeeder`.                         |
| Automated Test        | ✅ Implemented         | Feature test CRUD, proteksi auth, email verification, dan reset password tersedia.    |
| Screenshot Evidence   | ✅ Completed           | Screenshot aktual tersedia di `docs/screenshots/`.                                    |
| Production Deployment | ✅ Documented          | Panduan deployment production sudah ditambahkan pada section `Production Deployment`. |

Kesimpulan status: project sudah dapat digunakan sebagai **demo Laravel CRUD produk dengan autentikasi**. Seeder produk contoh, automated feature test, konfigurasi email development, screenshot evidence aktual, dan dokumentasi deployment sudah tersedia.

---

## Testing Checklist Manual

Gunakan checklist berikut untuk memastikan aplikasi berjalan setelah instalasi:

- [ ] User dapat membuka halaman register.
- [ ] User dapat membuat akun baru.
- [ ] User dapat login.
- [ ] User yang belum login tidak dapat membuka `/products`.
- [ ] User dapat menambahkan produk.
- [ ] User dapat melihat daftar produk.
- [ ] User dapat melihat detail produk.
- [ ] User dapat mengubah produk.
- [ ] User dapat menghapus produk melalui modal konfirmasi.
- [ ] Pesan sukses/error muncul setelah operasi CRUD.
- [ ] Email verification/reset password berjalan setelah SMTP dikonfigurasi.

---

## License

Project ini mengikuti lisensi bawaan Laravel skeleton, yaitu MIT License.
