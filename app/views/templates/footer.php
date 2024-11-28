<footer class="footer bg-dark text-white text-center p-4">
    <p class="mb-0">&copy; <?= date('Y'); ?> PT. Samjin || Created by PI Team ❤</p>
</footer>

<script src="<?= BASEURL ?>/js/jquery-3.7.1.min.js"></script>
<script src="<?= BASEURL ?>/js/bootstrap/bootstrap.js"></script>
<script src="<?= BASEURL ?>/js/datatable/datatables.js"></script>
<script src="<?= BASEURL ?>/js/datatable/datatables.min.js"></script>
<script src="<?= BASEURL ?>/js/select2/select2.min.js"></script>
<script src="<?= BASEURL ?>/js/html2pdf.bundle.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi Select2 pada dropdown
    $('#vendor').select2({
        placeholder: "Choose Vendor",
        allowClear: true,
        dropdownParent: $('#tambahModal') // Mengatur parent dropdown ke modal
    });

    $('#code_number').select2({
        placeholder: "Choose Part Number",
        allowClear: true,
        dropdownParent: $('#tambahModal') // Mengatur parent dropdown ke modal
    });
    });

</script>


<!-- Button Simpan -->
<script>
    document.getElementById('btnSimpan').addEventListener('click', function() {
        event.preventDefault(); 
        var form = document.getElementById('formTambahData');
        if (form.checkValidity()) {
            Swal.fire({
                title: 'Are You Sure?',
                text: "Data Will Be Saved!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Save!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'All fields are required!',
                confirmButtonText: 'OK'
            });
        }
    });
    document.getElementById('btnSimpan2').addEventListener('click', function() {
        event.preventDefault(); 
        var form = document.getElementById('formTambahData2');
        if (form.checkValidity()) {
            Swal.fire({
                title: 'Are You Sure?',
                text: "Data Will Be Saved!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Save!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'All fields are required!',
                confirmButtonText: 'OK'
            });
        }
    });

</script>

<script>
// Tabel Inspector (Home)
$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#example')) {
        var table = $('#example').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[ 0, "asc" ]],
            "language": {
                "search": "Search:",
                "searchPlaceholder": "Search data here...",
                "lengthMenu": "Show: _MENU_",
            },
            "ajax": {
                "url": "<?php echo BASEURL; ?>/home/getDataLastOne",
                "dataSrc": ""
            },
            "columns": [
                { "data": null,  "className": "text-center", "orderable": false, "render": function (data, type, row, meta) {
                    return meta.row + 1; // Menampilkan nomor urut
                }},
                { "data": "tanggal", "className": "text-center", "orderable": true, "render": function(data, type, row) {
                    return data;
                }},
                { "data": "vendor",  "className": "text-center", "orderable": true, "render": function(data, type, row) {
                    // Tampilkan vendor dalam huruf kapital
                    return `<strong>${data.toUpperCase()}</strong>`;
                }},
                { "data": "code_number", "className": "text-center", "orderable": false, "render": function(data, type, row) {
                    // Tambahkan iklan informasi untuk part number
                    return `<span class="badge bg-info text-dark">${data}</span>`;
                }},
                { "data": "nextProgres",  "className": "text-center", "orderable": false,"render": function(data, type, row) {
                    // Tampilkan label warna berbeda berdasarkan status progress
                    let colorClass = '';
                    switch(data) {
                        case 'Skip Inspection':
                            colorClass = 'bg-success';
                            break;
                        case 'Easy Inspection':
                            colorClass = 'bg-warning';
                            break;
                        case 'Normal Inspection':
                            colorClass = 'bg-primary';
                            break;
                        case 'Tightened Inspection':
                            colorClass = 'bg-danger';
                            break;
                        default:
                            colorClass = 'bg-secondary';
                            break;
                    }
                    return `<span class="badge ${colorClass}">${data}</span>`;
                }},
                // { "data": null, "className": "text-center", "orderable": false, "render": function(data, type, row) {
                //     // Logika untuk status persetujuan
                //     if (
                //         (['Normal Inspection', 'Easy Inspection', 'Skip Inspection', 'Tightened Inspection'].includes(row.progres) && row.is_reject == 1)
                //     ) {
                //         return 'Rejected';
                //     } else if (
                //         ['Normal Inspection', 'Easy Inspection', 'Skip Inspection', 'Tightened Inspection'].includes(row.progres)
                //     ) {
                //         return 'Approved';
                //     } else if (row.is_approve == 1 && row.is_reject == 1) {
                //         return 'Approved';
                //     } else {
                //         return 'Not Yet Approved';
                //     }
                // }}
            ]
        });

        // Reload data setiap 10 detik
        setInterval(function () {
            table.ajax.reload(null, false); // Reload tanpa refresh pagination
        }, 10000); // Interval 10 detik
    }
});

