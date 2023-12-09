<table class="table table-striped dataTable no-footer table-hover agrid" id="items-grid"></table>

@section('footer-extras')
@parent
<script>
    $(function () {

        var tableAgrid = $('#items-grid').aGrid({
            url: '{{ route("threads.comments.index", [], false) }}',
            permissions: {
                update: {{ can('threads.comments.update') ? 1 : 0 }},
                destroy: {{ can('threads.comments.destroy') ? 1 : 0 }},
            },
            columns: [
				{
					name: "id",
					label: "#",
				},
				{
					name: "thread_title",
					label: "{{ __('threads::comment.attributes.thread_id') }}",
				},
				{
					name: "body",
					label: "{{ __('threads::comment.attributes.body') }}",
				},
                {
                    name: "reports",
                    label: "Reports",
                    filter: {
                        type: "select",
                        options: {!!  json_encode(\Packages\Dashboard\App\Helpers\CrudHelper::getYesNoList()) !!},
                    }
                },
            ],
            sort: {
                attr: 'id',
                dir: 'desc'
            },
            rowActions: aGridExt.defaultRowActions({
                baseUrl: '{{ route("threads.comments.index", [], false) }}',
            }),
            theadPanelCols: {
                pager: 'col-sm-4',
                actions: 'col-sm-8'
            }
        });
    });
</script>
@endsection
