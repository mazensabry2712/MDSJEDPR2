<!DOCTYPE html>
<html>
<head>
    <title>Test Customer Table</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f5f5f5; }
        .logo { height: 50px; width: 50px; object-fit: contain; border-radius: 8px; border: 2px solid #dee2e6; }
        .status { padding: 5px; margin: 5px 0; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Customer Logo Test</h1>

    <?php
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

    use App\Models\Cust;

    $customers = Cust::all();
    ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Logo Path</th>
            <th>Logo Image</th>
            <th>Status</th>
        </tr>
        <?php foreach ($customers as $cust): ?>
        <tr>
            <td><?= $cust->id ?></td>
            <td><?= $cust->name ?></td>
            <td><?= $cust->logo ?? 'N/A' ?></td>
            <td>
                <?php if ($cust->logo): ?>
                    <img src="/<?= $cust->logo ?>" class="logo" alt="Logo"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div style="display:none; color: red;">❌ Failed to load</div>
                <?php else: ?>
                    <span style="color: #999;">No logo</span>
                <?php endif; ?>
            </td>
            <td>
                <?php
                if ($cust->logo) {
                    $fullPath = public_path($cust->logo);
                    $hasSpaces = strpos($cust->logo, ' ') !== false;
                    $fileExists = file_exists($fullPath);

                    if ($hasSpaces) {
                        echo '<div class="status error">❌ Has spaces in filename</div>';
                    }
                    if (!$fileExists) {
                        echo '<div class="status error">❌ File not found</div>';
                    }
                    if (!$hasSpaces && $fileExists) {
                        echo '<div class="status success">✅ All good</div>';
                    }
                } else {
                    echo '<div class="status">No logo set</div>';
                }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Direct Image Tests</h2>
    <?php foreach ($customers as $cust): ?>
        <?php if ($cust->logo): ?>
            <div style="margin: 20px 0; padding: 10px; border: 1px solid #ddd;">
                <h3><?= $cust->name ?></h3>
                <p><strong>Path:</strong> /<?= $cust->logo ?></p>
                <p><strong>Image:</strong></p>
                <img src="/<?= $cust->logo ?>?v=<?= time() ?>" class="logo"
                     onerror="this.style.border='2px solid red'; this.nextElementSibling.innerHTML='❌ Failed to load';">
                <div style="margin-top: 10px;"></div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <p style="margin-top: 30px; color: #666;">
        Generated at: <?= date('Y-m-d H:i:s') ?> |
        Cache Buster: <?= time() ?>
    </p>
</body>
</html>
