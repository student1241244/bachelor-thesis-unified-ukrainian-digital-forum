<table class="table table-striped dataTable no-footer table-hover agrid" id="items-grid"></table>

@section('footer-extras')
@parent
<script>
    $(function () {

        var tableAgrid = $('#items-grid').aGrid({
            url: '{{ route("dashboard.translations.index", [], false) }}',
            permissions: {
                update: {{ can('dashboard.translations.update') ? 1 : 0 }},
                destroy: {{ can('dashboard.translations.destroy') ? 1 : 0 }},
            },
            columns: [
				{
					name: "id",
					label: "#",
				},
                {
                    name: "group",
                    label: "{{ __('dashboard::translation.attributes.group') }}",
                },
                {
                    name: "key",
                    label: "{{ __('dashboard::translation.attributes.key') }}",
                },
                {
                    name: "text",
                    label: "{{ __('dashboard::translation.attributes.text') }}",
                    sortable: false,
                },
            ],
            sort: {
                attr: 'id',
                dir: 'desc'
            },
            rowActions: aGridExt.defaultRowActions({
                baseUrl: '{{ route("dashboard.translations.index", [], false) }}',
            }),
            theadPanelCols: {
                pager: 'col-sm-4',
                actions: 'col-sm-8'
            }
        });
    });
</script>
@endsection
