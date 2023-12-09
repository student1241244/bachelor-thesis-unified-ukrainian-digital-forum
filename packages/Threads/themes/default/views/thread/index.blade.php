<table class="table table-striped dataTable no-footer table-hover agrid" id="items-grid"></table>

@section('footer-extras')
@parent
<script>
    $(function () {

        var tableAgrid = $('#items-grid').aGrid({
            url: '{{ route("threads.threads.index", [], false) }}',
            permissions: {
                update: {{ can('threads.threads.update') ? 1 : 0 }},
                destroy: {{ can('threads.threads.destroy') ? 1 : 0 }},
            },
            columns: [
				{
					name: "id",
					label: "#",
				},
                {
                    name: "title",
                    label: "{{ __('threads::thread.attributes.title') }}",
                },
				{
					name: "image",
					label: "{{ __('threads::thread.attributes.image') }}",
					filter: false,
					sortable: false,
					render: function(value) {
						return aGridExt.renderImage(value)
					}
				},
                {
                    name: "category_title",
                    label: "{{ __('threads::thread.attributes.category_id') }}",
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
                baseUrl: '{{ route("threads.threads.index", [], false) }}',
            }),
            theadPanelCols: {
                pager: 'col-sm-4',
                actions: 'col-sm-8'
            }
        });
    });
</script>
@endsection
