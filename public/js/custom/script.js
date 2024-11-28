// Pemanggilan file DataTables di script.js
const datatableScript1 = document.createElement("script");
datatableScript1.src = `${BASEURL}/js/datatable/datatables.js`;
document.head.appendChild(datatableScript1);

const datatableScript2 = document.createElement("script");
datatableScript2.src = `${BASEURL}/js/datatable/datatables.min.js`;
document.head.appendChild(datatableScript2);


document.getElementById('btnSimpan').addEventListener('click', function() {
    event.preventDefault(); 
    var form = document.getElementById('formTambahData');
    if (form.checkValidity()) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan disimpan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Semua field wajib diisi!',
            confirmButtonText: 'OK'
        });
    }
});
document.getElementById('btnSimpan2').addEventListener('click', function() {
    event.preventDefault(); 
    var form = document.getElementById('formTambahData2');
    if (form.checkValidity()) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan disimpan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Semua field wajib diisi!',
            confirmButtonText: 'OK'
        });
    }
});

$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#example')) {
        var table = $('#example').DataTable({
            "paging": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[ 0, "asc" ]],
            "language": {
                "search": "Cari:",
                "searchPlaceholder": "Cari data di sini...",
                "lengthMenu": "Tampilkan: _MENU_",
            },
            "ajax": {
                "url": "<?php echo BASEURL; ?>/home/getDataLastOne",
                "dataSrc": ""
            },
            "columns": [
                { "data": null,  "className": "text-center", "render": function (data, type, row, meta) {
                    return meta.row + 1; // Menampilkan nomor urut
                }},
                { "data": "tanggal", "className": "text-center", "render": function(data, type, row) {
                    // Format tanggal menjadi dd-mm-yyyy
                    const date = new Date(data);
                    return date.toLocaleDateString('id-ID'); // Format tanggal lokal Indonesia
                }},
                { "data": "vendor",  "className": "text-center","render": function(data, type, row) {
                    // Tampilkan vendor dalam huruf kapital
                    return `<strong>${data.toUpperCase()}</strong>`;
                }},
                { "data": "code_number", "className": "text-center", "render": function(data, type, row) {
                    // Tambahkan iklan informasi untuk part number
                    return `<span class="badge bg-info text-dark">${data}</span>`;
                }},
                { "data": "nextProgres",  "className": "text-center","render": function(data, type, row) {
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
                        case 'Thigtened Inspection':
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

        // Reload data setiap 10 detik
        setInterval(function () {
            table.ajax.reload(null, false); // Reload tanpa refresh pagination
        }, 10000); // Interval 10 detik
    }
});

$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#history')) {
        var table = $('#history').DataTable({
            "paging": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[ 0, "asc" ]],
            "language": {
                "search": "Cari:",
                "searchPlaceholder": "Cari data di sini...",
                "lengthMenu": "Tampilkan: _MENU_",
            },
            "ajax": {
                "url": "<?php echo BASEURL; ?>/dashboard/historyData",
                "dataSrc": ""
            },
            "columns": [
                { "data": null,  "className": "text-center", "render": function (data, type, row, meta) {
                    return meta.row + 1; // Menampilkan nomor urut
                }},
                { "data": "tanggal", "className": "text-center", "render": function(data, type, row) {
                    // Format tanggal menjadi dd-mm-yyyy
                    const date = new Date(data);
                    return date.toLocaleDateString('id-ID'); // Format tanggal lokal Indonesia
                }},
                { "data": "vendor",  "className": "text-center","render": function(data, type, row) {
                    // Tampilkan vendor dalam huruf kapital
                    return `<strong>${data.toUpperCase()}</strong>`;
                }},
                { "data": "code_number", "className": "text-center", "render": function(data, type, row) {
                    // Tambahkan iklan informasi untuk part number
                    return `<span class="badge bg-info text-dark">${data}</span>`;
                }},
                { "data": "progres",  "className": "text-center","render": function(data, type, row) {
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
                        case 'Thigtened Inspection':
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

        // Reload data setiap 10 detik
        setInterval(function () {
            table.ajax.reload(null, false); // Reload tanpa refresh pagination
        }, 10000); // Interval 10 detik
    }
});

$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#tbl_dashboard')) {
        var table = $('#tbl_dashboard').DataTable({
            "paging": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "order": [[0, "asc"]],
            "ajax": {
                "url": "<?php echo BASEURL; ?>/dashboard/allDataAction",
                "dataSrc": ""
            },
            "columns": [
                { "data": null, "className": "text-center", "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }},
                { "data": "tanggal", "className": "text-center", "render": function(data) {
                    const date = new Date(data);
                    return date.toLocaleDateString('id-ID');
                }},
                { "data": "vendor", "className": "text-center", "render": function(data) {
                    return `<strong>${data.toUpperCase()}</strong>`;
                }},
                { "data": "code_number", "className": "text-center", "render": function(data) {
                    return `<span class="badge bg-info text-dark">${data}</span>`;
                }},
                { "data": "file", "className": "text-center", "render": function(data) {
                    return `<span class="badge bg-info text-dark">${data}</span>`;
                }},
                {
                    "data": null,
                    "className": "text-center",
                    "render": function (data, type, row) {
                        return `
                        <div class="row">
                            <div class="col">
                            
                                    <button class="btn btn-success btn-sm m-1 btn-approve" data-id="${row.id_qc}">Approve</button>
                                    <button class="btn btn-danger btn-sm m-1 btn-reject" data-id="${row.id_qc}">Reject</button>
                                    <button class="btn btn-info btn-sm m-1 btn-detail" data-id="${row.id_qc}">Detail</button>
          
                            </div>
                        </div>
                        `;
                    }
                }
            ]
        });
    }

    // Handle Approve button click
    $('#tbl_dashboard tbody').on('click', '.btn-approve', function () {
        var id_qc = $(this).data('id');
        $.ajax({
            url: "<?php echo BASEURL; ?>/dashboard/approve",
            type: "POST",
            data: { id: id_qc },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    alert('Data berhasil disetujui!');
                    table.ajax.reload(null, false); // Reload data table
                } else {
                    alert('Gagal menyetujui data: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Approve error:", status, error);
                console.log("Response Text:", xhr.responseText); // Log detail respons dari server
                alert('Terjadi kesalahan saat menyetujui data: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });

    // Handle Reject button click
    $('#tbl_dashboard tbody').on('click', '.btn-reject', function () {
        var id_qc = $(this).data('id');
        $.ajax({
            url: "<?php echo BASEURL; ?>/dashboard/reject",
            type: "POST",
            data: { id: id_qc },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    alert('Data berhasil ditolak!');
                    table.ajax.reload(null, false); // Reload data table
                } else {
                    alert('Gagal menolak data: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Reject error:", status, error);
                console.log("Response Text:", xhr.responseText); // Log detail respons dari server
                alert('Terjadi kesalahan saat menolak data: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });

    // Handle Detail button click
    $('#tbl_dashboard tbody').on('click', '.btn-detail', function () {
        var id_qc = $(this).data('id');
        $.ajax({
            url: '<?php echo BASEURL; ?>/dashboard/dataById/' + id_qc,
            type: 'GET',
            data: { id: id_qc },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data) {
                    var data = response.data;
                    $('#detailTanggal').text(data.tanggal || 'N/A');
                    $('#detailVendor').text(data.vendor || 'N/A');
                    $('#detailPartNumber').text(data.code_number || 'N/A');
                    $('#detailPerson').text(data.person || 'N/A');
                    $('#detailProgres').text(data.progres || 'N/A');
                    $('#detailModal').modal('show');
                } else {
                    alert(response.error || 'Terjadi kesalahan saat mengambil data detail');
                }
            },
            error: function(xhr, status, error) {
                console.error("Detail error:", status, error);
                console.log("Response Text:", xhr.responseText);
                alert('Gagal mengambil data detail: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });
});