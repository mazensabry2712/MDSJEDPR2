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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    Add EPO
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Add pepo </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    pepo</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!-- <?php if(session()->has('Add')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo e(session()->get('Add'), false); ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
    <?php endif; ?> -->
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
                    <form id="yourFormId" action="<?php echo e(route('epo.store'), false); ?>" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        <?php echo e(csrf_field(), false); ?>

                        



                        <div class="row mt-3">
                            <!-- PR Number -->
                            <div class="col-md-6">
                                <label for="pr_number" class="control-label">PR Number <span class="text-danger">*</span></label>
                                <select id="pr_number" name="pr_number" class="form-control select2" required>
                                    <option value="">Select PR Number</option>
                                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($project->id, false); ?>"
                                                data-project-name="<?php echo e($project->name, false); ?>"
                                                <?php echo e(old('pr_number') == $project->id ? 'selected' : '', false); ?>>
                                            <?php echo e($project->pr_number, false); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['pr_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message, false); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Project Name (Auto-filled, readonly) -->
                            <div class="col-md-6">
                                <label for="project_name" class="control-label">Project Name</label>
                                <input type="text"
                                       id="project_name"
                                       class="form-control"
                                       value="<?php echo e(old('project_name'), false); ?>"
                                       placeholder="Project Name will appear here"
                                       readonly
                                       style="background-color: #e9ecef; cursor: not-allowed;">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="category" class="control-label">Category</label>
                                <input type="text" class="form-control" id="category" name="category"
                                    value="<?php echo e(old('category'), false); ?>"
                                    title="Please enter the category">
                            </div>
                        </div>




                        <div class="row mt-3">
                            <div class="col">
                                <label for="expected_com_date" class="control-label">Planned Cost </label>
                                <input type="number" class="form-control" id="expected_com_date" name="planned_cost"
                                    title="   Please enter the planned_cost ">
                            </div>

                            <div class="col">
                                <label for="" class="control-label">Selling Price </label>
                                <input type="number" class="form-control" id="" name="selling_price"
                                    title="   Please enter the selling_price ">
                            </div>

                        </div>
                        <br>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary"> Save pepo </button>
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
    <!--Internal  Datepicker js -->
    <script src="<?php echo e(URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js'), false); ?>"></script>
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
    <!-- Internal TelephoneInput js-->
    <script src="<?php echo e(URL::asset('assets/plugins/telephoneinput/telephoneinput.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js'), false); ?>"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2();

            // Auto-fill Project Name when PR Number changes
            $('#pr_number').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var projectName = selectedOption.data('project-name') || '';
                $('#project_name').val(projectName);
            });

            // Trigger on page load (for old values)
            var initialProjectName = $('#pr_number').find(':selected').data('project-name') || '';
            if(initialProjectName) {
                $('#project_name').val(initialProjectName);
            }
        });

        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Herd\MDSJEDPR\resources\views/dashboard/PEPO/create.blade.php ENDPATH**/ ?>