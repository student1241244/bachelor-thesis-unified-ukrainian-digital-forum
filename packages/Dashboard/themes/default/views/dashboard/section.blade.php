@section('header-extras')
    @parent
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/data-tables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/data-tables/dataTables.responsive.css" rel="stylesheet">
@stop

    <div class="wrapper wrapper-content">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12 table-responsive table-hover">
                        <button type="button" class="btn btn-sm btn-primary testimonial-create">
                            <span class="fa fa-plus"></span>
                            {{trans('dashboard::dashboard.create')}}
                        </button>
                        {!! $dataTable->table(['class' =>'table table-striped dataTable no-footer table-hover']); !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('footer-extras')
    @include($popups)
    @parent

    <script src="/{{ config('tpx_dashboard.public_resources') }}/js/data-tables/jquery.dataTables.js"></script>
    <script src="/{{ config('tpx_dashboard.public_resources') }}/js/data-tables/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        function datatableScript() {
            {!! strip_tags($dataTable->scripts()) !!}
        }

        function initDataTable() {
            datatableScript();

            var sourcePrefix = '{{$namespace}}';
            var failHandler = function(xhr){
                if('responseJSON' in xhr){
                    toastr.error(xhr.responseJSON.message);
                }
            };

            // Show create form.
            $(document).on('click', '.' + sourcePrefix + '-create', function(){
                $('form[name="' + sourcePrefix + '-form-save"]')[0].reset();

                $('#' + sourcePrefix).modal('show');
                init_media('.upload');
            });

            // Store data.
            $('.' + sourcePrefix + '-store').on('click', function(){
                var form = $('form[name="' + sourcePrefix + '-form-save"]');
                var data = {};
                var url = form.attr('action');

                $.map(form.serializeArray(), function(n, i){
                    data[n['name']] = n['value'];
                });

                $.ajax({
                    method: 'POST',
                    url: url,
                    data: data
                }).done(function (msg){
                    $('#testimonial').modal('hide');
                    window.LaravelDataTables["dataTableBuilder"].draw(false);
                }).fail(failHandler);
            });

            // Show Edit form.
            $(document).on('click', '.' + sourcePrefix + '-edit', function(){
                var modal = $('#' + sourcePrefix + '-edit');
                var url = $(this).data('url');

                $.ajax({
                    method: 'GET',
                    url: url
                }).done(function (response){
                    modal.modal('show');
                    var data = response.data;
                    var form = $('form[name="' + sourcePrefix + '-form-update"]');

                    form.attr('action', url);
                    form.find('[name]').each(function(){
                        var el = $(this);
                        var key = el.attr('name');
                        if(data[key]){
                            if(el.is("input") || el.is("textarea")) {
                                el.val(data[key]);
                            }
                        }
                    });

                    set_media(form.find('.upload'), response.data.media);
                    init_media('.upload');
                });
            });

            // Update data.
            $('.' + sourcePrefix + '-update').on('click', function(){
                var form = $('form[name="' + sourcePrefix + '-form-update"]');
                var url = form.attr('action');
                var data = {};

                $.map(form.serializeArray(), function(n, i){
                    data[n['name']] = n['value'];
                });

                $.ajax({
                    method: 'POST',
                    url: url,
                    data: data
                }).done(function (msg){
                    $('#' + sourcePrefix + '-edit').modal('hide');
                    window.LaravelDataTables["dataTableBuilder"].draw(false);
                }).fail(failHandler);
            });

            // Delete item.
            $(document).on('click', '.' + sourcePrefix + '-delete', function(){
                var url = $(this).data('url');

                swal({
                    title: "{{trans('dashboard::dashboard.are_you_sure')}}",
                    text: "{{trans('dashboard::dashboard.no_recoverable')}}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{trans('dashboard::dashboard.yes_delete')}}",
                    cancelButtonText: "{{trans('dashboard::dashboard.cancel')}}",
                    closeOnConfirm: true
                }, function(){
                    $.ajax({
                        method: 'GET',
                        url: url
                    }).done(function (msg){
                        window.LaravelDataTables["dataTableBuilder"].draw(false);
                    }).fail(failHandler);
                });
            });
        }
    </script>
@stop
