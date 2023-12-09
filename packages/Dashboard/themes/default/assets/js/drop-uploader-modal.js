function createNewUploader(params) {
    const input = $(`<input type="file" name="${params.name}" />`);

    if (params.accept !== undefined) {
        input.attr('accept', params.accept);
    }

    if (params.method !== undefined) {
        input.attr('data-method', params.method);
    }

    if (params.maxfilesize !== undefined) {
        input.attr('data-maxfilesize', params.maxfilesize);
    }

    if (params.layout !== undefined) {
        input.attr('data-layout', params.layout);
    }
    if (params.count !== undefined) {
        input.attr('data-count', params.count);
    }

    if (params.multiple === 'on') {
        input.attr('multiple', true);
        input.attr('name', `${params.name}[]`);
    }

    return input;
}

function initModalContent(uploader, params) {
    $('#uploadModal [data-apply]')
        .attr('data-collection', params.collection)
        .attr('data-wrapper-name', params.wrapper_name)
        .attr('data-multiple', params.multiple);
    $('#uploadModal .modal-title').text(params.label);
    $('#uploadModal .modal-body').html(uploader);
}

function addUploaderElemToModal(button) {
    const params = {
        name: button.attr('data-name'),
        wrapper_name: button.attr('data-wrapper-name'),
        collection: button.attr('data-collection'),
        label: button.attr('data-label'),
        accept: button.attr('data-accept'),
        method: button.attr('data-method'),
        maxfilesize: button.attr('data-maxfilesize'),
        layout: button.attr('data-layout'),
        count: button.attr('data-count'),
        multiple: button.attr('data-multiple'),
    };

    const uploader = createNewUploader(params);

    initModalContent(uploader, params);
}

function initUploader(params) {
    $('input[type=file]').drop_uploader({
        uploader_text: params.uploader_text,
        browse_text: params.browse_text,
        only_one_error_text: params.only_one_error_text,
        not_allowed_error_text: params.not_allowed_error_text,
        big_file_before_error_text: params.big_file_before_error_text,
        big_file_after_error_text: params.big_file_after_error_text,
        allowed_before_error_text: params.allowed_before_error_text,
        allowed_after_error_text: params.allowed_after_error_text,
        browse_css_class: 'button button-primary',
        browse_css_selector: 'file_browse',
        uploader_icon: '<i class="pe-7s-cloud-upload"></i>',
        file_icon: '<i class="fa fa-file-o"></i>',
        progress_color: '#4a90e2',
        time_show_errors: 1,
        layout: 'thumbnails',
        method: 'normal',
        chunk_size: 1000000,
        url: 'ajax_upload.php',
        delete_url: 'ajax_delete.php',
    });
}

function cancelPreviousAction(previews, uploadWrapper) {
    previews.find('.file-wrapper-new').remove();
    previews.find('.file-wrapper').removeClass('hidden');
    uploadWrapper.find('inputs').empty();
}

$(document).ready(() => {
    $('body').on('click', '.upload-wrapper [data-cancel]', (event) => {
        const button = $(event.target);
        const uploadWrapper = button.parents('.upload-wrapper');
        const previews = uploadWrapper.find('.previews');

        cancelPreviousAction(previews, uploadWrapper);

        $(button).attr('data-cancel', 'off');
    });

    $('#uploadModal [data-apply]').on('click', function () {
        const button = $(this);
        const wrapperName = button.attr('data-wrapper-name');
        const multiple = button.attr('data-multiple') || false;
        const uploadWrapper = $(`#upload_wrapper_${wrapperName}`);
        const previews = uploadWrapper.find('.previews');
        const inputs = uploadWrapper.find('.inputs');
        const body = $('#uploadModal .drop_uploader');

        if (inputs.html().length && multiple === false) {
            cancelPreviousAction(previews, uploadWrapper);
        }

        if (multiple === false) {
            previews.find('.file-wrapper').addClass('hidden');
        } else {
            previews.find('.img-placeholder').addClass('hidden');
        }

        $('#uploadModal .thumbnail').each(function () {
            const $content = $(this).closest('li').contents();
            previews.append(
                $('<div />', { class: 'file-wrapper file-wrapper-new' }).html($content),
            );
        });

        uploadWrapper.find('[data-cancel]').attr('data-cancel', 'on');
        inputs.append(body);
        $(button).attr('data-apply', 'off');

        $('#uploadModal').modal('hide');
    });

    $('#uploadModal').on('hidden.bs.modal', (event) => {
        $('#uploadModal .modal-body').html('');
        $('#uploadModal .modal-title').html('');
    });
});
