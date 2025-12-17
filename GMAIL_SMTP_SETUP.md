# Konfigurasi Gmail SMTP untuk Reset Password - Teh Jawa
# =========================================================
# 
# LANGKAH-LANGKAH SETUP:
# 
# 1. AKTIFKAN 2-STEP VERIFICATION DI GOOGLE ACCOUNT
#    - Buka: https://myaccount.google.com/security
#    - Scroll ke "Signing in to Google"
#    - Aktifkan "2-Step Verification"
#
# 2. BUAT APP PASSWORD
#    - Buka: https://myaccount.google.com/apppasswords
#    - Pilih "App" → "Mail"
#    - Pilih "Device" → "Windows Computer" atau "Other"
#    - Klik "Generate"
#    - CATAT PASSWORD 16 KARAKTER yang muncul (tanpa spasi)
#
# 3. UPDATE FILE .env DENGAN KONFIGURASI BERIKUT:
#
# =========================================================

# Ganti konfigurasi MAIL di file .env Anda dengan ini:

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailanda@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=emailanda@gmail.com
MAIL_FROM_NAME="Teh Jawa"

# =========================================================
# CATATAN PENTING:
# =========================================================
#
# - Ganti "emailanda@gmail.com" dengan email Gmail Anda
# - Ganti "xxxx xxxx xxxx xxxx" dengan App Password yang Anda generate
# - App Password adalah 16 karakter (tanpa spasi saat input)
# - JANGAN gunakan password Gmail biasa, HARUS App Password
#
# =========================================================
# TESTING EMAIL:
# =========================================================
#
# Setelah konfigurasi, test dengan command:
#   php artisan tinker
#   Mail::raw('Test email', function($msg) { $msg->to('test@email.com')->subject('Test'); });
#
# Atau buka halaman login → klik "Lupa Password" → masukkan email
#
# =========================================================
