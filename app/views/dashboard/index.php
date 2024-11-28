<?php Flasher::flash();?>
<div class="container-main">
  <h1 class="mt-4"><strong>Dashboard IQC</strong></h1>
  <p>
    Welcome,
    <?php echo $_SESSION['username']?>!
  </p>
  <div class="container-card m-4">
    <div class="row justify-content-center">
      <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
        <div class="text-center">
          <div class="card-progres-total" data-progres="Total Data">
            <h5 class="card-title">Total Lots</h5>
            <p class="card-text" id="totalLots"><?= $data['Total Data'] ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
        <div class="text-center">
          <div class="card-progres" data-progres="Normal Inspection">
            <h5 class="card-title">Normal Inspection</h5>
            <p class="card-text" id="normalInspection"><?= $data['Normal Inspection'] ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
        <div class="text-center">
          <div class="card-progres" data-progres="Easy Inspection">
            <h5 class="card-title">Easy Inspection</h5>
            <p class="card-text" id="easyInspection"><?= $data['Easy Inspection'] ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
        <div class="text-center">
          <div class="card-progres" data-progres="Skip Inspection">
            <h5 class="card-title">Skip Inspection</h5>
            <p class="card-text" id="skipInspection"><?= $data['Skip Inspection'] ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
        <div class="text-center">
          <div class="card-progres" data-progres="Tightened Inspection">
            <h5 class="card-title">Tightened Inspection</h5>
            <p class="card-text" id="tightenedInspection"><?= $data['Tightened Inspection'] ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
        <div class="text-center">
          <div class="card-progres" data-progres="In Progress">
            <h5 class="card-title">In Progress</h5>
            <p class="card-text" id="inProgress"><?= $data['In Progress']?></p>
          </div>
        </div>
      </div>
    </div>


    <div class="card-tabel mt-4">
      <h5 class="text-center mb-4"><strong>Data Entry</strong></h5>
      <table
        id="tbl_dashboard"
        class="table table-striped table-bordered table-responsive"
        style="width: 100%"
      >
        <thead class="thead-dark">
          <tr>
            <th>No</th>
            <th>Date</th>
            <th>Vendor</th>
            <th>Part Number</th>
            <!-- <th>File</th> -->
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="progressModalLabel">Detail Progres</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Table -->
            <table id="progressTable" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>Code Number</th>
                  <th>Vendor</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>



    <!-- Modal Detail -->
    <!-- <div
      class="modal fade"
      id="detailModal"
      tabindex="-1"
      aria-labelledby="detailModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content" id="modalContent">
          <div class="modal-header">
            <h5 class="modal-title" id="detailModalLabel">Detail QC</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <p><strong>Tanggal:</strong> <span id="detailTanggal"></span></p>
            <p><strong>Vendor:</strong> <span id="detailVendor"></span></p>
            <p>
              <strong>Part Number:</strong> <span id="detailPartNumber"></span>
            </p>
            <p><strong>Inspector:</strong> <span id="detailPerson"></span></p>
            <p><strong>Progress:</strong> <span id="detailProgres"></span></p>
            <h5 class="mt-4">Tanda Tangan</h5>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Approval</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <img
                      src="signature4.png"
                      alt="Signature Approval"
                      class="img-fluid"
                      width="100"
                    />
                    <br />
                    <small>Nama Approval</small>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
            <button
              type="button"
              class="btn btn-primary"
              id="downloadButton"
            >
              Download
            </button>
          </div>
        </div>
      </div> -->
      <div
        class="modal fade"
        id="detailModal"
        tabindex="-1"
        aria-labelledby="detailModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="detailModalLabel">Detail QC</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body" id="modalContent">
              <p><strong>Tanggal:</strong> <span id="detailTanggal">2024-11-21</span></p>
              <p><strong>Vendor:</strong> <span id="detailVendor">ANT PATRIOT</span></p>
              <p>
                <strong>Part Number:</strong> <span id="detailPartNumber">CC10050-0005C</span>
              </p>
              <p><strong>Inspector:</strong> <span id="detailPerson">Setiawan</span></p>
              <p><strong>Progress:</strong> <span id="detailProgres">Normal Inspection</span></p>
              <h5 class="mt-4">Tanda Tangan</h5>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Approval</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <img
                        src="signature4.png"
                        alt="Signature Approval"
                        class="img-fluid"
                        width="100"
                      />
                      <br />
                      <small>Nama Approval</small>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
              <button
                type="button"
                class="btn btn-primary"
                id="downloadButton"
              >
                Download
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
