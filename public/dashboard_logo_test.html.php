<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Logo Test</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .info-box { background: white; padding: 20px; border-radius: 8px; border-top: 3px solid #667eea; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin: 20px 0; }
        .d-flex { display: flex; }
        .align-items-center { align-items: center; }
        .ml-3 { margin-left: 20px; }
    </style>
</head>
<body>
    <h1>Dashboard Logo Simulation Test</h1>

    <?php
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

    use App\Models\Project;

    $project = Project::with('cust')->where('pr_number', 'PR003')->first();
    ?>

    <div class="info-box">
        <h2>Exact Blade Code Simulation:</h2>
        <pre style="background: #f0f0f0; padding: 15px; border-radius: 5px;">
@if($project->cust && $project->cust->logo)
    &lt;img src="/{{ $project->cust->logo }}" ... &gt;
@else
    &lt;i class="fas fa-building"&gt;&lt;/i&gt;
@endif
        </pre>

        <h3>Result:</h3>
        <div class="d-flex align-items-center">
            <?php if($project->cust && $project->cust->logo): ?>
                <img src="/<?php echo $project->cust->logo; ?>"
                     alt="<?php echo $project->cust->name; ?>"
                     onerror="console.error('Logo failed to load:', this.src); this.onerror=null; this.outerHTML='<i class=\'fas fa-building\' style=\'color: #667eea; font-size: 24px;\'></i>';"
                     onload="console.log('Logo loaded successfully:', this.src); this.style.border='3px solid green';"
                     style="width: 50px; height: 50px; object-fit: contain; border-radius: 8px; border: 2px solid #667eea; padding: 5px; background: white;">
            <?php else: ?>
                <i class="fas fa-building" style="color: #667eea; font-size: 24px;"></i>
            <?php endif; ?>
            <div class="ml-3">
                <small style="color: #6c757d; font-weight: 600; font-size: 10px; text-transform: uppercase; display: block;">Customer</small>
                <h5 style="color: #2c3e50; font-weight: 600; font-size: 15px;">
                    <?php echo $project->cust->name ?? 'N/A'; ?>
                </h5>
            </div>
        </div>
    </div>

    <div class="info-box">
        <h3>Debug Information:</h3>
        <table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%;">
            <tr>
                <td><strong>$project exists:</strong></td>
                <td><?php echo $project ? 'YES ✅' : 'NO ❌'; ?></td>
            </tr>
            <tr>
                <td><strong>$project->cust exists:</strong></td>
                <td><?php echo $project->cust ? 'YES ✅' : 'NO ❌'; ?></td>
            </tr>
            <tr>
                <td><strong>$project->cust->logo:</strong></td>
                <td><?php echo $project->cust->logo ?? 'NULL'; ?></td>
            </tr>
            <tr>
                <td><strong>Condition Result:</strong></td>
                <td><?php echo ($project->cust && $project->cust->logo) ? 'SHOULD SHOW IMAGE ✅' : 'SHOULD SHOW ICON ❌'; ?></td>
            </tr>
            <tr>
                <td><strong>Image URL:</strong></td>
                <td>/<?php echo $project->cust->logo ?? ''; ?></td>
            </tr>
            <tr>
                <td><strong>File Exists:</strong></td>
                <td><?php echo file_exists(public_path($project->cust->logo ?? '')) ? 'YES ✅' : 'NO ❌'; ?></td>
            </tr>
        </table>
    </div>

    <div class="info-box">
        <h3>Direct Image Test:</h3>
        <p>Click to open logo directly:</p>
        <a href="/storge/neom_logo.png" target="_blank" style="font-size: 18px; color: #007bff;">
            <i class="fas fa-external-link-alt"></i> Open Logo Direct Link
        </a>
    </div>

    <script>
        console.log('=== Dashboard Logo Test ===');
        console.log('Logo URL:', '/<?php echo $project->cust->logo ?? ''; ?>');
        console.log('Check Network tab for failed requests');
    </script>
</body>
</html>
