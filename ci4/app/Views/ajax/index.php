<?= $this->include('template/admin_header'); ?>

<style>
  .container-ajax {
    width: 100%;
    margin: 10px auto;
  }
  .btn {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 4px;
    font-size: 0.85rem;
    cursor: pointer;
    border: none;
    text-decoration: none;
    color: #fff;
  }
  .btn-primary  { background: #3498db; }
  .btn-success  { background: #27ae60; }
  .btn-danger   { background: #e74c3c; }
  .btn-warning  { background: #f39c12; color: #fff; }
  .btn:hover    { opacity: 0.85; }

  .table-data {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    border-radius: 8px;
    overflow: hidden;
    margin-top: 15px;
  }
  .table-data th, .table-data td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #eee;
    font-size: 0.9rem;
  }
  .table-data th {
    background: #2c3e50;
    color: #fff;
    font-weight: 600;
  }
  .table-data tbody tr:hover { background: #f9f9f9; }

  .badge {
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 0.78rem;
    font-weight: 600;
  }
  .badge-aktif    { background: #d4edda; color: #155724; }
  .badge-nonaktif { background: #f8d7da; color: #721c24; }

  /* Modal Style */
  .modal-overlay {
    display: none;
    position: fixed; 
    inset: 0;
    background: rgba(0,0,0,.5);
    z-index: 9999;
    align-items: center;
    justify-content: center;
  }
  .modal-overlay.active { display: flex; }
  .modal-box {
    background: #fff;
    border-radius: 10px;
    padding: 25px;
    width: 100%;
    max-width: 480px;
    box-shadow: 0 10px 40px rgba(0,0,0,.2);
    animation: slideIn .25s ease;
  }
  @keyframes slideIn {
    from { transform: translateY(-30px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
  }
  .form-group { margin-bottom: 14px; }
  .form-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 6px;
    color: #555;
  }
  .form-group input, .form-group textarea, .form-group select {
    width: 100%;
    padding: 9px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 0.9rem;
    box-sizing: border-box;
  }
  .modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px; }
  .alert {
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 16px;
    font-size: 0.88rem;
    display: none;
  }
  .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
  .alert-danger  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
  .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
  #loadingRow td { text-align: center; color: #888; font-style: italic; padding: 24px; }
</style>

<div class="container-ajax">
  <h2>📰 Manajemen Artikel (AJAX)</h2>

  <div id="alertBox" class="alert"></div>

  <div class="toolbar">
    <span id="totalData" style="color:#666; font-weight: bold; font-size: 0.9rem;"></span>
    <button class="btn btn-success" id="btnTambah">+ Tambah Artikel</button>
  </div>

  <table class="table-data" id="artikelTable">
    <thead>
      <tr>
        <th style="width:50px">#</th>
        <th>Judul</th>
        <th>Status</th>
        <th style="width:160px">Aksi</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      <tr id="loadingRow"><td colspan="4">Memuat data...</td></tr>
    </tbody>
  </table>
</div>

<div class="modal-overlay" id="modalForm">
  <div class="modal-box">
    <h3 id="modalTitle" style="margin-top:0;">Tambah Artikel</h3>
    <input type="hidden" id="artikelId">
    <div class="form-group">
      <label>Judul Artikel</label>
      <input type="text" id="inputJudul" placeholder="Masukkan judul artikel">
    </div>
    <div class="form-group">
      <label>Isi / Konten</label>
      <textarea id="inputIsi" rows="5" placeholder="Masukkan isi artikel..."></textarea>
    </div>
    <div class="form-group">
      <label>Status</label>
      <select id="inputStatus">
        <option value="0">Non-aktif</option>
        <option value="1">Aktif</option>
      </select>
    </div>
    <div class="modal-actions">
      <button class="btn btn-danger" id="btnBatalModal">Batal</button>
      <button class="btn btn-primary" id="btnSimpan">Simpan</button>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>

<script>
const BASE_URL = "<?= base_url('admin/ajax/') ?>";

function showAlert(msg, type = 'success') {
  const box = $('#alertBox');
  box.attr('class', 'alert alert-' + type).text(msg).show();
  setTimeout(() => box.fadeOut(), 3500);
}

// 1. AMBIL DATA (READ)
function loadData() {
  $('#tableBody').html('<tr id="loadingRow"><td colspan="4">Memuat data...</td></tr>');
  $.ajax({
    url: BASE_URL + 'getData',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      $('#totalData').text('Total: ' + data.length + ' artikel');
      if(data.length === 0) {
        $('#tableBody').html('<tr><td colspan="4" style="text-align:center; color:#999;">Belum ada data.</td></tr>');
        return;
      }
      let html = '';
      data.forEach(function(row, i) {
        let statusBadge = row.status == 1 
          ? '<span class="badge badge-aktif">Aktif</span>' 
          : '<span class="badge badge-nonaktif">Non-aktif</span>';
        
        // Mengubah kolom pertama dari row.id menjadi (i + 1) agar penomoran berurutan rapi
        html += `<tr>
          <td>${i + 1}</td>
          <td>${row.judul}</td>
          <td>${statusBadge}</td>
          <td>
            <button class="btn btn-warning btn-edit" data-id="${row.id}" style="margin-right:4px">Edit</button>
            <button class="btn btn-danger btn-delete" data-id="${row.id}">Hapus</button>
          </td>
        </tr>`;
      });
      $('#tableBody').html(html);
    },
    error: function(xhr) {
      console.log(xhr.responseText);
      $('#tableBody').html('<tr><td colspan="4" style="text-align:center; color:red; font-weight:bold;">Gagal memuat data.</td></tr>');
    }
  });
}

// Buka Modal Tambah
$('#btnTambah').on('click', function() {
  $('#modalTitle').text('Tambah Artikel');
  $('#artikelId').val('');
  $('#inputJudul').val('');
  $('#inputIsi').val('');
  $('#inputStatus').val('0');
  $('#modalForm').addClass('active');
});

// Tutup Modal
$('#btnBatalModal').on('click', function() { 
  $('#modalForm').removeClass('active'); 
});

// 2 & 3. SIMPAN & UBAH DATA (CREATE & UPDATE)
$('#btnSimpan').on('click', function() {
  const id = $('#artikelId').val();
  const judul = $('#inputJudul').val().trim();
  const isi = $('#inputIsi').val().trim();
  const status = $('#inputStatus').val();

  if(!judul || !isi) {
    showAlert('Judul dan Isi tidak boleh kosong!', 'danger');
    return;
  }

  const url = id ? BASE_URL + 'update/' + id : BASE_URL + 'create';

  $.ajax({
    url: url,
    method: 'POST',
    data: { judul: judul, isi: isi, status: status },
    dataType: 'json',
    success: function(res) {
      if(res.status === 'OK') {
        $('#modalForm').removeClass('active');
        showAlert(res.message, 'success');
        loadData();
      } else {
        showAlert('Gagal menyimpan data.', 'danger');
      }
    },
    error: function() {
      showAlert('Gagal memproses data ke server.', 'danger');
    }
  });
});

// AMBIL DATA DETAIL BERDASARKAN ID (EDIT MODE)
$(document).on('click', '.btn-edit', function() {
  const id = $(this).data('id');
  $.ajax({
    url: BASE_URL + 'getById/' + id,
    method: 'GET',
    dataType: 'json',
    success: function(row) {
      if(row) {
        $('#modalTitle').text('Edit Artikel');
        $('#artikelId').val(row.id);
        $('#inputJudul').val(row.judul);
        $('#inputIsi').val(row.isi);
        $('#inputStatus').val(row.status);
        $('#modalForm').addClass('active');
      }
    },
    error: function() {
      showAlert('Data tidak ditemukan.', 'danger');
    }
  });
});

// 4. HAPUS DATA (DELETE)
$(document).on('click', '.btn-delete', function() {
  const id = $(this).data('id');
  if (!confirm('Apakah Anda yakin ingin menghapus artikel ini?')) return;
  
  $.ajax({
    url: BASE_URL + 'delete/' + id,
    method: 'POST',
    dataType: 'json',
    success: function(res) {
      if(res.status === 'OK') {
        showAlert(res.message, 'success');
        loadData();
      } else {
        showAlert('Gagal menghapus artikel.', 'danger');
      }
    },
    error: function() {
      showAlert('Gagal mengirim perintah hapus.', 'danger');
    }
  });
});

$(document).ready(function() {
  loadData();
});
</script>

<?= $this->include('template/admin_footer'); ?>