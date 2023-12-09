<script src="/{{ config('tpx_dashboard.public_resources') }}/js/drop_uploader.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/js/drop-uploader-modal.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
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
</script>