// Tabel Tracking
$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#tracking')) {
        var table = $('#tracking').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[ 0, "asc" ]],
            "language": {
                "search": "Search:",
                "searchPlaceholder": "Search data here...",
                "lengthMenu": "Show: _MENU_",
            },
            "ajax": {
                "url": "<?php echo BASEURL; ?>/dashboard/getDataLastOne",
                "dataSrc": ""
            },
            "columns": [
                { "data": null, "className": "text-center", "orderable": false,"render": function (data, type, row, meta) {
                    return meta.row + 1;
                }},
                { "data": "tanggal", "className": "text-center", "orderable": true,"render": function(data) {
                    return data;
                }},
                { "data": "vendor", "className": "text-center", "orderable": true, "render": function(data) {
                    return `<strong>${data.toUpperCase()}</strong>`;
                }},
                { "data": "code_number", "className": "text-center", "orderable": false, "render": function(data) {
                    return `<span class="badge bg-info text-dark">${data}</span>`;
                }},
                { "data": "nextProgres", "className": "text-center", "orderable": false, "render": function(data, type, row) {
                    let colorClass = '';
                    let rejectButton = ''; // tombol reject yang akan disembunyikan
                    switch(data) {
                        case 'Skip Inspection':
                            colorClass = 'bg-success';
                            rejectButton = `<button class="badge bg-warning text-dark m-1 btn-change-status d-none" data-id="${row.id_qc}">Reject</button>`;
                            return `
                                <span class="badge ${colorClass} btn-skip" data-id="${row.id_qc}">${data}</span>
                                ${rejectButton}
                            `;
                        case 'Easy Inspection':
                            colorClass = 'bg-warning';
                            break;
                        case 'Normal Inspection':
                            colorClass = 'bg-primary';
                            break;
                        case 'Tightened Inspection':
                            colorClass = 'bg-danger';
                            break;
                        default:
                            colorClass = 'bg-secondary';
                            break;
                    }
                    return `<span class="badge ${colorClass}">${data}</span>`;
                }}
            ]
        });

        // Handle Skip Inspection click to show Reject button
        $('#tracking tbody').on('click', '.btn-skip', function () {
            var id_qc = $(this).data('id');
            // Show the corresponding Reject button
            $(this).siblings(`.btn-change-status[data-id="${id_qc}"]`).removeClass('d-none');
        });

        // Handle Reject button click
        $('#tracking tbody').on('click', '.btn-change-status', function () {
            var id_qc = $(this).data('id');
            $.ajax({
                url: "<?php echo BASEURL; ?>/dashboard/reject",
                type: "POST",
                data: { id: id_qc },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        alert('Data successfully rejected!');
                        table.ajax.reload(null, false);
                    } else {
                        alert('Failed to reject data: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Reject error:", status, error);
                    console.log("Response Text:", xhr.responseText);
                    alert('An error occurred while rejecting data: ' + xhr.status + ' ' + xhr.statusText);
                }
            });
        });

        setInterval(function () {
            table.ajax.reload(null, false);
        }, 10000);
    }
});

