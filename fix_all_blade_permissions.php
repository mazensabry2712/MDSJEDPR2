<?php

/**
 * Fix All Blade Permission Checks Script
 * سكريبت تصليح جميع فحوصات الصلاحيات في ملفات Blade
 *
 * This script will:
 * 1. Find all blade files with generic permission checks (@can('Add'), @can('Edit'), etc.)
 * 2. Replace them with specific permission checks based on the controller/section
 */

// Mapping of view paths to their corresponding permission section names
$viewToPermissionMap = [
    'vendors/index' => 'vendors',
    'Risks/index' => 'risks',
    'Risks/show' => 'risks',
    'PTasks/index' => 'ptasks',
    'PTasks/show' => 'ptasks',
    'PStatus/index' => 'status',
    'PStatus/show' => 'status',
    'projects/index' => 'project-details',
    'PPOs/index' => 'pos',
    'PPOs/show' => 'pos',
    'PMs/index' => 'pm',
    'PEPO/index' => 'epo',
    'PEPO/show' => 'epo',
    'Milestones/index' => 'milestones',
    'Milestones/show' => 'milestones',
    'invoice/index' => 'invoice',
    'invoice/show' => 'invoice',
    'ds/index' => 'supplier',
    'DN/index' => 'dn',
    'CoC/index' => 'coc',
    'CoC/show' => 'coc',
    'AMs/index' => 'am',
    'customer/index' => 'customer',
];

$basePath = __DIR__ . '/resources/views/dashboard/';
$fixes = [];
$errors = [];

echo "\n========================================\n";
echo "  BLADE PERMISSION FIXES\n";
echo "  تصليح صلاحيات ملفات Blade\n";
echo "========================================\n\n";

foreach ($viewToPermissionMap as $viewPath => $permissionSection) {
    $filePath = $basePath . $viewPath . '.blade.php';

    if (!file_exists($filePath)) {
        echo "⚠️  File not found: {$viewPath}.blade.php\n";
        continue;
    }

    echo "Processing: {$viewPath}.blade.php\n";

    $content = file_get_contents($filePath);
    $originalContent = $content;
    $changed = false;

    // Replace generic permissions with specific ones
    $replacements = [
        "/@can\('Add'\)/" => "@can('add {$permissionSection}')",
        "/@can\('Edit'\)/" => "@can('edit {$permissionSection}')",
        "/@can\('Delete'\)/" => "@can('delete {$permissionSection}')",
        "/@can\('View'\)/" => "@can('view {$permissionSection}')",
        "/@can\('Show'\)/" => "@can('show {$permissionSection}')",
    ];

    foreach ($replacements as $pattern => $replacement) {
        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $replacement, $content);
            $changed = true;
            echo "  ✓ Replaced: {$pattern} → {$replacement}\n";
        }
    }

    // Also uncomment any commented permissions and fix them
    $commentedReplacements = [
        "/\{\{-- @can\('Add'\) --\}\}/" => "@can('add {$permissionSection}')",
        "/\{\{-- @can\('Edit'\) --\}\}/" => "@can('edit {$permissionSection}')",
        "/\{\{-- @can\('Delete'\) --\}\}/" => "@can('delete {$permissionSection}')",
        "/\{\{-- @can\('View'\) --\}\}/" => "@can('view {$permissionSection}')",
        "/\{\{-- @can\('Show'\) --\}\}/" => "@can('show {$permissionSection}')",
        "/\{\{-- @can\('edit'\) --\}\}/" => "@can('edit {$permissionSection}')",
        "/\{\{-- @can\('delete'\) --\}\}/" => "@can('delete {$permissionSection}')",
        "/\{\{-- @can\('view'\) --\}\}/" => "@can('view {$permissionSection}')",
        "/\{\{-- @can\('show'\) --\}\}/" => "@can('show {$permissionSection}')",
        "/\{\{-- @endcan --\}\}/" => "@endcan",
    ];

    foreach ($commentedReplacements as $pattern => $replacement) {
        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $replacement, $content);
            $changed = true;
            echo "  ✓ Uncommented and fixed: {$pattern} → {$replacement}\n";
        }
    }

    if ($changed) {
        // Backup original file
        $backupPath = $filePath . '.backup_' . date('Y-m-d_H-i-s');
        copy($filePath, $backupPath);

        // Write updated content
        file_put_contents($filePath, $content);

        $fixes[] = [
            'file' => $viewPath,
            'backup' => $backupPath,
        ];

        echo "  ✅ File updated successfully!\n";
        echo "  📁 Backup created: " . basename($backupPath) . "\n\n";
    } else {
        echo "  ℹ️  No changes needed.\n\n";
    }
}

echo "\n========================================\n";
echo "  SUMMARY\n";
echo "========================================\n";
echo "Files processed: " . count($viewToPermissionMap) . "\n";
echo "Files updated: " . count($fixes) . "\n";
echo "Errors: " . count($errors) . "\n";

if (!empty($fixes)) {
    echo "\nUpdated files:\n";
    foreach ($fixes as $fix) {
        echo "  ✓ " . $fix['file'] . ".blade.php\n";
    }
}

if (!empty($errors)) {
    echo "\nErrors:\n";
    foreach ($errors as $error) {
        echo "  ✗ " . $error . "\n";
    }
}

echo "\n========================================\n";
echo "  DONE!\n";
echo "========================================\n\n";

echo "⚠️  IMPORTANT: Please review the changes and test thoroughly.\n";
echo "📁 Backup files have been created for all modified files.\n\n";
