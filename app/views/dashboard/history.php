<?php Flasher::flash();?>
<div class="container-main">
    <div class="container">
        <div class="row m-4">
            <div class="col-md-12 my-4">
                <h1 class="text-center"><strong>History QC</strong></h1>
            </div>
            <div class="card-tabel">
                <div class="container-button">
                    <!-- <a href="<?= BASEURL ?>/dashboard/deleteAll" class="badge bg-danger mx-2" style="text-decoration:none; color:white">Delete All</a> -->
                    <a href="<?= BASEURL ?>/dashboard/exportToExcel" class="badge bg-success" style="text-decoration:none; color:white">Export to Excel</a>
                </div>
                <table id="history" class="table table-striped table-bordered table-responsive" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Vendor</th>
                            <th>Part Number</th>
                            <th>Validation IQC</th>
                            <th>Progress</th>
                            <th>Inspection Result</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div
            class="modal fade"
            id="detailModal"
            tabindex="-1"
            aria-labelledby="detailModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Header Modal -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Data IQC</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>

                    <!-- Body Modal -->
                    <div class="modal-body" id="modalContent">
                        <div class="row justify-content-between align-items-center mb-4">
                            <!-- Logo -->
                            <div class="col-md-6">
                                <img
                                    src="<?php echo BASEURL ?>/images/samjin_logo.png"
                                    alt="Image QC"
                                    class="img-fluid"
                                    width="50%"
                                />
                            </div>
                            <!-- Title -->
                            <div class="col-md-6 text-md-end text-center">
                                <h5><strong>PROOF OF VALIDATION IQC</strong></h5>
                            </div>
                        </div>
                        <hr>

                        <!-- Detail Information -->
                        <div class="container">
                            <div class="row mb-2">
                                <div class="col-3"><strong>Inspection Date</strong></div>
                                <div class="col-8 ">: <span id="detailTanggal"></span></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3"><strong>Vendor</strong></div>
                                <div class="col-8">: <span id="detailVendor"></span></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3"><strong>Part Number</strong></div>
                                <div class="col-8">: <span id="detailPartNumber"></span></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3"><strong>Inspector</strong></div>
                                <div class="col-8">: <span id="detailPerson"></span></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3"><strong>Progress</strong></div>
                                <div class="col-8">: <span id="detailProgres"></span></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3"><strong>Inspection Result</strong></div>
                                <div class="col-8">: <span id="detailStatus"></span></div>
                            </div>
                        </div>


                        <!-- Signature Section -->
                        <p class="mt-4" style=" text-align: right;"><strong>Approval</strong></p>
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6">        
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered table-right">
                                    <thead>
                                        <tr>
                                            <th>Drafter</th>
                                            <th>Approved</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <img
                                                    src="<?php echo BASEURL ?>/images/ttd-pabambang.png"
                                                    alt="Signature Approval"
                                                    class="img-fluid"
                                                    width="60"
                                                />
                                                <br />
                                                <small>Bambang</small>
                                                <br />
                                                <small id="tanggalApprove"></small>
                                            </td>
                                            <td class="text-center">
                                                <img
                                                    src="<?php echo BASEURL ?>/images/ttd-pazaki.png"
                                                    alt="Signature Approval"
                                                    class="img-fluid"
                                                    width="50"
                                                />
                                                <br />
                                                <small>Zaki</small>
                                                <br />
                                                <small id="tanggalApprove2"></small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Modal -->
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            id="downloadButton"
                        >
                            Download
                        </button>
                        <a
                            id="downloadFile"
                            class="btn btn-success"
                            href=""
                            style="text-decoration: none; color: white;"
                        >
                        Attachment
                        </a>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>