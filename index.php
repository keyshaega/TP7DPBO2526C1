<?php
session_start();

require_once __DIR__ . '/class/Category.php';
require_once __DIR__ . '/class/Product.php';
require_once __DIR__ . '/class/Customer.php';
require_once __DIR__ . '/class/Order.php';

$entities = [
    'categories' => [
        'title' => 'Categories', 'singular' => 'Category', 'class' => Category::class,
        'fields' => [
            'name' => ['label'=>'Nama kategori','type'=>'text','required'=>true],
            'description' => ['label'=>'Deskripsi','type'=>'textarea']
        ],
        'columns' => ['id'=>'ID','name'=>'Nama kategori','description'=>'Deskripsi']
    ],
    'products' => [
        'title' => 'Products', 'singular' => 'Product', 'class' => Product::class,
        'fields' => [
            'category_id' => ['label'=>'Kategori','type'=>'select','source'=>'categories','required'=>true],
            'name' => ['label'=>'Nama produk','type'=>'text','required'=>true],
            'description' => ['label'=>'Deskripsi','type'=>'textarea'],
            'price' => ['label'=>'Harga (Rp)','type'=>'number','required'=>true,'min'=>0],
            'stock' => ['label'=>'Stok','type'=>'number','required'=>true,'min'=>0]
        ],
        'columns' => ['id'=>'ID','category_id'=>'ID Kategori','name'=>'Nama produk','price'=>'Harga','stock'=>'Stok']
    ],
    'customers' => [
        'title' => 'Customers', 'singular' => 'Customer', 'class' => Customer::class,
        'fields' => [
            'name' => ['label'=>'Nama pelanggan','type'=>'text','required'=>true],
            'phone' => ['label'=>'Nomor telepon','type'=>'text'],
            'email' => ['label'=>'Email','type'=>'email'],
            'address' => ['label'=>'Alamat','type'=>'textarea']
        ],
        'columns' => ['id'=>'ID','name'=>'Nama','phone'=>'Telepon','email'=>'Email','address'=>'Alamat']
    ],
    'orders' => [
        'title' => 'Orders', 'singular' => 'Order', 'class' => Order::class,
        'fields' => [
            'customer_id' => ['label'=>'Pelanggan','type'=>'select','source'=>'customers','required'=>true],
            'product_id' => ['label'=>'Produk','type'=>'select','source'=>'products','required'=>true],
            'quantity' => ['label'=>'Jumlah','type'=>'number','required'=>true,'min'=>1],
            'order_date' => ['label'=>'Tanggal pesanan','type'=>'date','required'=>true],
            'status' => ['label'=>'Status','type'=>'select_static','options'=>['Pending','Diproses','Selesai','Dibatalkan'],'required'=>true]
        ],
        'columns' => ['id'=>'ID','customer_id'=>'ID Pelanggan','product_id'=>'ID Produk','quantity'=>'Jumlah','order_date'=>'Tanggal','status'=>'Status']
    ]
];

$tab = $_GET['page'] ?? 'dashboard';
if (!isset($entities[$tab]) && $tab !== 'dashboard') $tab = 'dashboard';

function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function modelFor(string $key, array $entities): BaseModel {
    $class = $entities[$key]['class'];
    return new $class();
}

function allFor(string $key, array $entities): array {
    return modelFor($key, $entities)->getAll();
}

// Validasi server-side untuk melindungi data selain validasi pada form HTML.
function validateEntityData(string $entity, array $data, array $entities): array {
    $errors = [];
    foreach ($entities[$entity]['fields'] as $field => $meta) {
        $value = trim((string)($data[$field] ?? ''));
        if (!empty($meta['required']) && $value === '') {
            $errors[] = $meta['label'] . ' wajib diisi.';
            continue;
        }
        if ($value === '') continue;

        if ($meta['type'] === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid.';
        }
        if ($meta['type'] === 'number') {
            if (!is_numeric($value)) {
                $errors[] = $meta['label'] . ' harus berupa angka.';
            } elseif (in_array($field, ['stock', 'quantity'], true) && filter_var($value, FILTER_VALIDATE_INT) === false) {
                $errors[] = $meta['label'] . ' harus berupa bilangan bulat.';
            } elseif (isset($meta['min']) && (float)$value < (float)$meta['min']) {
                $errors[] = $meta['label'] . ' minimal ' . $meta['min'] . '.';
            }
        }
        if ($meta['type'] === 'select') {
            $validIds = array_map(static fn($row) => (string)$row['id'], allFor($meta['source'], $entities));
            if (!in_array($value, $validIds, true)) $errors[] = 'Pilihan ' . strtolower($meta['label']) . ' tidak valid.';
        }
        if ($meta['type'] === 'select_static' && !in_array($value, $meta['options'], true)) {
            $errors[] = 'Pilihan ' . strtolower($meta['label']) . ' tidak valid.';
        }
        if ($meta['type'] === 'date') {
            $date = DateTime::createFromFormat('Y-m-d', $value);
            if (!$date || $date->format('Y-m-d') !== $value) $errors[] = 'Format tanggal tidak valid.';
        }
    }
    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entity = $_POST['entity'] ?? '';
    $action = $_POST['action'] ?? '';
    if (isset($entities[$entity])) {
        try {
            $model = modelFor($entity, $entities);
            if ($action === 'save') {
                $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
                $id = ($id === false || $id === null) ? 0 : $id;
                $data = [];
                foreach ($entities[$entity]['fields'] as $field => $meta) {
                    $data[$field] = trim((string)($_POST[$field] ?? ''));
                }
                $errors = validateEntityData($entity, $data, $entities);
                if ($errors) {
                    $_SESSION['flash'] = implode(' ', $errors);
                } else {
                    $saved = $id > 0 ? $model->update($id, $data) : $model->create($data);
                    $_SESSION['flash'] = $saved
                        ? ($id > 0 ? 'Data berhasil diperbarui.' : 'Data berhasil ditambahkan.')
                        : 'Data tidak berhasil disimpan.';
                }
            } elseif ($action === 'delete') {
                $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
                if (!$id || $id < 1) {
                    $_SESSION['flash'] = 'ID data tidak valid.';
                } else {
                    $deleted = $model->delete($id);
                    $_SESSION['flash'] = $deleted ? 'Data berhasil dihapus.' : 'Data tidak ditemukan atau gagal dihapus.';
                }
            }
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            $_SESSION['flash'] = 'Aksi gagal. Pastikan data yang terhubung tidak sedang digunakan oleh data lain dan periksa koneksi database.';
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $_SESSION['flash'] = 'Terjadi kesalahan saat memproses data.';
        }
    }
    header('Location: index.php?page=' . urlencode(isset($entities[$entity]) ? $entity : 'dashboard'));
    exit;
}

$editing = null;
if (isset($entities[$tab]) && isset($_GET['edit'])) {
    $editId = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT);
    if ($editId && $editId > 0) $editing = modelFor($tab, $entities)->find($editId);
}
$rows = isset($entities[$tab]) ? allFor($tab, $entities) : [];
$counts = [];
foreach (array_keys($entities) as $key) $counts[$key] = count(allFor($key, $entities));
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

require __DIR__ . '/view/layout.php';
