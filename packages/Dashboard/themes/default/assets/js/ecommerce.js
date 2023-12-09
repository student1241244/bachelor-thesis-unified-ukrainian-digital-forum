jQuery(document).ready(function ($) {

    $('body').on('click', '.js-order-toggle-status', function (e) {
        e.preventDefault();

        requestChangeOrderStatus($(this), (response) => {
            toastr.success(response.message);
            $('#dataTableBuilder').DataTable().ajax.reload();
        });
    })

    $('body').on('click', '.js-order-toggle-status-show', function (e) {
        e.preventDefault();

        requestChangeOrderStatus($(this), (response) => {
            toastr.success(response.message);
            setTimeout(function () {
                window.location.reload();
            }, 2000)
        });
    })

    function requestChangeOrderStatus(link, callback) {
        link.attr('disabled', true);
        $.ajax({
            type: "PUT",
            url: link.attr('href'),
            headers: {
                'X-CSRF-TOKEN': window._token
            },
            dataType: 'json',
            success: function (response) {
                callback(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                let response = JSON.parse(jqXHR.responseText);
                if (jqXHR.status === 422) {
                    toastr.error(response.error);
                } else if (jqXHR.status === 401) {
                    window.location.reload()
                }
            }
        });
    }
});
