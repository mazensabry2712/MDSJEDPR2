<?php $__env->startSection('css'); ?>
    <!--  Owl-carousel css-->
    <link href="<?php echo e(URL::asset('assets/plugins/owl-carousel/owl.carousel.css'), false); ?>" rel="stylesheet" />
    <!-- Maps css -->
    <link href="<?php echo e(URL::asset('assets/plugins/jqvmap/jqvmap.min.css'), false); ?>" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Lightbox CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />


    <style>
        .sales-card {
            border-radius: 15px !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12) !important;
            margin-bottom: 20px;
        }

        .sales-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2) !important;
        }

        .stats-icon {
            font-size: 1.8rem;
            opacity: 0.25;
            position: absolute;
            right: 15px;
            top: 15px;
        }

        .card-content {
            position: relative;
            z-index: 2;
        }

        .stats-number {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
        }

        .stats-label {
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ========== FILTER SIDEBAR STYLES - MATCHING REPORTS ========== */
        .dashboard-filter-container {
            display: flex;
            gap: 25px;
            position: relative;
            margin-top: 0;
            width: 100%;
            padding: 0;
        }

        .filter-sidebar {
            width: 350px;
            flex-shrink: 0;
            height: fit-content;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 30px rgba(0, 123, 255, 0.15);
            border: 2px solid rgba(0, 123, 255, 0.15);
            position: relative;
        }

        .filter-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #007bff 0%, #0056b3 100%);
            border-radius: 15px 15px 0 0;
        }

        .filter-sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .filter-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .filter-sidebar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .filter-sidebar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #0056b3 0%, #007bff 100%);
        }

        .sidebar-header {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 3px solid #007bff;
            position: relative;
        }

        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 60px;
            height: 3px;
            background: #0056b3;
        }

        .sidebar-header h5 {
            color: #007bff;
            font-weight: 800;
            font-size: 20px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar-header h5 i {
            color: #007bff;
            font-size: 22px;
            animation: filterPulse 2s ease-in-out infinite;
        }

        @keyframes filterPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .active-filters-badge {
            display: inline-block;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 10px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .active-filters-summary {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
            border-left: 3px solid #007bff;
        }

        .active-filters-summary .badge {
            font-size: 10px;
            padding: 5px 10px;
            font-weight: 500;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
        }

        .filter-card {
            background: white;
            border: none;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .filter-card:hover {
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.15);
        }

        .filter-card .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            border-radius: 8px 8px 0 0;
            padding: 12px 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-card .card-header:hover {
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        }

        .filter-card .card-header h6 {
            margin: 0;
            font-size: 13px;
            font-weight: 700;
            color: #495057;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-card .card-header h6 span {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-card .card-header h6 i.fas {
            color: #007bff;
            font-size: 14px;
        }

        .toggle-icon {
            transition: transform 0.3s ease;
            color: #007bff;
            font-size: 12px;
        }

        .collapsed .toggle-icon {
            transform: rotate(180deg);
        }

        .filter-card .card-body {
            padding: 15px;
        }

        .filter-card label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-card label i {
            color: #007bff;
            font-size: 11px;
        }

        .filter-card .form-control {
            background: #f8f9fa;
            border: 2px solid transparent;
            border-radius: 6px;
            font-size: 13px;
            padding: 10px 12px;
            transition: all 0.3s ease;
        }

        .filter-card .form-control:hover {
            background: #ffffff;
            border-color: #e9ecef;
        }

        .filter-card .form-control:focus {
            background: white;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .select2-container--default .select2-selection--single {
            background: #f8f9fa;
            border: 2px solid transparent;
            border-radius: 6px;
            height: 42px;
            padding: 6px 12px;
        }

        .select2-container--default .select2-selection--single:hover {
            background: #ffffff;
            border-color: #e9ecef;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            background: white;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .filter-actions {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 15px;
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 15px;
            z-index: 10;
        }

        .btn-filter {
            width: 100%;
            margin-bottom: 10px;
            padding: 12px 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        }

        .btn-apply-filter {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: white;
        }

        .btn-reset-filter {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            border: none;
            color: white;
        }

        .dashboard-content-area {
            flex: 1;
            min-width: 0;
        }

        .dashboard-content-area .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 25px rgba(0, 123, 255, 0.12);
            overflow: hidden;
        }

        .dashboard-content-area .card-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            padding: 20px 25px;
        }

        .dashboard-content-area .card-body {
            padding: 40px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .dashboard-filter-container {
                flex-direction: column;
            }

            .filter-sidebar {
                width: 100%;
                margin-bottom: 20px;
            }

            .sales-card {
                margin-bottom: 15px;
            }
        }

        /* Button hover effect */
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-header'); ?>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, welcome back!</h2>
            </div>
        </div>
        
    </div>
    <!-- /breadcrumb -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- row -->
    
    <!-- row 2 -->
    
    <!-- row closed -->

    
    <div class="row row-sm mt-4">
        <div class="col-12">
            <div class="dashboard-filter-container">
                
                <div class="filter-sidebar">
                    
                    <div class="sidebar-header">
                        <h5>
                            <i class="fas fa-filter"></i>
                            Advanced Filters
                        </h5>
                    </div>

                    <form action="<?php echo e(route('dashboard.index'), false); ?>" method="GET" id="filterForm">
                        
                        <div class="card filter-card">
                            <div class="card-header" data-toggle="collapse" data-target="#projectInfo">
                                <h6>
                                    <span><i class="fas fa-project-diagram"></i> Project Information</span>
                                    <i class="fas fa-chevron-up toggle-icon"></i>
                                </h6>
                            </div>
                            <div id="projectInfo" class="collapse show">
                                <div class="card-body">

                                    <!-- PR Number Filter -->

                                    <div class="form-group">
                                        <label><i class="fas fa-hashtag"></i> PR Number</label>
                                        <select name="filter[pr_number]" class="form-control select2"
                                            data-placeholder="-- Select PR Number --">
                                            <option></option>
                                            <option value="all"
                                                <?php echo e(request('filter.pr_number') == 'all' ? 'selected' : '', false); ?>>All Projects
                                                (<?php echo e($projectcount, false); ?>)</option>
                                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($project->pr_number, false); ?>"
                                                    <?php echo e(request('filter.pr_number') == $project->pr_number ? 'selected' : '', false); ?>>
                                                    <?php echo e($project->pr_number, false); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- PR Number without Invoices Filter -->

                                    <div class="form-group">
                                        <label><i class="fas fa-hashtag"></i> PR Number without Invoices</label>
                                        <select name="filter[pr_number_no_invoice]" class="form-control select2"
                                            data-placeholder="-- Select PR Number (No Invoices) --">
                                            <option></option>
                                            <option value="all"
                                                <?php echo e(request('filter.pr_number_no_invoice') == 'all' ? 'selected' : '', false); ?>>All Projects
                                                (<?php echo e($projectcount, false); ?>)</option>
                                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($project->pr_number, false); ?>"
                                                    <?php echo e(request('filter.pr_number_no_invoice') == $project->pr_number ? 'selected' : '', false); ?>>
                                                    <?php echo e($project->pr_number, false); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- Project Name Filter -->
                                    



                                </div>
                            </div>
                        </div>


                        
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-filter btn-apply-filter">
                                <i class="fas fa-search"></i> Apply Filters
                            </button>
                            <button type="button" class="btn btn-filter btn-reset-filter" onclick="resetFilters()">
                                <i class="fas fa-undo"></i> Reset All
                            </button>
                        </div>
                    </form>
                </div>

                
                <div class="dashboard-content-area">
                    <?php if($hasFilters && $filteredProjects->count() > 0): ?>
                        
                        <?php $__currentLoopData = $filteredProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row row-sm mb-4">
                                
                                <div class="col-12 mb-4">
                                    <div class="card" style="border-radius: 15px; border: 3px solid #007bff; box-shadow: 0 6px 30px rgba(0, 123, 255, 0.2);">
                                        <div class="card-header" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); padding: 25px; display: flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                <h3 class="text-white mb-0" style="line-height: 1.4;">
                                                    <i class="fas fa-project-diagram"></i> <?php echo e($project->name, false); ?>

                                                </h3>
                                                <span class="badge badge-light mt-2" style="font-size: 14px; font-weight: 600;">PR# <?php echo e($project->pr_number, false); ?></span>
                                            </div>
                                            
                                            <div>
                                                <form action="<?php echo e(route('dashboard.print.filtered'), false); ?>" method="GET" target="_blank" style="display: inline; margin: 0;">
                                                    <?php $__currentLoopData = request('filter', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($value): ?>
                                                            <input type="hidden" name="filter[<?php echo e($key, false); ?>]" value="<?php echo e($value, false); ?>">
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <button type="submit" class="btn"
                                                            style="background: white;
                                                                   color: #007bff;
                                                                   font-weight: 600;
                                                                   padding: 10px 20px;
                                                                   border-radius: 8px;
                                                                   box-shadow: 0 2px 8px rgba(255, 255, 255, 0.3);
                                                                   border: none;
                                                                   transition: all 0.3s ease;
                                                                   cursor: pointer;
                                                                   font-size: 14px;">
                                                        <i class="fas fa-print"></i> Print
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding: 30px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                                            
                                            <div class="row mb-4">
                                                <div class="col-lg col-md-4 col-sm-6 mb-3">
                                                    <div class="info-box" style="background: white; padding: 20px; border-radius: 8px; border-top: 3px solid #667eea; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: 100%; transition: all 0.3s;">
                                                        <small style="color: #6c757d; font-weight: 600; font-size: 10px; text-transform: uppercase; display: block; margin-bottom: 10px;">CUSTOMER</small>
                                                        <div class="d-flex align-items-center">
                                                            <?php if($project->cust && $project->cust->logo): ?>
                                                                <a href="/<?php echo e($project->cust->logo, false); ?>" data-lightbox="customer-logo-<?php echo e($project->id, false); ?>" data-title="<?php echo e($project->cust->name, false); ?> Logo" title="Click to view full size" style="text-decoration: none;">
                                                                    <div style="width: 50px; height: 50px; background: white; border-radius: 8px; border: 2px solid #667eea; padding: 5px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-right: 12px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.borderColor='#4a56d6'; this.style.transform='scale(1.05)'" onmouseout="this.style.borderColor='#667eea'; this.style.transform='scale(1)'">
                                                                        <img src="/<?php echo e($project->cust->logo, false); ?>"
                                                                             alt="<?php echo e($project->cust->name, false); ?> Logo"
                                                                             onerror="this.parentElement.parentElement.style.display='none';"
                                                                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                                    </div>
                                                                </a>
                                                            <?php endif; ?>
                                                            <div style="flex: 1; min-width: 0;">
                                                                <h5 class="mb-0" style="color: #2c3e50; font-weight: 600; font-size: 15px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo e($project->cust->name ?? 'N/A', false); ?>">
                                                                    <?php echo e($project->cust->name ?? 'N/A', false); ?>

                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg col-md-4 col-sm-6 mb-3">
                                                    <div class="info-box" style="background: white; padding: 20px; border-radius: 8px; border-top: 3px solid #28a745; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: 100%; transition: all 0.3s;">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fas fa-user-tie" style="color: #28a745; font-size: 20px;"></i>
                                                            <small class="ml-2" style="color: #6c757d; font-weight: 600; font-size: 10px; text-transform: uppercase;">PM</small>
                                                        </div>
                                                        <h5 class="mb-0" style="color: #2c3e50; font-weight: 600; font-size: 15px;"><?php echo e($project->ppms->name ?? 'N/A', false); ?></h5>
                                                    </div>
                                                </div>
                                                <?php if(!request('filter.pr_number_no_invoice')): ?>
                                                <div class="col-lg col-md-4 col-sm-6 mb-3">
                                                    <div class="info-box" style="background: white; padding: 20px; border-radius: 8px; border-top: 3px solid #ffc107; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: 100%; transition: all 0.3s;">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fas fa-dollar-sign" style="color: #ffc107; font-size: 20px;"></i>
                                                            <small class="ml-2" style="color: #6c757d; font-weight: 600; font-size: 10px; text-transform: uppercase;">Value</small>
                                                        </div>
                                                        <h5 class="mb-0" style="color: #2c3e50; font-weight: 600; font-size: 15px;"><?php echo e(number_format($project->value ?? 0, 0), false); ?> SAR</h5>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                                <div class="col-lg col-md-4 col-sm-6 mb-3">
                                                    <div class="info-box" style="background: white; padding: 20px; border-radius: 8px; border-top: 3px solid #17a2b8; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: 100%; transition: all 0.3s;">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fas fa-calendar-alt" style="color: #17a2b8; font-size: 20px;"></i>
                                                            <small class="ml-2" style="color: #6c757d; font-weight: 600; font-size: 10px; text-transform: uppercase;">PO Date</small>
                                                        </div>
                                                        <h5 class="mb-0" style="color: #2c3e50; font-weight: 600; font-size: 15px;"><?php echo e($project->customer_po_date ?? 'N/A', false); ?></h5>
                                                    </div>
                                                </div>
                                                <div class="col-lg col-md-4 col-sm-6 mb-3">
                                                    <div class="info-box" style="background: white; padding: 20px; border-radius: 8px; border-top: 3px solid #6f42c1; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: 100%; transition: all 0.3s;">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fas fa-code" style="color: #6f42c1; font-size: 20px;"></i>
                                                            <small class="ml-2" style="color: #6c757d; font-weight: 600; font-size: 10px; text-transform: uppercase;">Technologies</small>
                                                        </div>
                                                        <h5 class="mb-0" style="color: #2c3e50; font-weight: 600; font-size: 15px;"><?php echo e($project->technologies ?? 'N/A', false); ?></h5>
                                                    </div>
                                                </div>
                                            </div>



                                            <?php
                                                // Use pre-calculated values from controller
                                                $totalTasks = $project->totalTasks ?? 0;
                                                $completedTasks = $project->completedTasks ?? 0;
                                                $pendingTasks = $project->pendingTasks ?? 0;
                                                $progress = $project->progress ?? 0;
                                                $projectTasks = $project->calculatedTasks ?? collect();
                                            ?>

                                            <div id="progress-section-<?php echo e($project->pr_number, false); ?>" class="mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); padding: 25px; border-radius: 15px; box-shadow: 0 3px 20px rgba(0,0,0,0.1); border: 1px solid #e9ecef;">
                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <div>
                                                        <h5 class="mb-1" style="color: #2c3e50; font-weight: 700;">
                                                            <i class="fas fa-chart-line" style="color: #28a745;"></i> Project Progress
                                                        </h5>
                                                        <small class="text-muted">Task completion status</small>
                                                    </div>
                                                    <div class="text-right d-flex align-items-center" style="gap: 10px;">
                                                        <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                                                                    color: white;
                                                                    font-size: 24px;
                                                                    font-weight: 700;
                                                                    padding: 12px 24px;
                                                                    border-radius: 12px;
                                                                    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
                                                                    min-width: 100px;
                                                                    text-align: center;">
                                                            <?php echo e($progress, false); ?>%
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div style="background: #e9ecef;
                                                            height: 30px;
                                                            border-radius: 15px;
                                                            overflow: hidden;
                                                            position: relative;
                                                            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);">
                                                    <div style="background: linear-gradient(90deg, #28a745 0%, #34ce57 100%);
                                                                height: 100%;
                                                                width: <?php echo e($progress, false); ?>%;
                                                                border-radius: 15px;
                                                                transition: width 0.6s ease;
                                                                position: relative;
                                                                box-shadow: 0 2px 8px rgba(40, 167, 69, 0.4);">
                                                    </div>
                                                </div>

                                                
                                                <div class="mt-3 mb-3" style="background: white; padding: 15px 20px; border-radius: 10px; border-left: 4px solid #17a2b8; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-calendar-check" style="color: #17a2b8; font-size: 20px; margin-right: 12px;"></i>
                                                        <div>
                                                            <small style="color: #6c757d; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Expected Completion Date</small>
                                                            <h6 class="mb-0 mt-1" style="color: #2c3e50; font-weight: 600; font-size: 16px;"><?php echo e($project->latestStatus && $project->latestStatus->expected_completion ? \Carbon\Carbon::parse($project->latestStatus->expected_completion)->format('d/m/Y') : 'Not Set', false); ?></h6>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="row mt-4">
                                                    <div class="col-6">
                                                        <div style="background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%);
                                                                    padding: 20px;
                                                                    border-radius: 12px;
                                                                    border-left: 4px solid #ffc107;
                                                                    box-shadow: 0 2px 10px rgba(255, 193, 7, 0.15);">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div>
                                                                    <div style="color: #856404; font-size: 13px; font-weight: 600; margin-bottom: 5px;">
                                                                        <i class="fas fa-clock"></i> PENDING
                                                                    </div>
                                                                    <div style="color: #ffc107; font-size: 32px; font-weight: 700;">
                                                                        <?php echo e($pendingTasks, false); ?>

                                                                    </div>
                                                                </div>
                                                                <i class="fas fa-hourglass-half" style="font-size: 40px; color: #ffc107; opacity: 0.2;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div style="background: linear-gradient(135deg, #e2e3e5 0%, #d6d8db 100%);
                                                                    padding: 20px;
                                                                    border-radius: 12px;
                                                                    border-left: 4px solid #6c757d;
                                                                    box-shadow: 0 2px 10px rgba(108, 117, 125, 0.15);">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div>
                                                                    <div style="color: #495057; font-size: 13px; font-weight: 600; margin-bottom: 5px;">
                                                                        <i class="fas fa-list"></i> TOTAL TASKS
                                                                    </div>
                                                                    <div style="color: #495057; font-size: 32px; font-weight: 700;">
                                                                        <?php echo e($totalTasks, false); ?>

                                                                    </div>
                                                                </div>
                                                                <i class="fas fa-tasks" style="font-size: 40px; color: #6c757d; opacity: 0.2;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                            <div class="row">
                                                
                                                <div class="col-md-4 col-sm-6 mb-3">
                                                    <div class="stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div style="width: 100%;">
                                                                <small style="opacity: 0.9; font-weight: 600; font-size: 12px;">Tasks</small>
                                                                <div style="font-size: 13px; line-height: 1.6; max-height: 100px; overflow-y: auto; margin-top: 10px;">
                                                                    <?php
                                                                        $pendingTasks = $projectTasks->whereIn('status', ['Pending', 'pending', 'In Progress', 'in progress']);
                                                                    ?>
                                                                    <?php if($pendingTasks->count() > 0): ?>
                                                                        <?php $__currentLoopData = $pendingTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div style="padding: 6px 0; margin-bottom: 4px; border-bottom: 1px solid rgba(255,255,255,0.15);">
                                                                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px;">
                                                                                    <span style="font-weight: 600; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($task->details ?? 'Task', false); ?></span>
                                                                                    <i class="fas fa-long-arrow-alt-right" style="font-size: 11px; opacity: 0.7; flex-shrink: 0;"></i>
                                                                                    <span style="background: rgba(255,255,255,0.3); padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; flex-shrink: 0; white-space: nowrap;"><?php echo e($task->assigned ?? 'N/A', false); ?></span>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php else: ?>
                                                                        <div style="opacity: 0.7; padding: 10px 0;">No pending tasks</div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <small style="opacity: 0.85; display: block; margin-top: 10px; font-weight: 600;"><?php echo e($projectTasks->whereIn('status', ['Pending', 'pending', 'In Progress', 'in progress'])->count(), false); ?>/<?php echo e($projectTasks->count(), false); ?> Pending</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-4 col-sm-6 mb-3">
                                                    <div class="stat-card" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div style="width: 100%;">
                                                                <small style="opacity: 0.9; font-weight: 600; font-size: 12px;">Risk/Issue</small>
                                                                <div style="font-size: 13px; line-height: 1.6; max-height: 100px; overflow-y: auto; margin-top: 10px;">
                                                                    <?php if($project->risks->count() > 0): ?>
                                                                        <?php $__currentLoopData = $project->risks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $risk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div style="padding: 6px 0; margin-bottom: 4px; border-bottom: 1px solid rgba(255,255,255,0.15);">
                                                                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px;">
                                                                                    <span style="font-weight: 600; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($risk->risk, false); ?></span>
                                                                                    <i class="fas fa-long-arrow-alt-right" style="font-size: 11px; opacity: 0.7; flex-shrink: 0;"></i>
                                                                                    <span style="background: rgba(255,255,255,0.3); padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; flex-shrink: 0; white-space: nowrap;"><?php echo e($risk->impact ?? 'N/A', false); ?></span>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php else: ?>
                                                                        <div style="opacity: 0.7; padding: 10px 0;">No risks</div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <small style="opacity: 0.85; display: block; margin-top: 10px; font-weight: 600;"><?php echo e($project->risks->whereIn('status', ['closed'])->count(), false); ?>/<?php echo e($project->risks->count(), false); ?> Closed</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-4 col-sm-6 mb-3">
                                                    <div class="stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div style="width: 100%;">
                                                                <small style="opacity: 0.9; font-weight: 600; font-size: 12px;">Milestones</small>
                                                                <div style="font-size: 13px; line-height: 1.6; max-height: 100px; overflow-y: auto; margin-top: 10px;">
                                                                    <?php if($project->milestones->count() > 0): ?>
                                                                        <?php $__currentLoopData = $project->milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div style="padding: 6px 0; margin-bottom: 4px; border-bottom: 1px solid rgba(255,255,255,0.15);">
                                                                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px;">
                                                                                    <span style="font-weight: 600; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($milestone->milestone, false); ?></span>
                                                                                    <i class="fas fa-long-arrow-alt-right" style="font-size: 11px; opacity: 0.7; flex-shrink: 0;"></i>
                                                                                    <span style="background: rgba(255,255,255,0.3); padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; flex-shrink: 0; white-space: nowrap;"><?php echo e($milestone->status ?? 'N/A', false); ?></span>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php else: ?>
                                                                        <div style="opacity: 0.7; padding: 10px 0;">No milestones</div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <small style="opacity: 0.85; display: block; margin-top: 10px; font-weight: 600;"><?php echo e($project->milestones->whereIn('status', ['Completed', 'completed', 'on track'])->count(), false); ?>/<?php echo e($project->milestones->count(), false); ?> Done</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <?php if(!request('filter.pr_number_no_invoice')): ?>
                                                <div class="col-md-4 col-sm-6 mb-3">
                                                    <div class="stat-card" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div style="width: 100%;">
                                                                <small style="opacity: 0.9; font-weight: 600; font-size: 12px;">Invoices</small>
                                                                <div style="font-size: 13px; line-height: 1.6; max-height: 100px; overflow-y: auto; margin-top: 10px;">
                                                                    <?php if($project->invoices->count() > 0): ?>
                                                                        <?php $__currentLoopData = $project->invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div style="padding: 6px 0; margin-bottom: 4px; border-bottom: 1px solid rgba(255,255,255,0.15);">
                                                                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px;">
                                                                                    <span style="font-weight: 600; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($invoice->invoice_number ?? 'N/A', false); ?></span>
                                                                                    <i class="fas fa-long-arrow-alt-right" style="font-size: 11px; opacity: 0.7; flex-shrink: 0;"></i>
                                                                                    <span style="background: rgba(255,255,255,0.3); padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; flex-shrink: 0; white-space: nowrap;"><?php echo e(number_format($invoice->value ?? 0, 0), false); ?> SAR</span>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php else: ?>
                                                                        <div style="opacity: 0.7; padding: 10px 0;">No invoices</div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <small style="opacity: 0.85; display: block; margin-top: 10px; font-weight: 600;"><?php echo e($project->invoices->whereIn('status', ['paid', 'Paid'])->count(), false); ?>/<?php echo e($project->invoices->count(), false); ?> Paid</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endif; ?>

                                                
                                                <div class="col-md-4 col-sm-6 mb-3">
                                                    <div class="stat-card" style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(111, 66, 193, 0.3);">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div style="width: 100%;">
                                                                <small style="opacity: 0.9; font-weight: 600; font-size: 12px;">DNs</small>
                                                                <div style="margin-top: 10px;">
                                                                    <?php if($project->dns->count() > 0): ?>
                                                                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                                                            <?php $__currentLoopData = $project->dns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <div style="background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 13px; flex: 0 0 calc(25% - 6px); text-align: center;">
                                                                                    <?php echo e($dn->dn_number ?? 'N/A', false); ?>

                                                                                </div>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div style="opacity: 0.7; padding: 10px 0;">No DNs</div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <small style="opacity: 0.85; display: block; margin-top: 10px; font-weight: 600;"><?php echo e($project->dns->count(), false); ?> Total</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-4 col-sm-6 mb-3">
                                                    <div class="stat-card" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div style="width: 100%;">
                                                                <small style="opacity: 0.9; font-weight: 600; font-size: 12px;">Escalation</small>
                                                                <div style="font-size: 13px; line-height: 1.6; max-height: 150px; overflow-y: auto; margin-top: 10px;">
                                                                    <?php if($project->customer_contact_details || $project->aams): ?>
                                                                        
                                                                        <div style="margin-bottom: 12px;">
                                                                            <div style="font-size: 10px; opacity: 0.7; margin-bottom: 4px;">Customer Contact:</div>
                                                                            <div style="font-weight: 600; font-size: 14px;"><?php echo e($project->customer_contact_details ?? 'N/A', false); ?></div>
                                                                        </div>

                                                                        
                                                                        <?php if($project->aams): ?>
                                                                            <div style="border-top: 1px solid rgba(255,255,255,0.2); padding-top: 10px;">
                                                                                <div style="font-size: 10px; opacity: 0.7; margin-bottom: 6px;">Account Manager:</div>
                                                                                <div style="font-size: 12px; line-height: 1.8;">
                                                                                    <div style="margin-bottom: 3px;">
                                                                                        <i class="fas fa-user" style="width: 16px; opacity: 0.8;"></i>
                                                                                        <span style="font-weight: 600;"><?php echo e($project->aams->name, false); ?></span>
                                                                                    </div>
                                                                                    <?php if($project->aams->email): ?>
                                                                                        <div style="margin-bottom: 3px;">
                                                                                            <i class="fas fa-envelope" style="width: 16px; opacity: 0.8;"></i>
                                                                                            <span><?php echo e($project->aams->email, false); ?></span>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                    <?php if($project->aams->phone): ?>
                                                                                        <div>
                                                                                            <i class="fas fa-phone" style="width: 16px; opacity: 0.8;"></i>
                                                                                            <span><?php echo e($project->aams->phone, false); ?></span>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    <?php else: ?>
                                                                        <div style="opacity: 0.7; padding: 10px 0; text-align: center;">No contact info</div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="card"
                                    style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 123, 255, 0.15);">
                                    <div class="card-header"
                                        style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border-radius: 15px 15px 0 0;">
                                        <h4 class="card-title text-white mb-0">
                                            <i class="fas fa-chart-line"></i> Filtered Dashboard Data
                                        </h4>
                                    </div>
                                    <div class="card-body" style="min-height: 400px;">
                                        <div class="text-center py-5">
                                            <i class="fas fa-chart-bar"
                                                style="font-size: 4rem; color: #007bff; opacity: 0.3;"></i>
                                            <h5 class="mt-4" style="color: #6c757d;">Apply filters to view customized
                                                data</h5>
                                            <p class="text-muted">Use the filters on the left to narrow down your dashboard
                                                view</p>
                                            <div class="mt-4">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle"></i>
                                                    Select filters and click "Apply Filters" to see results
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Filter section closed -->
    </div>
    </div>
    <!-- Container closed -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <!--Internal  Chart.bundle js -->
    <script src="<?php echo e(URL::asset('assets/plugins/chart.js/Chart.bundle.min.js'), false); ?>"></script>
    <!-- Moment js -->
    <script src="<?php echo e(URL::asset('assets/plugins/raphael/raphael.min.js'), false); ?>"></script>
    <!--Internal  Flot js-->
    <script src="<?php echo e(URL::asset('assets/plugins/jquery.flot/jquery.flot.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/dashboard.sampledata.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/chart.flot.sampledata.js'), false); ?>"></script>
    <!--Internal Apexchart js-->
    <script src="<?php echo e(URL::asset('assets/js/apexcharts.js'), false); ?>"></script>
    <!-- Internal Map -->
    <script src="<?php echo e(URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/modal-popup.js'), false); ?>"></script>
    <!--Internal  index js -->
    <script src="<?php echo e(URL::asset('assets/js/index.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/jquery.vmap.sampledata.js'), false); ?>"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'default',
                width: '100%',
                placeholder: function() {
                    return $(this).data('placeholder');
                },
                allowClear: true
            });

            // Toggle collapse icons
            $('.card-header[data-toggle="collapse"]').on('click', function() {
                $(this).find('.toggle-icon').toggleClass('collapsed');
            });

            // Smooth scroll animation for filter sidebar
            $('.filter-sidebar').on('scroll', function() {
                var scrollTop = $(this).scrollTop();
                if (scrollTop > 50) {
                    $(this).addClass('scrolled');
                } else {
                    $(this).removeClass('scrolled');
                }
            });
        });

        // Reset Filters Function
        function resetFilters() {
            // Show loading state
            const resetBtn = event.target.closest('button');
            const originalHtml = resetBtn.innerHTML;
            resetBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Resetting...';
            resetBtn.disabled = true;

            // Clear all select2 selections
            $('.select2').val(null).trigger('change');

            // Clear all form inputs
            $('#filterForm')[0].reset();

            // Clear text inputs specifically
            $('#filterForm input[type="text"]').val('');
            $('#filterForm input[type="number"]').val('');

            // Redirect to dashboard without filters
            setTimeout(function() {
                window.location.href = '<?php echo e(route('dashboard.index'), false); ?>';
            }, 300);
        }

        // Form submission with loading indicator
        $('#filterForm').on('submit', function(e) {
            // Show loading state
            $('.btn-apply-filter').html('<i class="fas fa-spinner fa-spin"></i> Applying...').prop('disabled',
            true);
        });

        // Collapse all filters function
        function collapseAllFilters() {
            $('.collapse').collapse('hide');
        }

        // Expand all filters function
        function expandAllFilters() {
            $('.collapse').collapse('show');
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Herd\MDSJEDPR\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>