# Sistem Laporan Keuangan Teh Jawa

## Deskripsi Sistem

Sistem Laporan Keuangan Teh Jawa adalah sebuah aplikasi berbasis web yang dikembangkan untuk memfasilitasi pengelolaan dan pelaporan data keuangan secara efisien, akurat, dan terstruktur. Aplikasi ini dirancang untuk memenuhi kebutuhan pencatatan transaksi, pemantauan arus kas, serta penyusunan laporan keuangan yang komprehensif guna mendukung pengambilan keputusan strategis perusahaan.

Dibangun di atas kerangka kerja Laravel yang modern dan robust, aplikasi ini menawarkan performa tinggi, keamanan data yang terjamin, serta antarmuka pengguna yang intuitif dan responsif.

## Arsitektur Sistem

Aplikasi ini menerapkan pola arsitektur perangkat lunak **Model-View-Controller (MVC)** yang memisahkan logika aplikasi menjadi tiga komponen utama yang saling berinteraksi:

*   **Model**: Bertanggung jawab untuk pengelolaan data dan aturan bisnis. Komponen ini berinteraksi langsung dengan basis data menggunakan Eloquent ORM, memastikan integritas dan relasi data terjaga dengan baik.
*   **View**: Menangani representasi visual dan interaksi pengguna. Antarmuka dibangun menggunakan Blade Templating Engine yang dipadukan dengan Tailwind CSS untuk menghasilkan desain yang estetis dan responsif di berbagai perangkat.
*   **Controller**: Bertindak sebagai penghubung antara Model dan View. Komponen ini menerima input dari pengguna, memproses logika bisnis melalui Model, dan mengembalikan respons yang sesuai ke View.

Struktur ini memastikan kode program yang rapi, mudah dipelihara, dan skalabilitas (scalability) yang baik untuk pengembangan di masa mendatang.

## Teknologi yang Digunakan

Pengembangan sistem ini memanfaatkan serangkaian teknologi terkini untuk menjamin kualitas dan performa aplikasi:

*   **Backend Framework**: Laravel 12 (PHP Framework)
*   **Bahasa Pemrograman**: PHP 8.2
*   **Basis Data**: MySQL
*   **Frontend**: Blade Templates, Tailwind CSS
*   **Generasi Dokumen**: Laravel Dompdf (untuk pembuatan laporan PDF)
*   **Build Tool**: Vite

## Fitur Utama

Sistem ini dilengkapi dengan berbagai fitur esensial untuk manajemen keuangan:

*   **Otentikasi Pengguna**: Sistem login yang aman untuk membatasi akses hanya kepada pengguna yang berwenang.
*   **Manajemen Laporan Keuangan**: Fitur pencatatan dan pengelolaan data keuangan yang terpusat.
*   **Ekspor PDF**: Kemampuan untuk mencetak laporan keuangan dalam format PDF menggunakan integrasi `dompdf`, memudahkan proses pengarsipan dan pelaporan fisik.
*   **Manajemen Data (CRUD)**: Fungsionalitas lengkap untuk Membuat, Membaca, Memperbarui, dan Menghapus data transaksi.

## Panduan Instalasi dan Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi ini di lingkungan lokal Anda:

1.  **Persiapan Lingkungan**: Pastikan PHP 8.2 dan Composer telah terinstal di komputer Anda.
2.  **Instalasi Dependensi Backend**: Jalankan perintah berikut untuk mengunduh pustaka PHP yang dibutuhkan:
    ```bash
    composer install
    ```
3.  **Instalasi Dependensi Frontend**: Jalankan perintah berikut untuk menginstal dependensi JavaScript dan membangun aset statis:
    ```bash
    npm install
    npm run build
    ```
4.  **Konfigurasi Lingkungan**: Salin file konfigurasi `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Sesuaikan pengaturan basis data (DB_DATABASE, DB_USERNAME, DB_PASSWORD) di dalam file `.env`.
5.  **Generate Application Key**:
    ```bash
    php artisan key:generate
    ```
6.  **Migrasi Basis Data**: Jalankan migrasi untuk membuat tabel-tabel yang diperlukan di basis data:
    ```bash
    php artisan migrate
    ```
7.  **Menjalankan Server**: Aktifkan server pengembangan lokal:
    ```bash
    php artisan serve
    ```

Aplikasi kini dapat diakses melalui peramban web di alamat lokal yang tertera (biasanya `http://127.0.0.1:8000`).

## Lisensi

Aplikasi ini merupakan perangkat lunak sumber terbuka (open-source) yang didistribusikan di bawah lisensi **MIT License**.
