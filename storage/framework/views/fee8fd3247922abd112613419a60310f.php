<?php $__env->startSection('title'); ?>
    Add New PPO
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('assets/plugins/select2/css/select2.min.css'), false); ?>" rel="stylesheet">
    <style>
        /* تحسين مظهر textarea في الـ forms */
        .form-control textarea,
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        textarea.form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Project Purchase Orders</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Add New PPO</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error, false); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            <a class="btn btn-primary btn-sm" href="<?php echo e(route('ppos.index'), false); ?>">Back</a>
                        </div>
                    </div><br>

                    <form action="<?php echo e(route('ppos.store'), false); ?>" method="POST" autocomplete="off">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Project Number: <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="pr_number" id="pr_number" required>
                                        <option value="">Choose Project</option>
                                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($project->id, false); ?>"
                                                    data-project-name="<?php echo e($project->name, false); ?>"
                                                    <?php echo e(old('pr_number') == $project->id ? 'selected' : '', false); ?>>
                                                <?php echo e($project->pr_number, false); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_name_display" class="form-label">Project Name</label>
                                    <input type="text"
                                           class="form-control"
                                           id="project_name_display"
                                           placeholder="Project name will appear here..."
                                           readonly
                                           style="background-color: #f8f9fa; cursor: not-allowed;">
                                </div>
                            </div>
                        </div>

                        <div class="row">
            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category" class="form-label">Category: <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" id="category" name="category" required>
                                        <option value="" disabled selected>Select PR Number first</option>
                                    </select>
                                    <small class="text-muted">Select category after selecting PR Number</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dsname" class="form-label">Supplier Name: <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="dsname" required>
                                        <option value="">Choose Supplier</option>
                                        <?php $__currentLoopData = $dses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($ds->id, false); ?>" <?php echo e(old('dsname') == $ds->id ? 'selected' : '', false); ?>>
                                                <?php echo e($ds->dsname, false); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="po_number" class="form-label">PO Number: <span class="tx-danger">*</span></label>
                                    <input type="text" class="form-control" id="po_number" name="po_number"
                                           value="<?php echo e(old('po_number'), false); ?>" placeholder="Enter PO Number" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="value" class="form-label">Value:</label>
                                    <input type="number" step="0.01" min="0" class="form-control" id="value" name="value"
                                           value="<?php echo e(old('value'), false); ?>" placeholder="Enter Value">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date" class="form-label">Date:</label>
                                    <input type="date" class="form-control" id="date" name="date" value="<?php echo e(old('date'), false); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="updates" class="form-label">Updates:</label>
                                    <textarea class="form-control" id="updates" name="updates" rows="4"
                                              placeholder="Enter updates..."><?php echo e(old('updates'), false); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status:</label>
                                    <textarea class="form-control" id="status" name="status" rows="4"
                                              placeholder="Enter status..."><?php echo e(old('status'), false); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="notes" class="form-label">Notes:</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="4"
                                              placeholder="Enter notes..."><?php echo e(old('notes'), false); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mg-t-30">
                            <button class="btn btn-outline-primary pd-x-20" type="submit">Add PPO</button>
                            <a href="<?php echo e(route('ppos.index'), false); ?>" class="btn btn-outline-secondary pd-x-20">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(URL::asset('assets/plugins/select2/js/select2.min.js'), false); ?>"></script>
    <!-- Removed select2.js to prevent conflicts -->

    <script>
        $(document).ready(function() {
            console.log('✅ PPOS Create page loaded');
            console.log('jQuery version:', $.fn.jquery);
            console.log('Select2 available:', typeof $.fn.select2 !== 'undefined');

            // Initialize ALL Select2 elements on the page
            $('.select2').select2({
                placeholder: 'Choose one',
                width: '100%'
            });

            // Override specific Select2 configurations
            $('#pr_number').select2({
                placeholder: "Choose Project",
                allowClear: true,
                width: '100%'
            });

            $('#category').select2({
                placeholder: "Select PR Number first",
                allowClear: true,
                width: '100%'
            });

            console.log('✅ Select2 initialized manually');

            // Attach change event immediately
            $('#pr_number').on('change', function() {
                console.log('🔔 PR Number changed!');

                const selectedOption = $(this).find('option:selected');
                const projectName = selectedOption.data('project-name');
                const prNumber = $(this).val();

                console.log('Selected PR Number ID:', prNumber);
                console.log('Project Name:', projectName);

                // Fill Project Name
                if (projectName) {
                    $('#project_name_display').val(projectName).css('color', '#495057');
                } else {
                    $('#project_name_display').val('No project name available').css('color', '#6c757d');
                }

                // Load Categories from EPO
                if (prNumber) {
                    loadCategories(prNumber);
                } else {
                    resetCategoryDropdown();
                }
            });

            // Initialize on page load if old value exists
            if ($('#pr_number').val()) {
                console.log('Old value exists, triggering change');
                $('#pr_number').trigger('change');
            }

            // Function to load categories based on PR Number
            function loadCategories(prNumber) {
                console.log('📡 Loading categories for Project ID:', prNumber);

                // Show loading state
                $('#category').prop('disabled', true);

                // Destroy existing Select2 before updating
                if ($('#category').data('select2')) {
                    $('#category').select2('destroy');
                }

                $('#category').html('<option disabled selected>Loading...</option>');

                $.ajax({
                    url: `/ppos/categories/${prNumber}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('✅ AJAX Response:', response);

                        if (response.success && response.categories && response.categories.length > 0) {
                            let options = '';
                            let categoryIds = [];

                            response.categories.forEach(function(category) {
                                options += `<option value="${category.id}">${category.category || 'N/A'}</option>`;
                                categoryIds.push(category.id);
                                console.log('  ➕ Category ID:', category.id, '- Name:', category.category);
                            });

                            $('#category').html(options);
                            $('#category').prop('disabled', false);

                            // Re-initialize Select2 for single selection
                            $('#category').select2({
                                placeholder: 'Select a category',
                                allowClear: true,
                                width: '100%'
                            });

                            console.log(`✅ Loaded ${response.categories.length} categories`);
                        } else {
                            console.warn('⚠️ No categories found for Project ID:', prNumber);
                            resetCategoryDropdown();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('❌ AJAX Error:', error);
                        console.error('❌ Status:', status);
                        console.error('❌ Response Text:', xhr.responseText);
                        console.error('❌ Status Code:', xhr.status);
                        resetCategoryDropdown();
                    }
                });
            }

            // Function to reset category dropdown
            function resetCategoryDropdown() {
                console.log('🔄 Resetting category dropdown');

                // Destroy existing Select2
                if ($('#category').data('select2')) {
                    $('#category').select2('destroy');
                }

                $('#category').html('<option value="" disabled selected>No categories available</option>');
                $('#category').prop('disabled', true);

                // Re-initialize Select2
                $('#category').select2({
                    placeholder: 'No categories available',
                    allowClear: true
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Herd\MDSJEDPR\resources\views/dashboard/PPOs/create.blade.php ENDPATH**/ ?>