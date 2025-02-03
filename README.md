# Laravel Gemini AI Integration

Hai, berikut code refrensi yang bisa kamu implementasi fetch APIkey dari GEMINi 

### Buat File .env
Salin file `.env.example` dan ubah namanya menjadi `.env`. Kemudian, update konfigurasi database dan API Key:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_gemini
DB_USERNAME=root
DB_PASSWORD=

GEMINI_API_KEY=your_gemini_api_key_here
```
## Konfigurasi

### 1. Dapatkan API Key
- Daftar atau login ke Google Cloud Console.
- Aktifkan Generative Language API.
- Buat API Key dan simpan di file `.env`:

```env
GEMINI_API_KEY=your_gemini_api_key_here
```

### 2. Update Service
Pastikan service `GeminiAIService` sudah dikonfigurasi dengan benar. File ini berada di `app/Services/GeminiAIService.php`.

## Penggunaan

### 1. Tampilkan Form
Buka browser dan akses:

```
http://127.0.0.1:8000/gemini
```

### 2. Masukkan Prompt
Masukkan prompt di form yang tersedia, contoh:

```
Apa itu Laravel?
```

### 3. Lihat Hasil
Klik tombol **Generate** untuk mengirim prompt ke Gemini AI. Hasil akan ditampilkan di bawah form.

## Struktur Proyek

```
app/
  Http/
    Controllers/
      GeminiAIController.php
  Services/
    GeminiAIService.php
resources/
  views/
    gemini/
      form.blade.php
routes/
  web.php
.env
README.md
```

## Contoh Kode

### Service (`app/Services/GeminiAIService.php`)

```php
<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GeminiAIService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function generateContent($prompt)
    {
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key={$this->apiKey}";

        $response = $this->client->post($url, [
            'json' => [
                'contents' => [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
```
