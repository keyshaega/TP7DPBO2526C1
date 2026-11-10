<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweetcrumb Bakery | Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a class="brand" href="index.php"><span class="brand-mark">s.</span><span>sweetcrumb<small>BAKERY STUDIO</small></span></a>
        <p class="side-label">WORKSPACE</p>
        <nav>
            <a class="<?= $tab==='dashboard'?'active':'' ?>" href="index.php"><span>⌂</span> Dashboard</a>
            <?php foreach ($entities as $key=>$entity): ?>
                <a class="<?= $tab===$key?'active':'' ?>" href="index.php?page=<?= e($key) ?>"><span><?= ['categories'=>'◇','products'=>'♡','customers'=>'♧','orders'=>'▤'][$key] ?></span> <?= e($entity['title']) ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="sidebar-note"><span>✦</span><p>Freshly baked,<br><b>made with love.</b></p></div>
        <div class="side-footer">SWEETCRUMB © 2026</div>
    </aside>

    <main class="main">
        <header class="topbar"><div><span class="eyebrow">BAKERY MANAGEMENT</span><h1><?= $tab==='dashboard'?'Good day, baker!':e($entities[$tab]['title']) ?></h1></div><div class="avatar">SC</div></header>
        <?php if ($flash): ?><div class="alert"><?= e($flash) ?></div><?php endif; ?>

        <?php if ($tab === 'dashboard'): ?>
            <section class="welcome">
                <div><span class="eyebrow light">YOUR LITTLE BAKERY SPACE</span><h2>Every sweet detail,<br>in one place.</h2><p>Kelola produk, pelanggan, dan pesanan Sweetcrumb dengan lebih mudah.</p><a class="button button-light" href="index.php?page=products">Lihat produk <span>→</span></a></div>
                <div class="welcome-art"><div class="sun"></div><div class="cake">🍰</div><span class="sparkle s1">✦</span><span class="sparkle s2">✧</span><span class="art-caption">BAKED WITH LOVE</span></div>
            </section>
            <div class="section-heading"><div><span class="eyebrow">AT A GLANCE</span><h2>Bakery overview</h2></div><span class="muted">Ringkasan data saat ini</span></div>
            <section class="stats">
                <?php foreach ([['categories','Categories','Kategori','◇'],['products','Products','Produk','♡'],['customers','Customers','Pelanggan','♧'],['orders','Orders','Pesanan','▤']] as $stat): ?>
                    <a class="stat-card" href="index.php?page=<?= $stat[0] ?>"><div class="stat-top"><span><?= $stat[1] ?></span><b><?= $stat[3] ?></b></div><strong><?= $counts[$stat[0]] ?></strong><small><?= $stat[2] ?> terdaftar</small></a>
                <?php endforeach; ?>
            </section>
            <section class="tip"><span>✿</span><div><b>Little reminder</b><p>Pastikan stok produk selalu diperbarui agar pesanan pelanggan bisa dikelola dengan baik.</p></div></section>
        <?php else: ?>
            <div class="content-grid">
                <section class="panel form-panel">
                    <div class="panel-heading"><div><span class="eyebrow"><?= $editing?'UPDATE DATA':'ADD NEW DATA' ?></span><h2><?= $editing?'Edit '.$entities[$tab]['singular']:'Tambah '.$entities[$tab]['singular'] ?></h2></div><span class="panel-icon">✦</span></div>
                    <form method="POST" action="index.php?page=<?= e($tab) ?>">
                        <input type="hidden" name="entity" value="<?= e($tab) ?>">
                        <input type="hidden" name="action" value="save">
                        <input type="hidden" name="id" value="<?= e($editing['id'] ?? 0) ?>">
                        <?php foreach ($entities[$tab]['fields'] as $field=>$meta): $value = $editing[$field] ?? ($field==='order_date'?date('Y-m-d'):''); ?>
                            <label><?= e($meta['label']) ?><?= !empty($meta['required'])?' *':'' ?>
                            <?php if ($meta['type']==='textarea'): ?>
                                <textarea name="<?= e($field) ?>" <?= !empty($meta['required'])?'required':'' ?>><?= e($value) ?></textarea>
                            <?php elseif ($meta['type']==='select'): ?>
                                <select name="<?= e($field) ?>" required><option value="">Pilih <?= e($meta['label']) ?></option>
                                    <?php foreach (allFor($meta['source'],$entities) as $option): ?><option value="<?= e($option['id']) ?>" <?= (string)$value===(string)$option['id']?'selected':'' ?>><?= e($option['name']) ?></option><?php endforeach; ?>
                                </select>
                            <?php elseif ($meta['type']==='select_static'): ?>
                                <select name="<?= e($field) ?>" required><?php foreach ($meta['options'] as $option): ?><option value="<?= e($option) ?>" <?= $value===$option?'selected':'' ?>><?= e($option) ?></option><?php endforeach; ?></select>
                            <?php else: ?>
                                <input type="<?= e($meta['type']) ?>" name="<?= e($field) ?>" value="<?= e($value) ?>" <?= !empty($meta['required'])?'required':'' ?> <?= isset($meta['min'])?'min="'.e($meta['min']).'"':'' ?>>
                            <?php endif; ?>
                            </label>
                        <?php endforeach; ?>
                        <div class="form-actions"><button class="button" type="submit"><?= $editing?'Simpan perubahan':'Simpan data' ?> <span>→</span></button>
                        <?php if ($editing): ?><a class="cancel" href="index.php?page=<?= e($tab) ?>">Batal</a><?php endif; ?></div>
                    </form>
                </section>
                <section class="panel table-panel">
                    <div class="panel-heading"><div><span class="eyebrow">YOUR COLLECTION</span><h2>Daftar <?= e($entities[$tab]['title']) ?></h2></div><span class="count"><?= count($rows) ?> entries</span></div>
                    <div class="table-wrap"><table><thead><tr><?php foreach ($entities[$tab]['columns'] as $label): ?><th><?= e($label) ?></th><?php endforeach; ?><th>Aksi</th></tr></thead><tbody>
                    <?php if (!$rows): ?><tr><td colspan="<?= count($entities[$tab]['columns'])+1 ?>" class="empty">Belum ada data. Tambahkan data pertamamu!</td></tr><?php endif; ?>
                    <?php foreach ($rows as $row): ?><tr>
                        <?php foreach ($entities[$tab]['columns'] as $field=>$label): ?>
                            <td><?php if ($field==='price'): ?>Rp <?= number_format((float)$row[$field],0,',','.') ?><?php else: ?><?= e($row[$field] ?? '-') ?><?php endif; ?></td>
                        <?php endforeach; ?>
                        <td><div class="actions"><a class="edit" href="index.php?page=<?= e($tab) ?>&edit=<?= e($row['id']) ?>">Edit</a><form method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')"><input type="hidden" name="entity" value="<?= e($tab) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($row['id']) ?>"><button class="delete" type="submit">Hapus</button></form></div></td>
                    </tr><?php endforeach; ?>
                    </tbody></table></div>
                    <?php if (in_array($tab,['products','orders'])): ?><p class="table-note">Catatan: ID kategori, pelanggan, dan produk mengacu pada data di menu terkait.</p><?php endif; ?>
                </section>
            </div>
        <?php endif; ?>
        <footer class="footer">Made with <span>♥</span> at Sweetcrumb Bakery <span class="footer-right">A little sweetness in every day.</span></footer>
    </main>
</div>
</body>
</html>
