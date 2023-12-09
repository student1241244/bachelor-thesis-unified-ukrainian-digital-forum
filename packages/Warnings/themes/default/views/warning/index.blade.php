<table class="table table-striped dataTable no-footer table-hover agrid" id="items-grid"></table>

@section('footer-extras')
@parent
<script>
    $(function () {

        var tableAgrid = $('#items-grid').aGrid({
            url: '{{ route("warnings.warnings.index", [], false) }}',
            permissions: {
                update: {{ can('warnings.warnings.update') ? 1 : 0 }},
                destroy: {{ can('warnings.warnings.destroy') ? 1 : 0 }},
            },
            columns: [
				{
					name: "id",
					label: "#",
				},
				{
					name: "user_title",
					label: "{{ __('warnings::warning.attributes.user_id') }}",
				},
				{
					name: "body",
					label: "{{ __('warnings::warning.attributes.body') }}",
				},
            ],
            sort: {
                attr: 'id',
                dir: 'desc'
            },
            rowActions: aGridExt.defaultRowActions({
                baseUrl: '{{ route("warnings.warnings.index", [], false) }}',
            }),
            theadPanelCols: {
                pager: 'col-sm-4',
                actions: 'col-sm-8'
            }
        });
    });
</script>
@endsection
