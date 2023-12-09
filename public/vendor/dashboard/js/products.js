jQuery(document).ready(function ($) {

    let modalFormStockRecord = $('#modal-form-stock-record');
    let formStockRecord = $('#form-stock-record');

    $('body').on('click', '.js-add-stock_record', function (e) {
        modalFormStockRecord.modal('show');
        formStockRecord.trigger('reset');
        formStockRecord.attr('action', formStockRecord.data('action-store'));

        $('.modal-title', modalFormStockRecord).html(modalFormStockRecord.data('title-create'));
    })

    $('body').on('click', '.js-stock-record-edit', function (e) {
        e.preventDefault();
        let self = $(this);

        modalFormStockRecord.modal('show');
        $('.modal-title', modalFormStockRecord).html(modalFormStockRecord.data('title-edit'));
        formStockRecord.attr('action', self.attr('href'));

        $('#date').val(self.data('date'));
        $('#product_id').val(self.data('product_id'));
        let value = self.data('value');
        $('#value_plus').val('');
        $('#value_minus').val('');
        if (value > 0) {
            $('#value_plus').val(value);
        } else {
            $('#value_minus').val(value);
        }
    });

    $('body').on('click', '#btn-submit-form-stock-record', function(e) {
        e.preventDefault()

        $.ajax({
            type: "POST",
            url: formStockRecord.attr('action'),
            headers: {
                'X-CSRF-TOKEN': window._token
            },
            data: formStockRecord.serialize(),
            dataType: 'json',
            success: function (response) {
                toastr.success(response.message);
                modalFormStockRecord.modal('hide');
                $('#dataTableBuilder').DataTable().ajax.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 422) {
                    let errors = [];
                    $.each(jQuery.parseJSON(jqXHR.responseText).errors, function (k, v) {
                        errors.push(v[0]);
                    })
                    toastr.warning(errors.join('<br/>'));
                }
            }
        });
    })

    $('body').on('click', '.js-product-toggle-status', function (e) {
        e.preventDefault();
        let self = $(this);
        $.ajax({
            type: "PUT",
            url: self.attr('href'),
            headers: {
                'X-CSRF-TOKEN': window._token
            },
            dataType: 'json',
            success: function (response) {
                toastr.success(response.message);
                $('#dataTableBuilder').DataTable().ajax.reload();
            },
        });
    })

});
