@include('tpx_dashboard::dashboard.modal-upload')
<script src="/{{ config('tpx_dashboard.public_resources') }}/js/drop_uploader.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/js/drop-uploader-modal.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('#uploadModal').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget);

            addUploaderElemToModal(button);

            initUploader({
                uploader_text: '{{trans('dashboard::dashboard.uploader.uploader_text')}}',
                browse_text: '{{trans('dashboard::dashboard.uploader.browse_text')}}',
                only_one_error_text: '{{trans('dashboard::dashboard.uploader.only_one_error_text')}}',
                not_allowed_error_text: '{{trans('dashboard::dashboard.uploader.not_allowed_error_text')}}',
                big_file_before_error_text: '{{trans('dashboard::dashboard.uploader.big_file_before_error_text')}}',
                big_file_after_error_text: '{{trans('dashboard::dashboard.uploader.big_file_after_error_text')}}',
                allowed_before_error_text: '{{trans('dashboard::dashboard.uploader.allowed_before_error_text')}}',
                allowed_after_error_text: '{{trans('dashboard::dashboard.uploader.allowed_after_error_text')}}'
            });
        });

        $('[data-delete]').on('click', function (event) {
            var elem = $(this);
            var link = elem.attr('data-del-url');
            var defaultImage = $(this).attr('data-default');
            var previews = parseInt(elem.parents('.previews').find('img').length);

            swal({
                    title: "{{trans('dashboard::dashboard.are_you_sure')}}",
                    text: "{{trans('dashboard::dashboard.no_recoverable')}}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{trans('dashboard::dashboard.yes_delete')}}",
                    cancelButtonText: "{{trans('dashboard::dashboard.cancel')}}",
                    closeOnConfirm: true
                },
                function(){
                    $.ajax({
                        url : link,
                        type: 'get',
                        cache: false,
                        processData:false,
                        contentType: false
                    })
                        .done(function(data){
                            if(previews > 1) {
                                elem.remove();
                            } else {
                                elem.replaceWith('<img src="' + defaultImage + '" class="img-placeholder" />');
                            }
                        });
                });

        });
    });
</script>
