jQuery(document).ready(function ($) {

    function initSelectValue() {
        $('select[data-value]').each(function () {
            $(this).val($(this).attr('data-value')).trigger('change')
        })
    }

    initSelectValue()

    $('.js-setting-locale-tab, .js-locale-tab').on('click', function (e) {
        $('.js-locale').hide()
        $('.js-locale-' + $(this).data('locale')).show()
    })

    $('body').on('click', '.js-toggle-checkbox-item', function (e) {
        e.preventDefault()
        let wrap = $(this).closest('.js-toggle-checkbox')
        let val = $(this).attr('data-value')
        let wrapItem = wrap.closest('.settings-list-item')

        $('.js-toggle-checkbox-item', wrap).toggleClass('active')
        $('input[type=hidden]', wrap).val(val)

        if (val == '1') {
            $('.js-toggle-checkbox-item[data-value="1"]', wrap).addClass('btn-primary')
            $('.js-toggle-checkbox-item[data-value="0"]', wrap).removeClass('btn-danger')
            $('.item-form', wrapItem).removeClass('inactive')
        } else {
            $('.js-toggle-checkbox-item[data-value="1"]', wrap).removeClass('btn-primary')
            $('.js-toggle-checkbox-item[data-value="0"]', wrap).addClass('btn-danger')
            $('.item-form', wrapItem).addClass('inactive')
        }
    })

    $('body').on('click', '.js-settings-list-item-remove-btn', function (e) {
        $(this).closest('.settings-list-item').remove()
        reindexSettingListInputs()
    })

    $('body').on('mouseover', '.settings-list-item', function (e) {
        $('.action', $(this)).removeClass('hidden')
    })

    $('body').on('mouseout', '.settings-list-item', function (e) {
        $('.action', $(this)).addClass('hidden')
    })

    $('body').on('submit', '#form-settings, #form-page', function (e) {
        $('.default-item', $(this)).remove()
        reindexSettingListInputs()
    })

    $('body').on('click', '.js-settings-list-item-add-btn', function (e) {
        let wrap = $(this).closest('.settings-list')

        if ($(this).data('max_items') > 0 && $('.settings-list-item', wrap).length >= $(this).data('max_items') + 1) {
            alert('You can add a maximum of '+$(this).data('max_items')+' items')
            return
        }

        let html = wrap.find('.default-item').html()
        $('.settings-list-items', wrap).append(html)
        let lastItem = $('.settings-list-items .settings-list-item:last')

        $('.upload-wrapper', lastItem).each(function (){
            let uploadWrapper = Math.random() * 100000000000000000
            $(this).attr('id', 'upload_wrapper_' + uploadWrapper)
            $('.btn-upload', $(this)).attr('data-wrapper-name', uploadWrapper)
        })

        $([document.documentElement, document.body]).animate({
            scrollTop: lastItem.offset().top
        }, 1000);

        reindexSettingListInputs()

        $('input:visible', lastItem).val('')
        $('textarea:visible', lastItem).val('')
    })


    $('.settings-list-items').sortable({
        out: function( event, ui ) {
            reindexSettingListInputs()
        }
    })

    function reindexSettingListInputs() {
        $('.settings-list').each(function () {
            $('.settings-list-items .settings-list-item', $(this)).each(function (i){
                $('input,textarea,select', $(this)).each(function () {
                    if ($(this).attr('name')) {
                        $(this).attr('name', $(this).attr('name').replace(/\[[0-9]\]/i, `[${i}]`))
                        $(this).attr('name', $(this).attr('name').replace('[]', `[${i}]`))
                    }
                })
                $('.js-number', $(this)).text('#'+(i+1))
            })
        })
    }

    function resolveFormSettingsListErrors() {
        $('.js-help-block').each(function () {
            let formGroup = $(this).prev()
            formGroup.addClass('has-error')
            formGroup.append('<p class="help-block">'+$(this).html()+'</p>')
            $(this).remove()
        })

        $('.js-locale .form-group.has-error').each(function () {
            let locale = $(this).closest('.js-locale').attr('data-locale');
            $('.nav-tabs a[data-locale="'+locale+'"]').closest('li').addClass('tab-error')
        })
    }

    reindexSettingListInputs()
    resolveFormSettingsListErrors()
});
