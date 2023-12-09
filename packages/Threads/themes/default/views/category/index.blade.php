<table class="table table-striped dataTable no-footer table-hover agrid" id="items-grid"></table>

@section('footer-extras')
@parent
<script>
    $(function () {

        var tableAgrid = $('#items-grid').aGrid({
            url: '{{ route("threads.categories.index", [], false) }}',
            permissions: {
                update: {{ can('threads.categories.update') ? 1 : 0 }},
                destroy: {{ can('threads.categories.destroy') ? 1 : 0 }},
            },
            columns: [
				{
					name: "id",
					label: "#",
				},
				{
					name: "title",
					label: "{{ __('threads::category.attributes.title') }}",
				},
            ],
            sort: {
                attr: 'id',
                dir: 'asc'
            },
            rowActions: aGridExt.defaultRowActions({
                baseUrl: '{{ route("threads.categories.index", [], false) }}',
            }),
            theadPanelCols: {
                pager: 'col-sm-4',
                actions: 'col-sm-8'
            }
        });
    });
</script>
@endsection
