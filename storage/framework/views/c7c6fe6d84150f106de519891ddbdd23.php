<?php $__env->startSection('css'); ?>
    <!-- Internal Select2 css -->
    <link href="<?php echo e(URL::asset('assets/plugins/select2/css/select2.min.css'), false); ?>" rel="stylesheet">
    <!-- Internal DatePicker css -->
    <link href="<?php echo e(URL::asset('assets/plugins/jquery-ui/ui/1.12.1/themes/base/jquery-ui.css'), false); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css'), false); ?>" rel="stylesheet">

    <style>
        .text-info {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .form-text {
            font-size: 0.8rem;
        }

        .select2-container .select2-selection--multiple {
            min-height: 38px;
            border: 1px solid #ced4da;
        }

        .select2-container .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 2px 8px;
            margin: 2px;
        }

        .select2-container .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 5px;
        }

        .select2-container .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #dc3545;
        }

        /* Drag and Drop Styles */
        .drag-drop-area {
            border: 3px dashed #dee2e6;
            border-radius: 12px;
            padding: 30px 15px;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            min-height: 160px;
        }

        .drag-drop-area:hover {
            border-color: #007bff;
            background-color: #e7f3ff;
        }

        .drag-drop-area.dragover {
            border-color: #28a745;
            background-color: #d4edda;
            transform: scale(1.02);
        }

        .drag-drop-content {
            pointer-events: auto;
        }

        .drag-drop-icon {
            margin-bottom: 15px;
        }

        .drag-drop-title {
            color: #495057;
            margin-bottom: 8px;
            font-size: 1.2rem;
        }

        .drag-drop-subtitle {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .browse-link {
            color: #007bff;
            text-decoration: underline;
            cursor: pointer;
            pointer-events: auto !important;
            z-index: 10;
            position: relative;
        }

        .file-preview {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-content {
            text-align: center;
            max-width: 90%;
        }

        .preview-image {
            max-width: 120px;
            max-height: 120px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 10px;
        }

        .preview-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .file-name {
            font-weight: bold;
            color: #495057;
            font-size: 0.9rem;
        }

        .file-size {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .remove-file {
            margin-top: 8px;
        }

        .file-icon-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .file-icon-preview i {
            color: #007bff;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Projects</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Edit Project</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a href="<?php echo e(route('projects.index'), false); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
        </div>
    </div>
    <!-- breadcrumb -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Display validation errors -->
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error, false); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Main content row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title mb-0">Edit Project</h5>
                    </div>
                </div>

                <div class="card-body">
                    <form action="<?php echo e(route('projects.update', $project->id), false); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row">
                            <!-- PR Number -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pr_number">PR Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['pr_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="pr_number" name="pr_number" value="<?php echo e(old('pr_number', $project->pr_number), false); ?>" required>
                                    <?php $__errorArgs = ['pr_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Project Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Project Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="name" name="name" value="<?php echo e(old('name', $project->name), false); ?>" required>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Technologies -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="technologies">Technologies</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['technologies'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="technologies" name="technologies" value="<?php echo e(old('technologies', $project->technologies), false); ?>">
                                    <?php $__errorArgs = ['technologies'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Vendors (Multiple Selection) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vendors">Vendors <span class="text-info">*Multiple Selection</span></label>
                                    <select class="form-control select2-multiple <?php $__errorArgs = ['vendors'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="vendors" name="vendors[]" multiple>
                                        <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($vendor->id, false); ?>"
                                                <?php echo e((collect(old('vendors', $project->vendors->pluck('id')->toArray()))->contains($vendor->id)) ? 'selected' : '', false); ?>>
                                                <?php echo e($vendor->vendors, false); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <small class="form-text text-muted">Select one or more vendors.</small>
                                    <?php $__errorArgs = ['vendors'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php $__errorArgs = ['vendors_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Disti/Supplier(Multiple Selection) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="delivery_specialists">Disti/Supplier<span class="text-info">*Multiple Selection</span></label>
                                    <select class="form-control select2-multiple <?php $__errorArgs = ['delivery_specialists'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="delivery_specialists" name="delivery_specialists[]" multiple>
                                        <?php $__currentLoopData = $ds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dsItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($dsItem->id, false); ?>"
                                                <?php echo e((collect(old('delivery_specialists', $project->deliverySpecialists->pluck('id')->toArray()))->contains($dsItem->id)) ? 'selected' : '', false); ?>>
                                                <?php echo e($dsItem->dsname, false); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <small class="form-text text-muted">Select one or more DS. First selected will be lead.</small>
                                    <?php $__errorArgs = ['delivery_specialists'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php $__errorArgs = ['ds_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Customer Selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer">Customer <span class="text-danger">*</span></label>
                                    <select class="form-control select2 <?php $__errorArgs = ['cust_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="customer" name="cust_id" required>
                                        <option value="">Select Customer</option>
                                        <?php $__currentLoopData = $custs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cust->id, false); ?>" <?php echo e(old('cust_id', $project->cust_id) == $cust->id ? 'selected' : '', false); ?>>
                                                <?php echo e($cust->name, false); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['cust_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Customer PO -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_po">Customer PO</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['customer_po'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="customer_po" name="customer_po" value="<?php echo e(old('customer_po', $project->customer_po), false); ?>">
                                    <?php $__errorArgs = ['customer_po'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Value -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="value">Value</label>
                                    <input type="number" step="0.01" class="form-control <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="value" name="value" value="<?php echo e(old('value', $project->value), false); ?>">
                                    <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- AC Manager -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="aams_id">AC Manager</label>
                                    <select class="form-control select2 <?php $__errorArgs = ['aams_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="aams_id" name="aams_id">
                                        <option value="">Select AC Manager</option>
                                        <?php $__currentLoopData = $aams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($aam->id, false); ?>"
                                                <?php echo e(old('aams_id', $project->aams_id) == $aam->id ? 'selected' : '', false); ?>>
                                                <?php echo e($aam->name, false); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['aams_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Project Manager -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ppms_id">Project Manager</label>
                                    <select class="form-control select2 <?php $__errorArgs = ['ppms_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="ppms_id" name="ppms_id">
                                        <option value="">Select Project Manager</option>
                                        <?php $__currentLoopData = $ppms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ppm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($ppm->id, false); ?>"
                                                <?php echo e(old('ppms_id', $project->ppms_id) == $ppm->id ? 'selected' : '', false); ?>>
                                                <?php echo e($ppm->name, false); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['ppms_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Customer Contact Details -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="customer_contact_details">Customer Contact Details</label>
                                    <textarea class="form-control <?php $__errorArgs = ['customer_contact_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              id="customer_contact_details" name="customer_contact_details" rows="3"><?php echo e(old('customer_contact_details', $project->customer_contact_details), false); ?></textarea>
                                    <?php $__errorArgs = ['customer_contact_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- PO Date -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="customer_po_date">PO Date</label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['customer_po_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="customer_po_date" name="customer_po_date"
                                           value="<?php echo e(old('customer_po_date', $project->customer_po_date), false); ?>">
                                    <?php $__errorArgs = ['customer_po_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Duration (Days) -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="customer_po_duration">Duration (Days)</label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['customer_po_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="customer_po_duration" name="customer_po_duration"
                                           value="<?php echo e(old('customer_po_duration', $project->customer_po_duration), false); ?>">
                                    <?php $__errorArgs = ['customer_po_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Deadline -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="customer_po_deadline">Deadline</label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['customer_po_deadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="customer_po_deadline" name="customer_po_deadline"
                                           value="<?php echo e(old('customer_po_deadline', $project->customer_po_deadline), false); ?>">
                                    <?php $__errorArgs = ['customer_po_deadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- PO Attachment -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="po_attachment">PO Attachment</label>
                                    <?php if($project->po_attachment): ?>
                                        <div class="mb-2">
                                            <small class="text-muted">Current file:
                                                <a href="<?php echo e(asset($project->po_attachment), false); ?>" target="_blank">
                                                    <?php echo e(basename($project->po_attachment), false); ?>

                                                </a>
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                    <div class="drag-drop-area" id="dragDropAreaPO" onclick="if(!event.target.closest('.file-preview') && !event.target.classList.contains('remove-file')) { document.getElementById('po_attachment').click(); }">
                                        <input type="file" name="po_attachment" id="po_attachment" class="d-none <?php $__errorArgs = ['po_attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            accept=".pdf,.jpg,.jpeg,.png" />

                                        <div class="drag-drop-content">
                                            <div class="drag-drop-icon">
                                                <i class="fas fa-cloud-upload-alt fa-2x text-primary"></i>
                                            </div>
                                            <h5 class="drag-drop-title">Drag & Drop PO File</h5>
                                            <p class="drag-drop-subtitle">or <span class="browse-link">click to browse</span></p>
                                            <small class="text-muted">PDF, JPG, JPEG, PNG (Max: 2MB)</small>
                                        </div>

                                        <div class="file-preview d-none">
                                            <div class="preview-content">
                                                <div class="file-icon-preview">
                                                    <img class="preview-image d-none" src="" alt="Preview">
                                                    <i class="fas fa-file-alt fa-3x d-none file-icon"></i>
                                                    <div class="preview-info">
                                                        <span class="file-name"></span>
                                                        <span class="file-size"></span>
                                                        <button type="button" class="btn btn-sm btn-danger remove-file">
                                                            <i class="fas fa-times"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['po_attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- EPO Attachment -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="epo_attachment">EPO Attachment</label>
                                    <?php if($project->epo_attachment): ?>
                                        <div class="mb-2">
                                            <small class="text-muted">Current file:
                                                <a href="<?php echo e(asset($project->epo_attachment), false); ?>" target="_blank">
                                                    <?php echo e(basename($project->epo_attachment), false); ?>

                                                </a>
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                    <div class="drag-drop-area" id="dragDropAreaEPO" onclick="if(!event.target.closest('.file-preview') && !event.target.classList.contains('remove-file')) { document.getElementById('epo_attachment').click(); }">
                                        <input type="file" name="epo_attachment" id="epo_attachment" class="d-none <?php $__errorArgs = ['epo_attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            accept=".pdf,.jpg,.jpeg,.png" />

                                        <div class="drag-drop-content">
                                            <div class="drag-drop-icon">
                                                <i class="fas fa-cloud-upload-alt fa-2x text-success"></i>
                                            </div>
                                            <h5 class="drag-drop-title">Drag & Drop EPO File</h5>
                                            <p class="drag-drop-subtitle">or <span class="browse-link">click to browse</span></p>
                                            <small class="text-muted">PDF, JPG, JPEG, PNG (Max: 2MB)</small>
                                        </div>

                                        <div class="file-preview d-none">
                                            <div class="preview-content">
                                                <div class="file-icon-preview">
                                                    <img class="preview-image d-none" src="" alt="Preview">
                                                    <i class="fas fa-file-alt fa-3x d-none file-icon"></i>
                                                    <div class="preview-info">
                                                        <span class="file-name"></span>
                                                        <span class="file-size"></span>
                                                        <button type="button" class="btn btn-sm btn-success remove-file">
                                                            <i class="fas fa-times"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['epo_attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Description -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              id="description" name="description" rows="4"><?php echo e(old('description', $project->description), false); ?></textarea>
                                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message, false); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields for backward compatibility -->
                        <input type="hidden" id="vendors_id" name="vendors_id" value="<?php echo e(old('vendors_id', $project->vendors_id), false); ?>">
                        <input type="hidden" id="ds_id" name="ds_id" value="<?php echo e(old('ds_id', $project->ds_id), false); ?>">

                        <!-- Submit Buttons -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Project
                            </button>
                            <a href="<?php echo e(route('projects.index'), false); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <!-- Internal Select2 js -->
    <script src="<?php echo e(URL::asset('assets/plugins/select2/js/select2.min.js'), false); ?>"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for single selection
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true
            });

            // Initialize Select2 for multiple selection
            $('.select2-multiple').select2({
                placeholder: "Select multiple options",
                allowClear: true,
                closeOnSelect: false
            });

            // Auto-update hidden fields when multiple selections change
            $('#vendors').on('change', function() {
                var selected = $(this).val();
                if (selected && selected.length > 0) {
                    $('#vendors_id').val(selected[0]);
                } else {
                    $('#vendors_id').val('');
                }
            });

            $('#delivery_specialists').on('change', function() {
                var selected = $(this).val();
                if (selected && selected.length > 0) {
                    $('#ds_id').val(selected[0]);
                } else {
                    $('#ds_id').val('');
                }
            });

            // Initialize hidden fields with current selections on page load
            setTimeout(function() {
                $('#vendors').trigger('change');
                $('#delivery_specialists').trigger('change');
            }, 100);

            // Calculate deadline based on PO date and duration
            $('#customer_po_date, #customer_po_duration').on('change', function() {
                var poDate = $('#customer_po_date').val();
                var duration = $('#customer_po_duration').val();

                if (poDate && duration) {
                    var date = new Date(poDate);
                    date.setDate(date.getDate() + parseInt(duration));

                    var deadline = date.toISOString().split('T')[0];
                    $('#customer_po_deadline').val(deadline);
                }
            });

            // ========== Drag & Drop File Upload ==========
            initializeDragDrop('po_attachment', 'dragDropAreaPO');
            initializeDragDrop('epo_attachment', 'dragDropAreaEPO');

            function initializeDragDrop(inputId, areaId) {
                const dragDropArea = $('#' + areaId);
                const fileInput = $('#' + inputId);

                // Prevent default drag behaviors
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dragDropArea[0].addEventListener(eventName, preventDefaults, false);
                    document.body.addEventListener(eventName, preventDefaults, false);
                });

                // Highlight drop area when item is dragged over it
                ['dragenter', 'dragover'].forEach(eventName => {
                    dragDropArea[0].addEventListener(eventName, () => {
                        dragDropArea.addClass('dragover');
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dragDropArea[0].addEventListener(eventName, () => {
                        dragDropArea.removeClass('dragover');
                    }, false);
                });

                // Handle dropped files
                dragDropArea[0].addEventListener('drop', function(e) {
                    const files = e.dataTransfer.files;
                    handleFiles(files, inputId, areaId);
                }, false);

                // Handle file input change
                fileInput.on('change', function() {
                    if (this.files.length > 0) {
                        handleFiles(this.files, inputId, areaId);
                    }
                });

                // Remove file button
                dragDropArea.on('click', '.remove-file', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    removeFile(inputId, areaId);
                });
            }

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function handleFiles(files, inputId, areaId) {
                const file = files[0];
                const dragDropArea = $('#' + areaId);
                const fileInput = $('#' + inputId);

                // Validate file type
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid file (PDF, JPG, JPEG, PNG)');
                    return;
                }

                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    return;
                }

                // Set file to input
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput[0].files = dt.files;

                // Show preview
                showPreview(file, areaId);
            }

            function showPreview(file, areaId) {
                const dragDropArea = $('#' + areaId);
                const dragDropContent = dragDropArea.find('.drag-drop-content');
                const filePreview = dragDropArea.find('.file-preview');

                // Check if it's an image
                const isImage = file.type.startsWith('image/');

                if (isImage) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        filePreview.find('.preview-image').attr('src', e.target.result).removeClass('d-none');
                        filePreview.find('.file-icon').addClass('d-none');
                        filePreview.find('.file-name').text(file.name);
                        filePreview.find('.file-size').text(formatFileSize(file.size));

                        dragDropContent.addClass('d-none');
                        filePreview.removeClass('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Show file icon for non-images (PDF)
                    filePreview.find('.preview-image').addClass('d-none');
                    filePreview.find('.file-icon').removeClass('d-none');
                    filePreview.find('.file-name').text(file.name);
                    filePreview.find('.file-size').text(formatFileSize(file.size));

                    dragDropContent.addClass('d-none');
                    filePreview.removeClass('d-none');
                }
            }

            function removeFile(inputId, areaId) {
                const dragDropArea = $('#' + areaId);
                const fileInput = $('#' + inputId);
                const dragDropContent = dragDropArea.find('.drag-drop-content');
                const filePreview = dragDropArea.find('.file-preview');

                fileInput.val('');
                filePreview.addClass('d-none');
                dragDropContent.removeClass('d-none');

                // Reset preview elements
                filePreview.find('.preview-image').attr('src', '').addClass('d-none');
                filePreview.find('.file-icon').addClass('d-none');
                filePreview.find('.file-name').text('');
                filePreview.find('.file-size').text('');
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Herd\MDSJEDPR\resources\views/dashboard/projects/edit.blade.php ENDPATH**/ ?>