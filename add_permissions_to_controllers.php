<?php

/**
 * This script adds permission middleware to all controllers
 * Run: php add_permissions_to_controllers.php
 */

$controllers = [
    'Pepo' => 'epo',
    'Project' => 'project-details',
    'Cust' => 'customer',
    'ppms' => 'pm',
    'aams' => 'am',
    'vendors' => 'vendors',
    'Ds' => 'supplier',
    'invoices' => 'invoice',
    'Dn' => 'dn',
    'Coc' => 'coc',
    'Ppos' => 'pos',
    'Pstatus' => 'status',
];

foreach ($controllers as $controller => $permission) {
    $controllerFile = __DIR__ . "/app/Http/Controllers/{$controller}Controller.php";

    if (!file_exists($controllerFile)) {
        echo "⚠️  Controller not found: {$controller}Controller.php\n";
        continue;
    }

    $content = file_get_contents($controllerFile);

    // Check if middleware already exists
    if (strpos($content, '__construct()') !== false) {
        echo "ℹ️  Constructor already exists in {$controller}Controller, skipping...\n";
        continue;
    }

    // Find the class declaration
    if (preg_match('/(class\s+' . $controller . 'Controller\s+extends\s+Controller\s*\{)/s', $content, $matches)) {
        $classDeclaration = $matches[1];

        $middlewareCode = "\n    /**\n     * Constructor to set up middleware for permissions\n     */\n    public function __construct()\n    {\n        \$this->middleware('permission:show {$permission}', ['only' => ['index']]);\n        \$this->middleware('permission:add {$permission}', ['only' => ['create', 'store']]);\n        \$this->middleware('permission:edit {$permission}', ['only' => ['edit', 'update']]);\n        \$this->middleware('permission:delete {$permission}', ['only' => ['destroy']]);\n        \$this->middleware('permission:view {$permission}', ['only' => ['show']]);\n    }\n\n";

        $newContent = str_replace($classDeclaration, $classDeclaration . $middlewareCode, $content);

        file_put_contents($controllerFile, $newContent);
        echo "✅ Added permissions to {$controller}Controller\n";
    } else {
        echo "❌ Could not find class declaration in {$controller}Controller\n";
    }
}

echo "\n✅ Done! All controllers have been protected with permissions.\n";
