<?php Flasher::flash();?>
<style>
  .select2-container {
    z-index: 1055;
  }
</style>

<div class="container-main mt-4">
  <h1 class="text-center"><strong>IQC-Inspector</strong></h1>
  <button
    class="btn btn-primary mb-4"
    data-bs-toggle="modal"
    data-bs-target="#tambahModal"
  >
    Add Data
  </button>
  <button
    class="btn btn-primary mb-4"
    data-bs-toggle="modal"
    data-bs-target="#tambahModal2"
  >
    Add Vendor
  </button>
  <!-- <div class="row">
        <div class="col-lg-6 my-4">
            <div class="card-input">
            <h4 class="text-center"><strong>Tambah Data</strong></h4>
            <form id="formTambahData" action="<?= BASEURL; ?>/home/insert" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="vendor" class="form-label">Vendor</label>
                        <input type="text" class="form-control" id="vendor" name="vendor" required>
                    </div>
                    <div class="mb-3">
                        <label for="code_number" class="form-label">Part Number</label>
                        <input type="text" class="form-control" id="code_number" name="code_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
        <div class="col-lg-6 my-4">
            <div class="card-input">
            <h4 class="text-center"><strong>Tambah Vendor</strong></h4>
            <form id="formTambahData" action="<?= BASEURL; ?>/home/insert" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="vendor" class="form-label">Vendor</label>
                        <input type="text" class="form-control" id="vendor" name="vendor" required>
                    </div>
                    <div class="mb-3">
                        <label for="code_number" class="form-label">Part Number</label>
                        <input type="text" class="form-control" id="code_number" name="code_number" required>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div> -->
  <?php include 'tabel.php'; ?>
</div>

<!-- Modal Tambah Data -->
<div
  class="modal fade"
  id="tambahModal"
  tabindex="-1"
  aria-labelledby="tambahModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Add Data IQC</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form
          id="formTambahData"
          action="<?= BASEURL; ?>/home/addQcData"
          method="POST"
          enctype="multipart/form-data"
        >
          <input type="hidden" name="form_type" value="qc_data" />
          <div class="mb-3">
            <label for="tanggal" class="form-label">Date</label>
            <input
              type="date"
              class="form-control"
              id="tanggal"
              name="tanggal"
              required
            />
          </div>
          <div class="mb-3">
            <div class="row">
              <label for="vendor" class="form-label">Vendor</label>
            </div>
              <select class="input-vendor" id="vendor" name="vendor" required>
                <option value="">Pilih Vendor</option>
                <?php foreach ($data['vendors'] as $vendor): ?>
                <option value="<?= $vendor['vendor']; ?>">
                  <?= $vendor['vendor']; ?>
                </option>
                <?php endforeach; ?>
              </select>
          </div>
          <div class="mb-3">
            <div class="row">
              <label for="code_number" class="form-label">Part Number</label>
            </div>
            <select
              class="input-number"
              id="code_number"
              name="code_number"
              required
            >
              <option value="">Choose Part Number</option>
              <?php foreach ($data['parts'] as $part): ?>
              <option><?= $part['code_number']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
              <label for="operator" class="form-label">Inspector Name</label>
              <input type="text" class="form-control" id="operator" name="operator" required>
          </div>
          <div class="mb-3">
            <label for="file" class="form-label">File</label>
            <input
              type="file"
              class="form-control"
              id="file"
              name="file"
              accept=".xls,.xlsx,.pdf,.doc,.docx"
              required
            />
          </div>
       
          <button type="submit" class="btn btn-success" id="btnSimpan">
            Save
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Data Vendor -->
<div
  class="modal fade"
  id="tambahModal2"
  tabindex="-1"
  aria-labelledby="tambahModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Add Vendor</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form
          id="formTambahData2"
          action="<?= BASEURL; ?>/home/addVendorData"
          method="POST"
          enctype="multipart/form-data"
        >
          <input type="hidden" name="form_type" value="vendor_data" />
          <div class="mb-3">
            <label for="vendor" class="form-label">Vendor</label>
            <input
              type="text"
              class="form-control"
              id="vendor"
              name="vendor"
              required
            />
          </div>
          <div class="mb-3">
            <label for="code_number" class="form-label">Part Number</label>
            <input
              type="text"
              class="form-control"
              id="code_number"
              name="code_number"
              required
            />
          </div>
          <button type="submit" class="btn btn-success" id="btnSimpan2">
            Save
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
