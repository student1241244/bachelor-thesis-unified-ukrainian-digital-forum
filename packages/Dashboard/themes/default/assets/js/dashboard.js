function updateAllBadgeCounters() {

  $.ajax({
    type: "GET",
    url: $('#side-menu').data('url'),
    dataType: 'json',
    cache: false,
    success: function (response) {
      $('.js-menu-badge .badge').text('')
      $.each(response, function(model, count) {
        if (count) {
          $('#badge-' + model).find('.badge').text(count)
        }
      })
    },
  });

}

function dataTableReadItems(url) {
  ids = [];
  $('.data-table-item-not-read .checkbox-reader').each(function(){
    if (!$(this).is(':checked')) {
      ids.push($(this).val());
    }
  })

  sendRequestRecordsIsRead(url, ids, 1)
}

function sendRequestRecordsIsRead(url, ids, value, manually = false) {
  if (ids.length === 0) {
    return;
  }

  $.ajax({
    type: "PUT",
    url: url,
    cache: false,
    data: {
      ids,
      value,
      '_token': window._token
    },
    dataType: 'json',
    success: function (response) {

      updateAllBadgeCounters();

      $.each(ids, function(k, id) {
        var checkbox = $('.checkbox-reader[value=' + id +']');
        var row = checkbox.closest('tr');

        if (!manually) {
          checkbox.prop('checked', !checkbox.is(':checked'));
        }

        if (checkbox.is(':checked')) {
          row.removeClass('data-table-item-not-read');
        } else {
          row.addClass('data-table-item-not-read');
        }
      })
    },
  });
}

function handleTextAreaAutosize(element, reset = false) {
  var offset = element.offsetHeight - element.clientHeight;

  element.addEventListener('input', handleInput);

  if (reset) {
    element.style.height = null;
    element.removeEventListener('input', handleInput);
  } else {
    updateHeight(element)
  }

  function updateHeight(target) {
    target.style.height = 'auto';
    target.style.height = target.scrollHeight + offset + 'px';
  }

  function handleInput(event) {
    updateHeight(event.target);
  }
}

jQuery(document).ready(function ($) {
  $('#dataTableBuilder').on('draw.dt', function () {
    let checkbox = $('.checkbox-reader:first', $(this));

    setTimeout(function(){
      dataTableReadItems(checkbox.data('url'));
    }, 5000)
  });

  $('body').on('change', '.checkbox-reader', function(){
    var id = $(this).val();
    sendRequestRecordsIsRead($(this).data('url'), [id], $(this).is(':checked') ? 1 : 0, true);
  })


  $('.select2').select2({
    width: "100%"
  });

  $('.datetimepicker').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'});


  $('.color-selector-wrapper').on('click', '.color-selector', function () {
    let elem = $(this);
    let color = elem.data('color');
    let parent = elem.parent('.color-selector-wrapper')
    parent.find('.color-selector').removeClass('selected');
    elem.addClass('selected');
    parent.find('input').val(color);
  });

  $('body').on('change', '.js-datatable-toggle-status', function(){
    let self = $(this);
    $.ajax({
      type: "PUT",
      url: self.data('url'),
      cache: false,
      data: {
        'value': self.is(':checked') ? 1 : 0,
        '_token': window._token,
      },
      dataType: 'json',
      success: function (response) {
        toastr.success(response.message);
      },
    });
  })

  $('body').on('click', '.js-view', function(e) {
    e.preventDefault();
    let self = $(this);
    $.ajax({
      url: self.attr('href'),
      cache: false,
      success: function (response) {
        let modal = $('#modal-view');
        $('.modal-body', modal).html(response);
        modal.modal('show');
      },
    });
  });

  let translationTextOrigin = '';
  $('body').on('focus', '.js-translation-text', function () {
    translationTextOrigin = $.trim($(this).val());
    handleTextAreaAutosize($(this).get(0));
  })

  $('body').on('focusout', '.js-translation-text', function () {
    translationTextOrigin = $.trim($(this).val());
    handleTextAreaAutosize($(this).get(0), true);
  })

  $('body').on('click', '.js-reset', function () {
    let self = $(this);

    let data = {'_token': window._token};
    let hasError = false;
    self.closest('tr').find('.js-translation-text').each(function () {
      $(this).val($(this).data('reset'));
    })
  })

  $('body').on('click', '.js-save', function () {
    let self = $(this);

    let data = {'_token': window._token};
    let hasError = false;
    self.closest('tr').find('.js-translation-text').each(function(){
      let val = $(this).val();
      if (val === '') {
        $(this).addClass('translation-error');
        hasError = true;
      } else {
        $(this).removeClass('translation-error');
        data[$(this).attr('name')] = val;
      }
    })
    if (hasError) {
      return;
    }

    $.ajax({
      type: "PUT",
      url: self.data('url'),
      data,
      cache: false,
      dataType: 'json',
      success: function (response) {
        toastr.success(response.message);
      },
    });
  });

  $('body').on('click', '#btn-send-import', function(e) {
    let form = $('#form-import')
    let btn = $(this)
    let data = new FormData()

    if (typeof ($('#import-file')[0].files[0]) != 'undefined') {
      data.append('file', $('#import-file')[0].files[0]);
    }
    btn.prop('disabled', true);
    $.ajax({
      type: "POST",
      url: form.attr('action'),
      cache: false,
      headers: {
        'X-CSRF-TOKEN': window._token
      },
      data,
      dataType: 'json',
      contentType: false,
      processData: false,
      success: function (response) {
        toastr.success(response.message);
        btn.prop('disabled', false);
        form.trigger('reset');
        $('#modal-import').modal('hide');
      },
      error: function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 422) {
          let errors = [];
          $.each(jQuery.parseJSON(jqXHR.responseText).errors, function (k, v) {
            errors.push(v[0]);
          })
          toastr.warning(errors.join('<br/>'));
        }
        btn.prop('disabled', false);
      }
    });
  })

  if ($('.js-menu-badge').length) {

  }

  /*
  $('.js-menu-badge').each(function(){
      let self = $(this);
      $.ajax({
          type: "GET",
          url: self.data('url'),
          dataType: 'json',
          cache: false,
          success: function (response) {
              if (response.count) {
                  self.removeClass('hidden');
                  self.find('span').html(response.count);
              } else {
                  self.addClass('hiddensendRequestRecordsIsRead');
              }
          }
      });
  })
   */

  $('body').on('click', '.js-contact-more-text', function (e) {
    e.preventDefault();
    let self = $(this);
    $.ajax({
      type: "GET",
      url: self.data('url'),
      cache: false,
      dataType: 'json',
      success: function (response) {
        $('#modal-content').modal('show').find('.modal-body').html('<p style="word-wrap: break-word">'+response.message+'</p>');
      },
    });

  })

  updateAllBadgeCounters()
  let updateAllBadgeCountersTimeout = 30000;
  let timerUpdateAllBadgeCounters = setInterval(() => updateAllBadgeCounters(), updateAllBadgeCountersTimeout);

  $(window).blur(function () {
    clearTimeout(timerUpdateAllBadgeCounters)
  })

  $(window).focus(function () {
    updateAllBadgeCounters()
    timerUpdateAllBadgeCounters = setInterval(() => updateAllBadgeCounters(), updateAllBadgeCountersTimeout);
  })
});