// Tabel History
$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#history')) {
        var table = $('#history').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[ 0, "asc" ]],
            "language": {
                "search": "Search:",
                "searchPlaceholder": "Search data here...",
                "lengthMenu": "Show: _MENU_",
            },
            "ajax": {
                "url": "<?php echo BASEURL; ?>/dashboard/historyData",
                "dataSrc": ""
            },
            "columns": [
                { "data": null,  "className": "text-center", "orderable": false, "render": function (data, type, row, meta) {
                    return meta.row + 1; // Menampilkan nomor urut
                }},
                { "data": "tanggal", "className": "text-center", "orderable": true, "render": function(data, type, row) {
                    return data;
                }},
                { "data": "vendor",  "className": "text-center", "orderable": true, "render": function(data, type, row) {
                    // Tampilkan vendor dalam huruf kapital
                    return `<strong>${data.toUpperCase()}</strong>`;
                }},
                { "data": "code_number", "className": "text-center", "orderable": false, "render": function(data, type, row) {
                    // Tambahkan iklan informasi untuk part number
                    return `<span class="badge bg-info text-dark">${data}</span>`;
                }},
                { "data": null, "className": "text-center", "orderable": false, "render": function(data, type, row) {
                    // const downloadUrl = `<?php echo BASEURL; ?>/dashboard/download/${encodeURIComponent(data)}`;

                    // console.log("Generated download URL:", downloadUrl);
                    return `
                        <button class="badge bg-info m-1 btn-detail" data-id="${row.id_qc}">Download</button> 
                        `;
                        
                }},
                { "data": "progres",  "className": "text-center", "orderable": false, "render": function(data, type, row) {
                    // Tampilkan label warna berbeda berdasarkan status progress
                    let colorClass = '';
                    switch(data) {
                        case 'Skip Inspection':
                            colorClass = 'bg-success';
                            break;
                        case 'Easy Inspection':
                            colorClass = 'bg-warning';
                            break;
                        case 'Normal Inspection':
                            colorClass = 'bg-primary';
                            break;
                        case 'Tightened Inspection':
                            colorClass = 'bg-danger';
                            break;
                        default:
                            colorClass = 'bg-secondary';
                            break;
                    }
                    return `<span class="badge ${colorClass}">${data}</span>`;
                }},
                { "data": null, "className": "text-center", "orderable": false, "render": function(data, type, row) {
                    if (row.is_approve === 1){
                        return `<span class="badge bg-success">Approved</span>`;
                    } else {
                        return `<span class="badge bg-danger">Rejected</span>`;
                    }                        
                }},
            ]
        });

        // Reload data setiap 10 detik
        setInterval(function () {
            table.ajax.reload(null, false); // Reload tanpa refresh pagination
        }, 10000); // Interval 10 detik
    }
    $('#history tbody').on('click', '.btn-detail', function () {
        var id_qc = $(this).data('id');
        console.log('History');
        console.log(id_qc);
        $.ajax({
            url: '<?php echo BASEURL; ?>/dashboard/dataById/' + id_qc,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success && response.data) {
                    var data = response.data;

                    // Definisikan qcData berdasarkan data dari server
                    qcData = {
                        file: data.file || 'N/A',
                        tanggal: data.tanggal || 'N/A',
                        vendor: data.vendor || 'N/A',
                        partNumber: data.code_number || 'N/A',
                        inspector: data.person || 'N/A',
                        progres: data.progres || 'N/A',
                        status: data.is_approve,
                        tanggalApprove: data.tanggal_approve
                    };

                    if (qcData.status == 1) {
                        qcData.status = 'Approved';
                    } else {
                        qcData.status = 'Rejected';
                    }

                    // Isi data ke modal
                    $('#detailTanggal').text(qcData.tanggal);
                    $('#detailVendor').text(qcData.vendor);
                    $('#detailPartNumber').text(qcData.partNumber);
                    $('#detailPerson').text(qcData.inspector);
                    $('#detailProgres').text(qcData.progres);
                    $('#detailStatus').text(qcData.status);
                    $('#tanggalApprove').text(qcData.tanggalApprove);
                    $('#tanggalApprove2').text(qcData.tanggalApprove);

                    // Tampilkan modal
                    $('#detailModal').modal('show');
                } else {
                    alert(response.error || 'An error occurred while retrieving detailed data');
                }
            },
            error: function (xhr, status, error) {
                console.error("Detail error:", status, error);
                console.log("Response Text:", xhr.responseText);
                alert('Failed to fetch detailed data: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });

    const downloadButton = document.getElementById('downloadFile');

    if (downloadButton) {
        downloadButton.addEventListener("click", (e) => {
            if (!qcData || !qcData.file) {
                alert('Data file tidak tersedia.');
                e.preventDefault(); // Cegah pengalihan jika data tidak tersedia
                return;
            }

            // Tentukan URL file yang akan diunduh
            const data = qcData.file;
            const downloadUrl = `<?php echo BASEURL; ?>/dashboard/download/${encodeURIComponent(data)}`;

            console.log("Generated download URL:", downloadUrl);

            // Set href pada tombol agar langsung mendownload file
            downloadButton.setAttribute('href', downloadUrl);
        });
    }



    document.getElementById("downloadButton").addEventListener("click", () => {
        const modalContent = document.getElementById("modalContent");
        const options = {
        margin: 0.5,
        filename: `QC_Detail_${qcData.partNumber}.pdf`,
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "in", format: "A4", orientation: "portrait" },
        };
        html2pdf().set(options).from(modalContent).save();
    });
});

// Tabel Dashboard
const BASEURL = "<?= BASEURL ?>";

$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#tbl_dashboard')) {
        var table = $('#tbl_dashboard').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "language": {
                "search": "Search:",
                "searchPlaceholder": "Search data here...",
                "lengthMenu": "Show: _MENU_",
            },
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[0, "asc"]],
            "ajax": {
                "url": "<?php echo BASEURL; ?>/dashboard/allDataAction",
                "dataSrc": ""
            },
            "columns": [
                { "data": null, "className": "text-center", "orderable": false,"render": function (data, type, row, meta) {
                    return meta.row + 1;
                }},
                { "data": "tanggal", "className": "text-center", "orderable": true, "render": function(data) {
                    return data;
                }},
                { "data": "vendor", "className": "text-center", "orderable": true, "render": function(data) {
                    return `<strong>${data.toUpperCase()}</strong>`;
                }},
                { "data": "code_number", "className": "text-center", "orderable": false,"render": function(data) {
                    return `<span class="badge bg-info text-dark">${data}</span>`;
                }},
                // { "data": "file", "className": "text-center", "orderable": false, "render": function(data) {
                //     const downloadUrl = `<?php echo BASEURL; ?>/dashboard/download/${encodeURIComponent(data)}`;

                //     // Debug URL di console browser
                //     console.log("Generated download URL:", downloadUrl);
                //     return `
                //         <a href="<?php echo BASEURL; ?>/dashboard/download/${encodeURIComponent(data)}" 
                //         class="badge bg-dark text-light" 
                //         style="text-decoration: none; color: white">
                //         Download
                //         </a>`;
                        
                // }},
                {
                    "data": null,
                    "className": "text-center",
                    "render": function (data, type, row) {
                        return `
                        <div class="row">
                            <div class="col">
                                <button class="badge bg-success m-1 btn-approve" data-id="${row.id_qc}">Approve</button>
                            </div>
                        </div>
                        `;
                    }
                }
            ]
        });

        setInterval(function () {
            table.ajax.reload(null, false);
        }, 10000); // Interval 10 detik
    }

    $('#tbl_dashboard tbody').on('click', '.btn-approve', function () {
        var id_qc = $(this).data('id');
        $.ajax({
            url: "<?php echo BASEURL; ?>/dashboard/approve",
            type: "POST",
            data: { id: id_qc },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    alert('Data successfully approved!');
                    table.ajax.reload(null, false); // Reload data table
                } else {
                    alert('Failed to approve data: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Approve error:", status, error);
                console.log("Response Text:", xhr.responseText); // Log detail respons dari server
                alert('An error occurred while approving the data: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });

});

// Tabel Progres
$('.card-progres').on('click', function () {
    var progres = $(this).data('progres');
    $('#progressModal').modal('show');
    $('#progressModalLabel').text(`Detail Progres: ${progres}`);

    $('#progressTable').DataTable().clear().destroy();
    $.ajax({
        url: `${BASEURL}/dashboard/getProgresDetails`,
        type: 'GET',
        data: { progres: progres },
        dataType: 'json',
        success: function (data) {
            console.log('Response:', data);

            if (data && data.length > 0) {
                $('#progressTable').DataTable({
                    data: data,
                    columns: [
                        { data: 'code_number' }, 
                        { data: 'vendor' }
                    ],
                    destroy: true,
                    responsive: true,
                    paging: true,
                    searching: true,
                    ordering: true,
                    lengthChange: true, 
                    language: {
                        search: "Search:",
                        searchPlaceholder: "Search data here...",
                        lengthMenu: "Show: _MENU_",
                    },
                });
            } else {
                $('#progressTable').DataTable({
                    data: [],
                    columns: [
                        { data: 'code_number', defaultContent: "No data available" },
                        { data: 'vendor', defaultContent: "No data available" }
                    ],
                    destroy: true,
                    responsive: true,
                    paging: true,
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            $('#progressTable').DataTable({
                data: [],
                columns: [
                    { data: 'code_number', defaultContent: "Failed to load data" },
                    { data: 'vendor', defaultContent: "" }
                ],
                destroy: true,
                responsive: true,
                paging: true,
            });
        }
    });
});

// Tabel Inspector

$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#tbl_inspector')) {
        var table = $('#tbl_inspector').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "language": {
                "search": "Search:",
                "searchPlaceholder": "Search data here...",
                "lengthMenu": "Show: _MENU_",
            },
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[0, "asc"]],
            "ajax": {
                "url": "<?php echo BASEURL; ?>/home/allDataAction",
                "dataSrc": ""
            },
            "columns": [
                { "data": null, "className": "text-center", "orderable": false,"render": function (data, type, row, meta) {
                    return meta.row + 1;
                }},
                { "data": "tanggal", "className": "text-center", "orderable": true, "render": function(data) {
                    return data;
                }},
                { "data": "vendor", "className": "text-center", "orderable": true, "render": function(data) {
                    return `<strong>${data.toUpperCase()}</strong>`;
                }},
                { "data": "code_number", "className": "text-center", "orderable": false,"render": function(data) {
                    return `<span class="badge bg-info text-dark">${data}</span>`;
                }},
                { "data": "person", "className": "text-center", "orderable": false,"render": function(data) {
                    return `<span class="text-dark"><strong>${data}</strong></span>`;
                }},
                {
                    "data": null,
                    "className": "text-center",
                    "render": function (data, type, row) {
                        return `
                        <div class="row">
                            <div class="col">
                                    <button class="badge bg-success m-1 btn-approve" data-id="${row.id_qc}">Approve</button>
                                    <button class="badge bg-danger m-1 btn-reject" data-id="${row.id_qc}">Reject</button>          
                            </div>
                        </div>
                        `;
                    }
                }
            ]
        });

        setInterval(function () {
            table.ajax.reload(null, false);
        }, 5000); // Interval 10 detik
    }

    $('#tbl_inspector tbody').on('click', '.btn-approve', function () {
        var id_qc = $(this).data('id');
        $.ajax({
            url: "<?php echo BASEURL; ?>/home/approve",
            type: "POST",
            data: { id: id_qc },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    alert('Data successfully approved!');
                    table.ajax.reload(null, false); // Reload data table
                } else {
                    alert('Failed to approve data: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Approve error:", status, error);
                console.log("Response Text:", xhr.responseText); // Log detail respons dari server
                alert('An error occurred while approving the data: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });

    // Handle Reject button click
    $('#tbl_inspector tbody').on('click', '.btn-reject', function () {
        var id_qc = $(this).data('id');
        $.ajax({
            url: "<?php echo BASEURL; ?>/home/reject",
            type: "POST",
            data: { id: id_qc },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    alert('Data successfully rejected!');
                    table.ajax.reload(null, false); // Reload data table
                } else {
                    alert('Failed to reject data: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Reject error:", status, error);
                console.log("Response Text:", xhr.responseText); // Log detail respons dari server
                alert('An error occurred while rejecting data: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });

    // Handle Detail button click
    // $('#tbl_inspector tbody').on('click', '.btn-detail', function () {
    //     var id_qc = $(this).data('id');
    //     $.ajax({
    //         url: '<?php echo BASEURL; ?>/dashboard/dataById/' + id_qc,
    //         type: 'GET',
    //         data: { id: id_qc },
    //         dataType: 'json',
    //         success: function(response) {
    //             if (response.success && response.data) {
    //                 var data = response.data;
    //                 $('#detailTanggal').text(data.tanggal || 'N/A');
    //                 $('#detailVendor').text(data.vendor || 'N/A');
    //                 $('#detailPartNumber').text(data.code_number || 'N/A');
    //                 $('#detailPerson').text(data.person || 'N/A');
    //                 $('#detailProgres').text(data.progres || 'N/A');
    //                 $('#detailModal').modal('show');
    //             } else {
    //                 alert(response.error || 'Terjadi kesalahan saat mengambil data detail');
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             console.error("Detail error:", status, error);
    //             console.log("Response Text:", xhr.responseText);
    //             alert('Gagal mengambil data detail: ' + xhr.status + ' ' + xhr.statusText);
    //         }
    //     });
    // });
});

// Tabel History_Inspector
$(document).ready(function () {
    // Cek apakah DataTable sudah diinisialisasi
    if (!$.fn.DataTable.isDataTable("#history_inspector")) {
        var table = $("#history_inspector").DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"],
            ],
            order: [[0, "asc"]],
            language: {
                search: "Search:",
                searchPlaceholder: "Search data here...",
                lengthMenu: "Show: _MENU_",
            },
            ajax: {
                url: "<?php echo BASEURL; ?>/home/historyData",
                dataSrc: "",
            },
            columns: [
                {
                    data: null,
                    className: "text-center",
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1; // Menampilkan nomor urut
                    },
                },
                {
                    data: "tanggal",
                    className: "text-center",
                    orderable: true,
                    render: function (data) {
                        return data;
                    },
                },
                {
                    data: "vendor",
                    className: "text-center",
                    orderable: true,
                    render: function (data) {
                        // Tampilkan vendor dalam huruf kapital
                        return `<strong>${data.toUpperCase()}</strong>`;
                    },
                },
                {
                    data: "code_number",
                    className: "text-center",
                    orderable: false,
                    render: function (data) {
                        // Tambahkan label informasi untuk part number
                        return `<span class="badge bg-info text-dark">${data}</span>`;
                    },
                },
                {
                    data: "progres",
                    className: "text-center",
                    orderable: false,
                    render: function (data) {
                        // Tampilkan label warna berbeda berdasarkan status progress
                        let colorClass = "";
                        switch (data) {
                            case "Skip Inspection":
                                colorClass = "bg-success";
                                break;
                            case "Easy Inspection":
                                colorClass = "bg-warning";
                                break;
                            case "Normal Inspection":
                                colorClass = "bg-primary";
                                break;
                            case "Tightened Inspection":
                                colorClass = "bg-danger";
                                break;
                            default:
                                colorClass = "bg-secondary";
                                break;
                        }
                        return `<span class="badge ${colorClass}">${data}</span>`;
                    },
                },
                {
                    data: null,
                    className: "text-center",
                    orderable: false,
                    render: function (data, type, row) {
                        // Kondisi tombol berdasarkan approve_admin
                        if (row.approve_admin === 1) {
                            return `
                                <button class="badge bg-info m-1 btn-detail" data-id="${row.id_qc}">Approved</button>`;
                        } else {
                            return `
                                <span class="badge bg-dark">Not Yet Approved</span>
                                `;
                        }
                    },
                },
            ],
        });

        // Reload data setiap 10 detik
        setInterval(function () {
            table.ajax.reload(null, false); // Reload tanpa refresh pagination
        }, 10000); // Interval 10 detik
    }

    // Event handler untuk tombol detail
    $("#history_inspector tbody").on("click", ".btn-detail", function () {
        var id_qc = $(this).data("id");
        console.log("History ID:", id_qc);
        $.ajax({
            url: '<?php echo BASEURL; ?>/dashboard/dataById/' + id_qc,
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.success && response.data) {
                    var data = response.data;

                    // Definisikan qcData berdasarkan data dari server
                    qcData = {
                        file: data.file || "N/A",
                        tanggal: data.tanggal || "N/A",
                        vendor: data.vendor || "N/A",
                        partNumber: data.code_number || "N/A",
                        inspector: data.person || "N/A",
                        progres: data.progres || "N/A",
                        status: data.is_approve,
                    };

                    if (qcData.status === 1) {
                        $("#detailStatus").text("Approved");
                    } else {
                        $("#detailStatus").text("Rejected");
                    }

                    // Isi data ke modal
                    $("#detailTanggal").text(qcData.tanggal);
                    $("#detailVendor").text(qcData.vendor);
                    $("#detailPartNumber").text(qcData.partNumber);
                    $("#detailPerson").text(qcData.inspector);
                    $("#detailProgres").text(qcData.progres);

                    // Tampilkan modal
                    $("#detailModal").modal("show");
                } else {
                    alert(response.error || "An error occurred while retrieving detailed data.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Detail error:", status, error);
                console.log("Response Text:", xhr.responseText);
                alert("Failed to fetch detailed data: " + xhr.status + " " + xhr.statusText);
            },
        });
    });

    // Event handler untuk tombol download file di modal
    const downloadButton = document.getElementById("downloadFile");

    if (downloadButton) {
        downloadButton.addEventListener("click", (e) => {
            if (!qcData || !qcData.file) {
                alert("Data file tidak tersedia.");
                e.preventDefault(); // Cegah pengalihan jika data tidak tersedia
                return;
            }

            // Tentukan URL file yang akan diunduh
            const data = qcData.file;
            const downloadUrl = `<?php echo BASEURL; ?>/dashboard/download/${encodeURIComponent(data)}`;

            console.log("Generated download URL:", downloadUrl);

            // Set href pada tombol agar langsung mendownload file
            downloadButton.setAttribute("href", downloadUrl);
        });
    }

    // Uncomment untuk fungsi download PDF dari modal
    $("#downloadButton").on("click", function () {
        const modalContent = document.getElementById("modalContent");
        const options = {
            margin: 0.5,
            filename: `QC_Detail_${qcData.partNumber}.pdf`,
            image: { type: "jpeg", quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: "in", format: "A4", orientation: "portrait" },
        };
        html2pdf().set(options).from(modalContent).save();
    });
});





</script>

<!-- Data Count Progres Realtime -->
<script>
  function fetchCountProgres() {
    $.ajax({
      url: "<?= BASEURL ?>/dashboard/getCountProgresData", 
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response) {
          $('#totalLots').text(response.inspectionCounts['Total Data']);
          $('#normalInspection').text(response.inspectionCounts['Normal Inspection']);
          $('#easyInspection').text(response.inspectionCounts['Easy Inspection']);
          $('#skipInspection').text(response.inspectionCounts['Skip Inspection']);
          $('#tightenedInspection').text(response.inspectionCounts['Tightened Inspection']);
          $('#inProgress').text(response.inspectionCounts['In Progress']);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching realtime data:", status, error);
      }
    });
  }

  setInterval(fetchCountProgres, 1000);
</script>

</body>
</html>