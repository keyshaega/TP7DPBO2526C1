# TP7DPBO2526C1

## Janji
Saya Keysha Ega Magani dengan NIM 2507925 mengerjakan tugas praktikum 7 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahan-Nya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

## Sweetcrumb Bakery

**Sweetcrumb Bakery** merupakan aplikasi website toko roti sederhana yang dikembangkan menggunakan **PHP Native** dengan menerapkan konsep **Object-Oriented Programming (OOP)** dan database MySQL.

Aplikasi ini dibuat untuk mengelola data pelanggan, kategori, produk, dan pesanan pada toko bakery. Pengembangan aplikasi menerapkan struktur kode modular agar setiap bagian memiliki tanggung jawab masing-masing dan lebih mudah dikelola.

---

##  1. Tujuan Pembuatan

Project ini dibuat untuk menerapkan materi praktikum **Modul 8 – OOP dalam Website PHP dengan GUI**, meliputi:

- Penerapan konsep Object-Oriented Programming (OOP) menggunakan PHP.
- Penggunaan class dan object untuk mengelola data.
- Penerapan struktur folder yang modular.
- Penghubungan PHP dengan database MySQL.
- Penerapan relasi antartabel menggunakan Foreign Key.
- Pembuatan antarmuka pengguna (GUI) menggunakan HTML dan CSS.
- Implementasi operasi CRUD (*Create, Read, Update, Delete*).

---

##  2. Teknologi yang Digunakan

| Teknologi | Penggunaan |
|---|---|
| PHP Native | Mengelola logika backend aplikasi |
| MySQL | Menyimpan dan mengelola data |
| HTML | Membuat struktur halaman website |
| CSS | Mengatur tampilan dan desain website |
| XAMPP | Menjalankan server lokal dan MySQL |
| OOP | Mengorganisasi kode menggunakan class dan object |

---

## 3. Struktur Folder Project

```text
sweetcrumb_bakery/
│
├── class/
│   ├── BaseModel.php
│   ├── Customer.php
│   ├── Product.php
│   ├── Category.php
│   └── Order.php
│
├── config/
│   └── Database.php
│
├── database/
│   └── sweetcrumb_bakery.sql
│
├── style/
│   └── style.css
│
├── view/
│   └── layout.php
│
├── index.php
├── README.md
└── .gitignore
```

##  4. Penerapan Materi Modul 8

Berikut merupakan penerapan materi yang dipelajari pada Modul 8 dalam project Sweetcrumb Bakery.

### A. Object-Oriented Programming (OOP)

Konsep OOP diterapkan pada folder `class/`, yaitu dengan membuat class yang bertanggung jawab terhadap masing-masing entitas database.

Contohnya:
- `Customer` untuk mengelola data pelanggan.
- `Product` untuk mengelola data produk.
- `Category` untuk mengelola data kategori.
- `Order` untuk mengelola data pesanan.

Setiap class memiliki tanggung jawab sesuai dengan entitas yang dikelolanya. Dengan pendekatan ini, logika program tidak seluruhnya ditulis dalam satu file sehingga kode menjadi lebih terorganisir dan mudah dikembangkan.

### B. Struktur Kode Modular

Materi mengenai struktur folder modular diterapkan dengan memisahkan kode berdasarkan fungsinya.

Contohnya:
- Logika pengelolaan data berada di folder `class/`.
- Konfigurasi koneksi database berada di `config/Database.php`.
- Tampilan website berada di folder `view/`.
- Styling website berada di folder `style/`.
- File utama aplikasi berada di `index.php`.

Pemisahan ini membuat setiap bagian aplikasi memiliki tugas masing-masing dan mengurangi penulisan kode yang berulang.

### C. Database Connection

Koneksi database diterapkan melalui file `config/Database.php`.

File ini bertanggung jawab untuk menghubungkan aplikasi PHP dengan database MySQL bernama `sweetcrumb_bakery`.

Koneksi tersebut kemudian digunakan oleh class yang membutuhkan akses ke database untuk menjalankan proses pengelolaan data.

### D. Database Relationship

Database menggunakan beberapa tabel yang saling berhubungan, yaitu:

| Tabel | Fungsi |
|---|---|
| `customers` | Menyimpan informasi pelanggan. |
| `categories` | Menyimpan kategori produk bakery. |
| `products` | Menyimpan informasi produk bakery. |
| `orders` | Menyimpan informasi pesanan. |

Salah satu penerapan relasi terdapat pada tabel `products` dan `categories`.

Tabel `products` memiliki kolom `category_id` sebagai Foreign Key yang mengacu pada ID kategori di tabel `categories`.

Dengan relasi tersebut, setiap produk dapat dihubungkan dengan kategori yang sesuai.

### E. Prepared Statement

Prepared Statement digunakan dalam proses pengaksesan database untuk membantu mencegah SQL Injection.

Penerapannya dilakukan ketika aplikasi menjalankan query yang melibatkan input dari pengguna, seperti menambahkan, mengubah, mencari, dan menghapus data.

### F. CRUD (Create, Read, Update, Delete)

Setiap entitas memiliki fitur CRUD untuk mengelola data yang tersimpan dalam database.

| Operasi | Penerapan |
|---|---|
| **Create** | Menambahkan data baru ke database. |
| **Read** | Menampilkan data yang tersimpan di database. |
| **Update** | Mengubah data yang sudah tersimpan. |
| **Delete** | Menghapus data dari database. |

Operasi CRUD diterapkan pada data Customer, Category, Product, dan Order melalui class masing-masing di folder `class/`.

### G. Graphical User Interface (GUI)

Penerapan GUI terdapat pada bagian `view/` dan `style/`.

GUI digunakan sebagai penghubung antara pengguna dengan sistem melalui elemen visual seperti:
- Halaman utama.
- Menu navigasi.
- Tabel untuk menampilkan data.
- Form untuk menambahkan dan mengubah data.
- Tombol untuk menjalankan operasi CRUD.

HTML digunakan untuk menyusun elemen halaman, sedangkan CSS digunakan untuk mengatur tampilannya.

---
## 5. Dokumentasi Aplikasi

- Dashboard aplikasi

  <img width="926" height="412" alt="Screenshot 2026-11-10 192834" src="https://github.com/user-attachments/assets/392cbf3d-ddb2-4b42-b6db-3591d15d81e5" />
  
- Contoh data awal kategori


  <img width="944" height="404" alt="Screenshot 2026-11-10 192931" src="https://github.com/user-attachments/assets/7f5f44df-edf1-4a1d-a7f2-654dced09de4" />

- Create new data


  <img width="936" height="404" alt="Screenshot 2026-11-10 193035" src="https://github.com/user-attachments/assets/d20604cc-080d-45f7-8026-d490439eb5c1" />


- Update data
  

  <img width="946" height="420" alt="Screenshot 2026-11-10 193134" src="https://github.com/user-attachments/assets/5f1420b9-5e50-4c77-9b45-61e77b3a8250" />


- Delete data

  
  <img width="938" height="401" alt="Screenshot 2026-11-10 193100" src="https://github.com/user-attachments/assets/445a4434-4633-4a18-ac17-c32356ab5de8" />



---



