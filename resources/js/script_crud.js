// memilih menu data yang tampil ## PRODUK
$(document).on('click', '[id^="menu-"]', function() {
    var menuId = $(this).attr('id');
    var targetList = menuId.replace('menu-', '') + '-list';

    $('#category-list, #status-list, #product-list').addClass('hidden');
    $('#' + targetList).removeClass('hidden');

    $('[id^="menu-"]').addClass('hover:text-gray-900 bg-gray-50 hover:bg-gray-100').removeClass('text-blue-600 bg-blue-700');

    $('#' + menuId).removeClass('hover:text-gray-900 bg-gray-50 hover:bg-gray-100').addClass('text-blue-600 bg-blue-700');
});

// update id item pada field hidden id_produk yang akan dihapus ## PRODUK
$(document).on('click', '#delete-product', function() {
    var idProduk = $(this).data('id-product');
    var SetForm = $('#idFormDelete').val(idProduk);        
});

// memilih jenis status yang akan ditampilkan ## PRODUK
$(document).on('change', '#statusSelectView', function() {
    var statusSecondView = $(this).val();
    $('[id^="info-status-"]').addClass('hidden');
    $('#info-status-' + statusSecondView).removeClass('hidden');
});

// update id,nama,harga,katagori,status yang diedit pada input form edit ## PRODUK
$(document).on('click', '#crud-edit', function() {
    var idProduk = $(this).data('id-product');
    $('#form-edit-product').addClass('hidden');
    $('#load-product-edit').removeClass('hidden');
    $('#info-error-edit').addClass('hidden');
    $.ajax({
        url: 'getDataEdit/'+idProduk,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.success) {
                $('#id-product-edit').val(idProduk);
                $('#product-name-edit').val(data.data.nama_produk);
                $('#price-edit').val(data.data.harga);
                $('#category-product-'+data.data.id_kategori).prop('selected', true);
                $('#status-product-'+data.data.id_status).prop('selected', true);
                $('#form-edit-product').removeClass('hidden');
                $('#load-product-edit').addClass('hidden');
            } else {
                $('#info-error-edit').removeClass('hidden');
            }
        }
    });
});

// update nama kategori yang diedit pada input form edit ## KATEGORI
$(document).on('click', '#crud-edit-kategori', function() {
    var idCategory = $(this).data('id-category');
    $('#form-edit-category').addClass('hidden');
    $('#load-category-edit').removeClass('hidden');
    $('#info-category-edit').addClass('hidden');
    $.ajax({
        url: 'getCategoryEdit/'+idCategory,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.success) {
                $('#id-category-edit').val(idCategory);
                $('#category-name-edit').val(data.data.nama_kategori);
                $('#form-edit-category').removeClass('hidden');
                $('#load-category-edit').addClass('hidden');
            } else {
                $('#info-category-edit').removeClass('hidden');
            }
        }
    });
});

// update id item pada field hidden id_produk yang akan dihapus ## KATEGORI
    $(document).on('click', '#delete-kategori', function() {
    var idKategori = $(this).data('id-category');
    var SetForm = $('#idKategoriDelete').val(idKategori);        
});

// update nama kategori yang diedit pada input form edit ## KATEGORI
$(document).on('click', '#crud-edit-status', function() {
    var idStatus = $(this).data('id-status');
    $('#form-edit-status').addClass('hidden');
    $('#load-status-edit').removeClass('hidden');
    $('#info-status-edit').addClass('hidden');
    $.ajax({
        url: 'getStatusEdit/'+idStatus,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.success) {
                $('#id-status-edit').val(idStatus);
                $('#status-name-edit').val(data.data.nama_status);
                $('#form-edit-status').removeClass('hidden');
                $('#load-status-edit').addClass('hidden');
            } else {
                $('#info-status-edit').removeClass('hidden');
            }
        }
    });
});

// update id item pada field hidden id_produk yang akan dihapus ## KATEGORI
$(document).on('click', '#delete-status', function() {
    var idStatus = $(this).data('id-status');
    var SetForm = $('#idStatusDelete').val(idStatus);        
});