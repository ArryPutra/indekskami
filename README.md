![Mockup](/public/Mockup.jpg)

# Kontak Programmer
- WhatsApp: 0813-5044-5065

# Spesifikasi
- Laravel 12
- PHP Version 8.2

# Perintah Awal Menjalankan Development
1. git clone https://github.com/ArryPutra/indekskami.git
2. copy file .env.example menjadi .env
3. composer install
4. npm install
5. php artisan key:generate
6. php artisan migrate --seed

# Perintah Production
- composer install --optimize-autoloader --no-dev

# Catatan Kepada: Programmer
- Mengubah username responden mengakibatkan perubahan path file evaluasi pada username responden berubah sangat tidak disarankan, untuk mencegah ini Anda dapat mengubah path username menjadi user ID atau responden ID (untuk mengganti terdapat di folder Evaluasi/PertanyaanController baris 236 ganti $responden->user->username menjadi $responden->user->id, efek sampingnya folder tidak menggunakan username hanya menggunakan ID).
- Setiap melakukan jawab evaluasi maka files juga harus di create, jika jawaban file dihapus maka terhapus
juga files data tersebut