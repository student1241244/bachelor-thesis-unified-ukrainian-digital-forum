<table class="table table-striped dataTable no-footer table-hover agrid" id="items-grid"></table>

@section('footer-extras')
@parent
<script>
    $(function () {

        var tableAgrid = $('#items-grid').aGrid({
            url: '{{ route("questions.questions.index", [], false) }}',
            permissions: {
                update: {{ can('questions.questions.update') ? 1 : 0 }},
                destroy: {{ can('questions.questions.destroy') ? 1 : 0 }},
            },
            columns: [
				{
					name: "id",
					label: "#",
				},
				{
					name: "user_title",
					label: "{{ __('questions::question.attributes.user_id') }}",
				},
				{
					name: "title",
					label: "{{ __('questions::question.attributes.title') }}",
				},
                {
					name: "images",
					label: "{{ __('questions::question.attributes.images') }}",
					filter: false,
					sortable: false,
					render: function(value) {
						return aGridExt.renderImage(value)
					}
				},
				{
					name: "body",
					label: "{{ __('questions::question.attributes.body') }}",
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
                baseUrl: '{{ route("questions.questions.index", [], false) }}',
            }),
            theadPanelCols: {
                pager: 'col-sm-4',
                actions: 'col-sm-8'
            }
        });
    });
</script>
@endsection
