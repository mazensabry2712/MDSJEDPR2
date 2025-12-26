<?php $__env->startSection('css'); ?>
    <!--- Internal Select2 css-->
    <link href="<?php echo e(URL::asset('assets/plugins/select2/css/select2.min.css'), false); ?>" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="<?php echo e(URL::asset('assets/plugins/fileuploads/css/fileupload.css'), false); ?>" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="<?php echo e(URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css'), false); ?>" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="<?php echo e(URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css'), false); ?>">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="<?php echo e(URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css'), false); ?>">

    <style>
        /* Drag and Drop Styles */
        .drag-drop-area {
            border: 3px dashed #dee2e6;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            min-height: 200px;
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
            margin-bottom: 20px;
        }

        .drag-drop-title {
            color: #495057;
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .drag-drop-subtitle {
            color: #6c757d;
            margin-bottom: 15px;
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
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 15px;
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
        }

        .file-size {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .remove-file {
            margin-top: 10px;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    Add Customer
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-header'); ?>
    <!-- breadcrumb -->
    <?php $__currentLoopData = ['Error', 'Add', 'delete', 'edit']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(session()->has($msg)): ?>
            <div class="alert alert-<?php echo e($msg == 'Error' || $msg == 'delete' ? 'danger' : 'success', false); ?> alert-dismissible fade show"
                role="alert">
                <strong><?php echo e(session()->get($msg), false); ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Add Customer</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Customer</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(session()->has('Add')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><?php echo e(session()->get('Add'), false); ?></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error, false); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- row -->

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="yourFormId" action="<?php echo e(route('customer.store'), false); ?>" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        <?php echo e(csrf_field(), false); ?>

                        
                        <div class="row">
                            <div class="col">
                                <label for="name" class="control-label">Name </label>
                                <input type="text" class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : '', false); ?>" id="name" name="name" value="<?php echo e(old('name'), false); ?>"
                                    title="   Please enter the Customer name  ">
                                <?php if($errors->has('name')): ?>
                                    <div class="invalid-feedback"><?php echo e($errors->first('name'), false); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <label for="abb" class="control-label">Abb </label>
                                <input type="text" class="form-control" id="abb" name="abb" value="<?php echo e(old('abb'), false); ?>"
                                    title="   Please enter the customer Abb  ">
                            </div>


                            <div class="col">
                                <label for="tybe" class="control-label">Type</label>
                                <select class="form-control SlectBox"onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')" id="tybe" name="tybe" required>
                                    <option value="">Select Value</option>
                                    <option value="GOV" <?php echo e(old('tybe') == 'GOV' ? 'selected' : '', false); ?>>GOV</option>
                                    <option value="PRIVATE" <?php echo e(old('tybe') == 'PRIVATE' ? 'selected' : '', false); ?>>PRIVATE</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col">
                                <div style="text-align:justify;">
                                    <div style="display: inline-flex;">
                                        <h5 class="card-title mr-3">Customer Logo</h5>
                                        <p class="text-primary">* Attachment format pdf, jpeg, .jpg, png </p>
                                    </div>

                                </div>


                                <div class="col-sm-12 col-md-12">
                                    <div class="drag-drop-area" id="dragDropArea">
                                        <input type="file" name="logo" id="logoInput"
                                            accept=".jpg,.jpeg,.png,.gif,.webp"
                                            style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;" />

                                        <div class="drag-drop-content" style="pointer-events: none;">
                                            <div class="drag-drop-icon">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
                                            </div>
                                            <h4 class="drag-drop-title">Drag & Drop Logo Here</h4>
                                            <p class="drag-drop-subtitle">or <span class="browse-link" style="color: #007bff; text-decoration: underline; cursor: pointer;">click to browse</span></p>
                                            <small class="text-muted">Supported formats: JPG, JPEG, PNG, GIF, WEBP (Max: 2MB)</small>
                                        </div>

                                        <div class="file-preview d-none" style="pointer-events: all; position: relative; z-index: 20;">
                                            <div class="preview-content">
                                                <img class="preview-image" src="" alt="Preview">
                                                <div class="preview-info">
                                                    <span class="file-name"></span>
                                                    <span class="file-size"></span>
                                                    <button type="button" class="btn btn-sm btn-danger remove-file">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if($errors->has('logo')): ?>
                                        <div class="invalid-feedback d-block"><?php echo e($errors->first('logo'), false); ?></div>
                                    <?php endif; ?>
                                    <?php if(session('logo_preview')): ?>
                                        <div class="mt-2 previous-file-info">
                                            <div class="alert alert-info alert-sm">
                                                <i class="fas fa-info-circle"></i>
                                                <strong>File was selected:</strong> <?php echo e(session('logo_preview'), false); ?>

                                                <br><small>Please select the file again to continue</small>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div><br>

                            </div>

                        </div>


                        <div class="row mt-1">
                            <div class="col">
                                <label for="customercontactname" class="control-label">Customer Contact Name </label>
                                <input type="text" class="form-control" id="customercontactname"
                                    name="customercontactname" value="<?php echo e(old('customercontactname'), false); ?>" title="   Please enter the Customer Contact Name  ">
                            </div>
                            <div class="col">
                                <label for="customercontactposition" class="control-label">Customer Contact Position</label>
                                <input type="text" class="form-control" id="customercontactposition"
                                    name="customercontactposition" value="<?php echo e(old('customercontactposition'), false); ?>" title="   Please enter the Customer Contact Position  ">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="email" class="control-label">Email </label>
                                <input type="email" class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : '', false); ?>" id="email" name="email" value="<?php echo e(old('email'), false); ?>"
                                    title="   Please enter the Customer Email  ">
                                <?php if($errors->has('email')): ?>
                                    <div class="invalid-feedback"><?php echo e($errors->first('email'), false); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <label for="phone" class="control-label">Phone </label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo e(old('phone'), false); ?>"
                                    title="   Please enter the Customer Phone  ">
                            </div>
                        </div>


                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary"> Save Customer </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <!-- Internal Select2 js-->
    <script src="<?php echo e(URL::asset('assets/plugins/select2/js/select2.min.js'), false); ?>"></script>
    <!--Internal Fileuploads js-->
    <script src="<?php echo e(URL::asset('assets/plugins/fileuploads/js/fileupload.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/fileuploads/js/file-upload.js'), false); ?>"></script>
    <!--Internal Fancy uploader js-->
    <script src="<?php echo e(URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/fancyuploder/fancy-uploader.js'), false); ?>"></script>
    <!--Internal  Form-elements js-->
    <script src="<?php echo e(URL::asset('assets/js/advanced-form-elements.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/select2.js'), false); ?>"></script>
    <!--Internal Sumoselect js-->
    <script src="<?php echo e(URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js'), false); ?>"></script>

    <script>
        // Drag and Drop functionality
        $(document).ready(function() {
            const dragDropArea = $('#dragDropArea');
            const fileInput = $('#logoInput');
            const filePreview = dragDropArea.find('.file-preview');
            const dragDropContent = dragDropArea.find('.drag-drop-content');

            console.log('Drag & Drop Initialized');

            // File input change event
            fileInput.on('change', function() {
                console.log('File selected:', this.files.length);
                if (this.files.length > 0) {
                    handleFiles(this.files);
                }
            });

            // Drag and drop events
            dragDropArea.on('dragover dragenter', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });

            dragDropArea.on('dragleave dragend', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });

            dragDropArea.on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');

                const files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    handleFiles(files);
                }
            });

            // Remove file button
            $(document).on('click', '.remove-file', function(e) {
                e.preventDefault();
                e.stopPropagation();
                removeFile();
            });

            function handleFiles(files) {
                const file = files[0];

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPG, JPEG, PNG, GIF, WEBP)');
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
                showPreview(file);
            }

            function showPreview(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    filePreview.find('.preview-image').attr('src', e.target.result);
                    filePreview.find('.file-name').text(file.name);
                    filePreview.find('.file-size').text(formatFileSize(file.size));

                    dragDropContent.addClass('d-none');
                    filePreview.removeClass('d-none');
                };
                reader.readAsDataURL(file);
            }

            function removeFile() {
                fileInput.val('');
                filePreview.addClass('d-none');
                dragDropContent.removeClass('d-none');
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

    <!--Internal  Datepicker js -->
    <script src="<?php echo e(URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js'), false); ?>"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="<?php echo e(URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js'), false); ?>"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="<?php echo e(URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js'), false); ?>"></script>
    <!-- Internal form-elements js -->
    <script src="<?php echo e(URL::asset('assets/js/form-elements.js'), false); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Herd\MDSJEDPR\resources\views/dashboard/customer/create.blade.php ENDPATH**/ ?>