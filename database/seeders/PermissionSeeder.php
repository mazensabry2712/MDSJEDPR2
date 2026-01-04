<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define all sections with their display names
        $sections = [
            'dashboard' => 'Dashboard',
            'epo' => 'Project EPO',
            'project-details' => 'Project Details',
            'customer' => 'Customer',
            'pm' => 'PM',
            'am' => 'AM',
            'vendors' => 'Vendors',
            'supplier' => 'Dist/Supplier',
            'invoice' => 'Invoice',
            'dn' => 'DN',
            'coc' => 'CoC',
            'pos' => 'Project POs',
            'status' => 'Project Status',
            'ptasks' => 'Project Tasks',
            'risks' => 'Risks',
            'milestones' => 'Milestones',
            'reports' => 'Reports',
            'users' => 'Users Management',
            'roles' => 'Roles Management',
            'permissions' => 'Permissions Management',
        ];

        // Define operations for each section
        $operations = ['show', 'add', 'edit', 'delete', 'view'];

        // Create permissions for each section
        foreach ($sections as $key => $name) {
            foreach ($operations as $operation) {
                $permissionName = $operation . ' ' . $key;

                // Check if permission already exists
                if (!Permission::where('name', $permissionName)->exists()) {
                    Permission::create([
                        'name' => $permissionName,
                        'guard_name' => 'web'
                    ]);

                    $this->command->info("Permission created: {$permissionName}");
                } else {
                    $this->command->warn("Permission already exists: {$permissionName}");
                }
            }
        }

        $this->command->info('All permissions have been created successfully!');
    }
}
