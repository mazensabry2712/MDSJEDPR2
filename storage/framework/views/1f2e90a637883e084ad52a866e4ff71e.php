<?php $__env->startSection('title'); ?>
    PPOs Management | MDSJEDPR
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!-- Internal Data table css -->
    <link href="<?php echo e(URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css'), false); ?>" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css'), false); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css'), false); ?>" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css'), false); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css'), false); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/plugins/select2/css/select2.min.css'), false); ?>" rel="stylesheet">

    <style>
        /* تحسين شكل عرض التفاصيل */
        .ppo-details {
            max-width: 300px !important;
            min-width: 200px;
            white-space: normal !important;
        }

        .ppo-details .text-wrap {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 6px;
            border-left: 3px solid #007bff;
            font-size: 13px;
            line-height: 1.6;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-height: 120px;
            overflow-y: auto;
        }

        /* تحسين شكل الجدول */
        #example1 {
            width: 100% !important;
            table-layout: auto;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        /* تحسين العمود */
        #example1 td.ppo-details {
            padding: 10px 8px;
            vertical-align: top;
        }

        /* للشاشات الصغيرة */
        @media (max-width: 768px) {
            .ppo-details {
                max-width: 250px !important;
            }

            .ppo-details .text-wrap {
                font-size: 12px;
                padding: 6px 8px;
            }

            .card-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .btn-group {
                margin-bottom: 10px;
                margin-right: 0 !important;
            }
        }

        /* تحسين أزرار التصدير */
        .export-buttons .btn {
            transition: all 0.3s ease;
            margin: 0 1px;
            border-radius: 4px;
        }

        .export-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn-group .btn {
            border-radius: 0;
        }

        .btn-group .btn:first-child {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .btn-group .btn:last-child {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        /* إخفاء أزرار DataTables الافتراضية */
        .dt-buttons {
            display: none !important;
        }

        /* تحسين المودال */
        .modal-body textarea {
            resize: vertical;
            min-height: 100px;
        }

        .modal-body textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            .print-content, .print-content * {
                visibility: visible;
            }
            .print-content {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Project Purchase Orders</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ All PPOs</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
        </div>
    </div>
    <!-- breadcrumb -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error, false); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php
        $alerts = [
            'Add' => 'success',
            'Error' => 'danger',
            'delete' => 'danger',
            'Edit' => 'success',
        ];
    ?>

    <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(session()->has($key)): ?>
            <div class="alert alert-<?php echo e($type, false); ?> alert-dismissible fade show" role="alert">
                <strong><?php echo e(session()->get($key), false); ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">PPOs Management</h6>
                        </div>
                        <div>
                            <div class="d-flex align-items-center">

                                <!-- Export Buttons -->
                                <a href="<?php echo e(route('ppos.export.pdf'), false); ?>" target="_blank" class="btn btn-sm btn-danger btn-export-pdf mr-1" title="Export to PDF">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                                <a href="<?php echo e(route('ppos.export.excel'), false); ?>" class="btn btn-sm btn-success btn-export-excel mr-1" title="Export to Excel">
                                    <i class="fas fa-file-excel"></i> Excel
                                </a>
                                <a href="<?php echo e(route('ppos.print'), false); ?>" target="_blank" class="btn btn-sm btn-secondary btn-export-print mr-1" title="Print">
                                    <i class="fas fa-print"></i> Print
                                </a>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Add')): ?>
                                    <a class="btn btn-primary" href="<?php echo e(route('ppos.create'), false); ?>">
                                        <i class="fas fa-plus"></i> Add PPO
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Operations</th>
                                    <th>PR Number</th>
                                    <th>Project Name</th>
                                    <th>Category</th>
                                    <th>Supplier Name</th>
                                    <th>PO Number</th>
                                    <th>Value</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Updates</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $ppos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $x): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($index + 1, false); ?></td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" href="<?php echo e(route('ppos.show', $x->id), false); ?>"
                                                title="Show"><i class="las la-eye"></i></a>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit')): ?>
                                                <a class="btn btn-sm btn-info" href="<?php echo e(route('ppos.edit', $x->id), false); ?>"
                                                    title="Update"><i class="las la-pen"></i></a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete')): ?>
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="<?php echo e($x->id, false); ?>" data-name="<?php echo e($x->po_number, false); ?>"
                                                    data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                        class="las la-trash"></i></a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($x->project->pr_number ?? 'N/A', false); ?></td>
                                        <td><?php echo e($x->project->name ?? 'N/A', false); ?></td>
                                        <td>
                                            <?php
                                                // Get all categories for this PO Number
                                                $allCategories = \App\Models\Ppos::where('po_number', $x->po_number)
                                                    ->with('pepo:id,category')
                                                    ->get()
                                                    ->pluck('pepo.category')
                                                    ->filter()
                                                    ->unique()
                                                    ->implode(', ');
                                            ?>
                                            <span class="badge badge-primary-light" title="<?php echo e($allCategories, false); ?>">
                                                <?php echo e($allCategories ?: 'N/A', false); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($x->ds->dsname ?? 'N/A', false); ?></td>
                                        <td><?php echo e($x->po_number, false); ?></td>
                                        <td>
                                            <?php if($x->value): ?>
                                               <?php echo e(number_format($x->value, 2), false); ?> SAR
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($x->date ? $x->date->format('Y-m-d') : 'N/A', false); ?></td>
                                        <td class="ppo-details">
                                            <div class="text-wrap">
                                                <?php echo e($x->status ?? 'N/A', false); ?>

                                            </div>
                                        </td>
                                        <td class="ppo-details">
                                            <div class="text-wrap">
                                                <?php echo e($x->updates ?? 'No updates', false); ?>

                                            </div>
                                        </td>
                                        <td class="ppo-details">
                                            <div class="text-wrap">
                                                <?php echo e($x->notes ?? 'No notes', false); ?>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            <i class="las la-inbox" style="font-size: 48px; color: #ccc;"></i>
                                            <p class="text-muted">No PPOs found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- delete modal -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete PPO</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?php echo e(url('ppos/destroy'), false); ?>" method="post">
                    <?php echo e(method_field('delete'), false); ?>

                    <?php echo e(csrf_field(), false); ?>

                    <div class="modal-body">
                        <p>Are you sure about the deletion process?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="name" id="name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <!-- Internal Data tables -->
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jquery.dataTables.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jszip.min.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/vfs_fonts.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.html5.min.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.print.min.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js'), false); ?>"></script>
    <!--Internal  Datatable js -->
    <script src="<?php echo e(URL::asset('assets/js/table-data.js'), false); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/modal.js'), false); ?>"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })

        // Export to Excel Function
        function exportToExcel() {
            const button = event.target.closest('button');
            const originalHTML = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
            button.disabled = true;

            try {
                const dataTable = $('#example1').DataTable();
                let excelData = [];

                // Add headers
                excelData.push(['#', 'PR Number', 'Project Name', 'Category', 'Supplier Name', 'PO Number', 'Value', 'Date', 'Status', 'Updates']);

                // Get ALL data from DataTable (including paginated rows)
                dataTable.rows({ search: 'applied' }).every(function(rowIdx) {
                    const rowNode = this.node();
                    const cells = $(rowNode).find('td');

                    excelData.push([
                        cells.eq(0).text().trim(), // #
                        cells.eq(2).text().trim(), // PR Number
                        cells.eq(3).text().trim(), // Project Name
                        cells.eq(4).text().trim(), // Category
                        cells.eq(5).text().trim(), // Supplier Name
                        cells.eq(6).text().trim(), // PO Number
                        cells.eq(7).text().trim(), // Value
                        cells.eq(8).text().trim(), // Date
                        cells.eq(9).text().trim(), // Status
                        cells.eq(10).text().trim() // Updates
                    ]);
                });

                // Build Excel XML content with escaped characters
                let worksheet = '<ss:Worksheet ss:Name="Project Purchase Orders"><ss:Table>';

                excelData.forEach((row, rowIndex) => {
                    worksheet += '<ss:Row>';
                    row.forEach((cell) => {
                        // Escape special XML characters
                        const escapedCell = String(cell)
                            .replace(/&/g, '&amp;')
                            .replace(/</g, '&lt;')
                            .replace(/>/g, '&gt;')
                            .replace(/"/g, '&quot;')
                            .replace(/'/g, '&apos;');

                        if (rowIndex === 0) {
                            // Header row with style
                            worksheet += `<ss:Cell ss:StyleID="header"><ss:Data ss:Type="String">${escapedCell}</ss:Data></ss:Cell>`;
                        } else {
                            // Data rows
                            worksheet += `<ss:Cell><ss:Data ss:Type="String">${escapedCell}</ss:Data></ss:Cell>`;
                        }
                    });
                    worksheet += '</ss:Row>';
                });

                worksheet += '</ss:Table></ss:Worksheet>';

                // Build complete Excel XML with styles
                const excelXML = '<?xml version="1.0"?>' +
                    '<?mso-application progid="Excel.Sheet"?>' +
                    '<ss:Workbook xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' +
                    '<ss:Styles>' +
                    '<ss:Style ss:ID="header">' +
                    '<ss:Font ss:Bold="1" ss:Color="#FFFFFF"/>' +
                    '<ss:Interior ss:Color="#677EEA" ss:Pattern="Solid"/>' +
                    '</ss:Style>' +
                    '</ss:Styles>' +
                    worksheet +
                    '</ss:Workbook>';

                // Create blob and trigger download
                const blob = new Blob([excelXML], { type: 'application/vnd.ms-excel' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'PPOs_' + new Date().toISOString().split('T')[0] + '.xls';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);

            } catch (error) {
                console.error('Export error:', error);
                alert('Error exporting to Excel. Please try again.');
            } finally {
                button.innerHTML = originalHTML;
                button.disabled = false;
            }
        }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Herd\MDSJEDPR\resources\views/dashboard/PPOs/index.blade.php ENDPATH**/ ?>