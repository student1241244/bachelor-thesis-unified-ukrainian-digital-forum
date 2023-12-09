function set_media($elem, media) {
    var tpl = $('<li />'),
        isMultiple = !!parseInt($elem.data('multiple')),
        emptyItem = isMultiple ? $elem.find('[data-empty]') : $elem.find('>ul>li'),
        old,
        isImage = media.type === 'image',
        icon;

    if(!$elem.length || typeof media === 'undefined') {
        return;
    }
    
    tpl.html($elem.find('.li-tpl').contents().clone());

    if (emptyItem.length) {
        old = emptyItem.clone();
        tpl.data('old', old);
    }

    emptyItem.remove();
    tpl.appendTo($elem.find('.upload-results'));

    if (isImage) {
        tpl.find('>div').prepend($('<img />', {src : media.path}));
    } else {
        icon = 'fa fa-file-' + (media.group ? (media.group + '-') : '') + 'o';
        tpl.find('>div').prepend($('<i />', {"class" : icon}));
    }

    tpl.find('input.file').removeAttr('disabled');
    tpl.find('.file-name>span').text(media.title);
    tpl.find('.download-file').attr('href', media.download);
    tpl.find('input.file').val(media.id);
    tpl.attr('data-type', media.type);
    tpl.data('url', media.titleUrl);
}

