<!DOCTYPE html>
<html>
<head>
    <title>Customer Logo Test</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; }
    </style>
</head>
<body>
    <h1>Customer Logo Direct Test</h1>

    <?php
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

    use App\Models\Cust;

    $customers = Cust::all();
    ?>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Logo Path</th>
                <th>Logo Display</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($customers as $index => $cust): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $cust->name; ?></td>
                <td><?php echo $cust->logo ?? 'NULL'; ?></td>
                <td style="text-align: center;">
                    <?php if($cust->logo): ?>
                        <img src="/<?php echo $cust->logo; ?>"
                             alt="<?php echo $cust->name; ?> Logo"
                             onerror="this.onerror=null; this.outerHTML='<i class=\'fas fa-building\' style=\'color: #999; font-size: 30px;\'></i>';"
                             style="height: 50px; width: 50px; object-fit: contain; border-radius: 8px; border: 2px solid #dee2e6; padding: 5px; background: white;"
                             onload="this.style.border='3px solid green';">
                    <?php else: ?>
                        <i class="fas fa-building" style="color: #999; font-size: 30px;"></i>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Direct Image Links:</h3>
    <ul>
        <?php foreach($customers as $cust): ?>
            <?php if($cust->logo): ?>
            <li>
                <a href="/<?php echo $cust->logo; ?>" target="_blank">
                    <?php echo $cust->name; ?> Logo
                </a>
            </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</body>
</html>
