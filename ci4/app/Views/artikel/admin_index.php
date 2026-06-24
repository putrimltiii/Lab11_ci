<?= $this->include('template/admin_header'); ?>

<div class="container mt-4">
    <h2>Manajemen Artikel (AJAX)</h2>

    <div class="row mb-3">
        <div class="col-md-6">
            <form id="search-form" class="form-inline">
                <input type="text" id="search-box" placeholder="Cari judul artikel..." class="form-control mr-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
    </div>

   <table class="table table-bordered">
    <thead>
        <tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody id="article-body">
        </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function loadData(query = '') {
        $.ajax({
            url: '<?= base_url('admin/artikel'); ?>',
            method: 'GET',
            data: { q: query },
            dataType: 'json',
            success: function(data) {
                let html = '';
                // Pastikan data artikel ada
                if(data.artikel && data.artikel.length > 0) {
                    data.artikel.forEach((row, i) => {
                        // Logika Status
                        let statusText = (row.status == 1) ? 'Aktif' : 'Non-aktif';
                        
                        html += `<tr>
    <td>${i+1}</td>
    <td>${row.judul}</td>
    <td>${row.nama_kategori || '-'}</td>
    <td>${statusText}</td>
    <td>
        <a href="<?= base_url('admin/artikel/edit'); ?>/${row.id}" 
           class="btn btn-sm" 
           style="background-color: #ffc107; color: #000; font-weight: bold; border: 1px solid #e0a800;">
           Edit
        </a>
        
        <a href="<?= base_url('admin/artikel/delete'); ?>/${row.id}" 
           class="btn btn-sm btn-danger">
           Hapus
        </a>
    </td>
</tr>`;
                    });
                } else {
                    html = '<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>';
                }
                $('#article-body').html(html);
            }
        });
    }
    
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        loadData($('#search-box').val());
    });

    loadData(); // Load awal
});
</script>

<?= $this->include('template/admin_footer'); ?>