function init_media(selector) {

    unset_media(selector);

    $(selector).each(function() {
        $(this).attr('data-media', 1);
    });

    $(selector).fileupload({
        dropZone: null,
        url: function () {
            return $(this).data('url')
        },
        add: function (e, data) {
            var tpl = $('<li />'),
                $this = $(this),
                isMultiple = !!parseInt($this.data('multiple')),
                spinner = $this.find('[data-spinner]:last').clone().fadeOut("fast").addClass('active'),
                emptyItem = isMultiple ? $this.find('[data-empty]') : $this.find('>ul>li'),
                old;

            tpl.html($this.find('.li-tpl').contents().clone());
            tpl.addClass('working');
            tpl.hide();
            tpl.find('>div').append(spinner.fadeIn('fast'));
            if (emptyItem.length) {
                old = emptyItem.clone();
                tpl.data('old', old);
            }
            emptyItem.remove();
            tpl.fadeIn('fast');
            data.context = tpl.appendTo($this.find('.upload-results'));

            tpl.find('.delete-file').click(function () {
                if (tpl.hasClass('working')) {
                    jqXHR.abort();
                    tpl.fadeOut(function () {
                        tpl.remove();
                    });
                }
            });
            var jqXHR = data.submit();
        },

        fail: function (e, data) {
            var li, holder;

            if (data.context.data('old')) {
                holder = data.context.closest('.upload-results');
                data.context.replaceWith(data.context.data('old'));
                li = holder.find('>li');
            } else {
                li = data.context;
            }

            li.append($('<span />', {"class" : 'file-name'}).html($('<span />').text(data.jqXHR.responseJSON.errors.file[0])));
            li.addClass('error');
            li.find('[data-spinner]').remove();
        },
        progress : function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            data.context.find('.media-progress').text('' + progress + '%');
        },
        done: function (e, data) {
            var isImage,
                spinner = data.context.closest(selector).find('.active[data-spinner]'),
                icon,
                isMultiple = !!parseInt(data.context.closest(selector).data('multiple'));
            if (data.textStatus == "success") {
                isImage = data.result.type == 'image';
                if (isImage) {
                    data.context.find('>div').prepend($('<img />', {src: data.result.path}));
                } else {
                    icon = 'fa fa-file-' + (data.result.group ? (data.result.group + '-') : '') + 'o';
                    data.context.find('>div').prepend($('<i />', {"class": icon}));
                }

                data.context.find('input.file').removeAttr('disabled');
                data.context.find('.file-name>span').text(data.result.title);
                data.context.find('.download-file').attr('href', data.result.download);
                data.context.find('input.file').val(data.result.id);
                data.context.attr('data-type', data.result.type);
                data.context.data('url', data.result.titleUrl);
                data.context.removeClass('working');
                data.context.fadeIn('fast');
                spinner.remove();
            } else if (data.result.error) {
                data.context.addClass('error');
                data.context.find('.file-name>span').text(data.result.error);
                spinner.remove();
            } else {
                data.context.remove();
            }
        },
        dataType: "json"

    });

    $(document)
        .on('click', selector + ' li:not(.working) .delete-file', function () {
            var $this = $(this),
                li = $this.closest('li'),
                upload = li.closest(selector);

            if (upload.data('type') == 'image' && upload.find('li').length == 1) {
                li.html(upload.find('.empty-tpl').contents().clone());
                li.attr('data-empty', 1);
            } else {
                li.fadeOut(function () {
                    li.remove();
                });
            }
            return false;
        })
        .on('click', selector + ' a.preview-video', function () {
            var $modal = $('#videoLinkPreviewModal');

            $('#video-link-preview').html('<iframe ' +
                'width="538" ' +
                'height="336" ' +
                'src="' + $(this).data('url') + '" ' +
                'frameborder="0" ' +
                'allowfullscreen>' +
                '</iframe>'
            );

            $modal.modal('show');

            return false;
        })
        .on('click', '[data-upload-video-link]', function () {
            var url = $(this).data('url');
            var inputs = $('#upload-video-link').find('input');
            var data = {};

            $.when(
                inputs.each(function(){
                        $(this).parent().find('p.help-block').remove();
                        $(this).parent().removeClass('has-error');
                        data[$(this).attr('name')] = $(this).val();
                    })
            ).then(function(){

                $.post(url, data).done(function (data) {
                    var tpl = $('<li />');

                    tpl.html($('.li-tpl').contents().clone());
                    tpl.fadeIn('fast');

                    var context = tpl.appendTo($('.upload-results'));

                    context.find('>div').prepend($('<a />', {"href" : '#', "class": 'preview-video'}).data('url', data.path));
                    context.find('>div').prepend($('<img />', {src : data.preview}));
                    context.find('input.file').removeAttr('disabled');
                    context.find('.file-name>span').text(data.title);
                    context.find('.download-file').remove();
                    context.find('input.file').val(data.id);
                    context.attr('data-type', data.type);
                    context.data('url', data.titleUrl);
                    context.removeClass('working');
                    context.fadeIn('fast');

                    $('#videoLinkModal').modal('hide');
                    }).fail(function(jqXHR, textStatus){

                    if(jqXHR.status === 422) {
                        var data = jqXHR.responseJSON;
                        $.each(data.errors, function( key, value ) {
                            var input = $("#video_" + key);
                            $('<p />', {"class" : "help-block"}).html(value[0]).insertAfter(input);
                            input.parent().addClass('has-error');
                        });
                    }
                });
            });

        })
        .on('click', selector + ' [data-upload]', function () {
            $(this).closest(selector).find('input[type="file"]').click();
            return false;
        })
        .on('click', selector + ' .file-name', function () {
            var $this = $(this),
                text = $this.text(),
                input = $('<input />', {"class": 'file-name-input form-control', 'type': 'text'}),
                inputHolder = $('<div />', {"class": 'file-name-input-holder'}),
                submit = $('<a />', {href: '#', "class": 'file-name-submit'});

            input.val(text);
            inputHolder.append(input).append(submit);
            $this.replaceWith(inputHolder);
            input.focus();

            return false;
        })
        .on('click', selector + ' a.file-name-submit', function () {
            var $this = $(this),
                holder = $this.closest('.file-name-input-holder'),
                title = holder.find('input').val(),
                _token = $('input.__token:first').val(),
                url = $this.closest('li').data('url'),
                link = $('<a />', {"class": 'file-name'});

            $.post(url, {title: title, _token: _token});

            link.html($('<span />').text(title));

            holder.replaceWith(link);

            return false;
        });
    $('#videoLinkModal').on('show.bs.modal', function (e) {
        var inputs = $('#upload-video-link').find('input[type=text]');

        inputs.each(function(){
            $(this).parent().find('p.help-block').remove();
            $(this).parent().removeClass('has-error');
            $(this).val('');
        });
    });
    $('#videoLinkPreviewModal').on('hide.bs.modal', function (e) {
        $('#video-link-preview').html('');
    })
}

function unset_media(selector) {
    $(selector).each(function() {
        var $this = $(this);
        if($this.attr('data-media') && typeof $this.data('blueimpFileupload') !== 'undefined') {
            $this.fileupload('destroy');
            $this.removeAttr('data-media');
        }
    });

    $(document).off('click', selector + ' li:not(.working) .delete-file')
        .off('click', selector + ' a.preview-video')
        .off('click', '[data-upload-video-link]')
        .off('click', selector + ' [data-upload]')
        .off('click', selector + ' .file-name')
        .off('click', selector + ' a.file-name-submit');
}

// init_media('.upload');
