<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;
use App\Models\vendors;
use Illuminate\Support\Facades\DB;

echo "=== Testing Vendor Filter for Multiple Vendors ===\n\n";

// Get all vendors
$allVendors = vendors::all();
echo "Total Vendors in System: " . $allVendors->count() . "\n";
foreach ($allVendors as $v) {
    echo "  - ID: {$v->id} | Name: {$v->vendors}\n";
}

echo "\n--- Testing Each Vendor ---\n\n";

foreach ($allVendors as $vendor) {
    echo "Vendor: {$vendor->vendors} (ID: {$vendor->id})\n";

    // OLD METHOD (using vendors_id column - single vendor)
    $oldProjects = Project::where('vendors_id', $vendor->id)->count();
    echo "  OLD Method (vendors_id): {$oldProjects} projects\n";

    // NEW METHOD (using whereHas - many-to-many)
    $newProjects = Project::whereHas('vendors', function($q) use ($vendor) {
        $q->where('vendor_id', $vendor->id);
    })->get();

    echo "  NEW Method (whereHas): {$newProjects->count()} projects\n";

    if ($newProjects->count() > 0) {
        foreach ($newProjects as $project) {
            // Get all vendors for this project
            $projectVendors = DB::table('project_vendors')
                ->where('project_id', $project->id)
                ->get();

            echo "    → Project: {$project->pr_number} | {$project->name}\n";
            echo "      Total Vendors for this project: {$projectVendors->count()}\n";

            foreach ($projectVendors as $pv) {
                $vInfo = vendors::find($pv->vendor_id);
                $primaryTag = $pv->is_primary ? " [PRIMARY]" : "";
                echo "      - Vendor ID: {$pv->vendor_id} | Name: " . ($vInfo ? $vInfo->vendors : 'Unknown') . $primaryTag . "\n";
            }
        }
    }

    echo "\n";
}

echo "\n--- Summary ---\n";
echo "If a project has multiple vendors, the NEW method should return it when filtering by ANY of those vendors.\n";
echo "The OLD method only checks the vendors_id column (single vendor - legacy).\n";
