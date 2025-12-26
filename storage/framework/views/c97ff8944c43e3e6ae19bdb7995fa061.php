<?php $__env->startSection('title'); ?>
    Project EPO | MDSJEDPR
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
        /* تحسين شكل الجدول */
        #example1 {
            width: 100% !important;
            table-layout: auto;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
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

        /* تحسين Badge الـ Margin */
        .badge {
            font-size: 0.875rem;
            padding: 0.35em 0.65em;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-header'); ?>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">External Purchase Orders</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ All EPOs</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

        </div>
    </div>
    <!-- breadcrumb -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    

    <?php if(session()->has('Add')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Success!</strong>
                    <div><?php echo e(session()->get('Add'), false); ?></div>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session()->has('Error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Error!</strong>
                    <div><?php echo e(session()->get('Error'), false); ?></div>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session()->has('delete')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-trash mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Deleted!</strong>
                    <div><?php echo e(session()->get('delete'), false); ?></div>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session()->has('edit')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-edit mr-3" style="font-size: 20px;"></i>
                <div>
                    <strong>Updated!</strong>
                    <div><?php echo e(session()->get('edit'), false); ?></div>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>


    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Epo Management</h6>
                        </div>
                        <div>
                            <div class="d-flex align-items-center">
                                <!-- Export buttons -->


                                <!-- Export Buttons -->
                                <a href="<?php echo e(route('epo.export.pdf'), false); ?>" target="_blank" class="btn btn-sm btn-danger btn-export-pdf mr-1">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                                <a href="<?php echo e(route('epo.export.excel'), false); ?>" class="btn btn-sm btn-success btn-export-excel mr-1">
                                    <i class="fas fa-file-excel"></i> Excel
                                </a>
                                <a href="<?php echo e(route('epo.print'), false); ?>" target="_blank" class="btn btn-sm btn-secondary btn-export-print mr-1">
                                    <i class="fas fa-print"></i> Print
                                </a>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Add')): ?>
                                    <a class="btn btn-primary" data-effect="effect-scale" href="<?php echo e(route('epo.create'), false); ?>">
                                        <i class="fas fa-plus"></i> Add Epo
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
                                    <th>Planned Cost</th>
                                    <th>Selling Price</th>
                                    <th>Margin (%)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $pepo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $x): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($i + 1, false); ?></td>
                                        <td style="white-space: nowrap;">
                                            
                                                <a class="btn btn-sm btn-primary" href="<?php echo e(route('epo.show', $x->id), false); ?>"
                                                    title="View"><i class="las la-eye"></i></a>
                                            

                                            
                                                <a class="btn btn-sm btn-info" href="<?php echo e(route('epo.edit', $x->id), false); ?>"

                                                    title="Update"><i class="las la-pen"></i></a>
                                            

                                            
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="<?php echo e($x->id, false); ?>" data-name="<?php echo e($x->category, false); ?>"
                                                    data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                        class="las la-trash"></i></a>
                                            
                                        </td>
                                        <td><?php echo e($x->project->pr_number ?? 'N/A', false); ?></td>
                                        <td><?php echo e($x->project->name ?? 'N/A', false); ?></td>
                                        <td><?php echo e($x->category ?? '-', false); ?></td>
                                        <td><?php echo e(number_format($x->planned_cost, 2), false); ?></td>
                                        <td><?php echo e(number_format($x->selling_price, 2), false); ?></td>
                                        <td>
                                            <?php if($x->margin !== null): ?>
                                                <span class="badge badge-<?php echo e($x->margin >= 0.2 ? 'success' : ($x->margin >= 0.1 ? 'warning' : 'danger'), false); ?>">
                                                    <?php echo e(number_format($x->margin * 100, 2), false); ?>%
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No EPO records found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>









    <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="epo/destroy" method="post">
                    <?php echo e(method_field('delete'), false); ?>

                    <?php echo e(csrf_field(), false); ?>

                    <div class="modal-body">
                        <p> Are you sure about the deletion process?</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="name" id="name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
            </div>
            </form>
        </div>
    </div>



    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
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


    <!-- SheetJS for Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        // Delete Modal
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })

    // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Export to Excel Function
        function exportToExcel() {
            const button = event.target.closest('button');
            const originalHTML = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
            button.disabled = true;

            try {
                const dataTable = $('#example').DataTable();
                let excelData = [];

                // Headers
                excelData.push([
                    '#',
                    'PR Number',
                    'Project Name',
                    'Category',
                    'Planned Cost',
                    'Selling Price',
                    'Margin (%)'
                ]);

                // Extract data from ALL rows (including paginated)
                dataTable.rows({ search: 'applied' }).every(function(rowIdx) {
                    const rowNode = this.node();
                    const cells = $(rowNode).find('td');

                    // Extract margin from badge
                    const marginText = cells.eq(7).find('.badge').text().trim() || cells.eq(7).text().trim();

                    excelData.push([
                        cells.eq(0).text().trim(),
                        cells.eq(2).text().trim(),
                        cells.eq(3).text().trim(),
                        cells.eq(4).text().trim(),
                        cells.eq(5).text().trim(),
                        cells.eq(6).text().trim(),
                        marginText
                    ]);
                });

                // Build SpreadsheetML XML
                let excelXML = '<?xml version="1.0" encoding="UTF-8"?>' +
                    '<?mso-application progid="Excel.Sheet"?>' +
                    '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" ' +
                    'xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' +
                    '<Worksheet ss:Name="Project EPO">' +
                    '<Table>';

                // Add header row with styling
                excelXML += '<Row>';
                excelData[0].forEach(header => {
                    excelXML += '<Cell><Data ss:Type="String">' + escapeXML(header) + '</Data></Cell>';
                });
                excelXML += '</Row>';

                // Add data rows
                for (let i = 1; i < excelData.length; i++) {
                    excelXML += '<Row>';
                    excelData[i].forEach((cell, index) => {
                        const cellValue = cell || '';
                        excelXML += '<Cell><Data ss:Type="String">' + escapeXML(cellValue) + '</Data></Cell>';
                    });
                    excelXML += '</Row>';
                }

                excelXML += '</Table></Worksheet></Workbook>';

                // Download
                const blob = new Blob([excelXML], { type: 'application/vnd.ms-excel' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'PEPO_' + new Date().toISOString().split('T')[0] + '.xls';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);

            } catch (error) {
                console.error('Export error:', error);
                alert('Error exporting to Excel. Please try again.');
            } finally {
                button.innerHTML = originalHTML;
                button.disabled = false;
            }
        }

        // Helper function to escape XML special characters
        function escapeXML(str) {
            if (str === null || str === undefined) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&apos;');
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Herd\MDSJEDPR\resources\views/dashboard/PEPO/index.blade.php ENDPATH**/ ?>