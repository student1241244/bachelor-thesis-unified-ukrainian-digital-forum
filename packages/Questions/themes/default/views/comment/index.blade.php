<table class="table table-striped dataTable no-footer table-hover agrid" id="items-grid"></table>

@section('footer-extras')
@parent
<script>
    $(function () {

        var tableAgrid = $('#items-grid').aGrid({
            url: '{{ route("questions.comments.index", [], false) }}',
            permissions: {
                update: {{ can('questions.comments.update') ? 1 : 0 }},
                destroy: {{ can('questions.comments.destroy') ? 1 : 0 }},
            },
            columns: [
				{
					name: "id",
					label: "#",
				},
				{
					name: "question_title",
					label: "{{ __('questions::comment.attributes.question_id') }}",
				},
				{
					name: "user_title",
					label: "{{ __('questions::comment.attributes.user_id') }}",
				},
				{
					name: "body",
					label: "{{ __('questions::comment.attributes.body') }}",
				},
				{
					name: "images",
					label: "{{ __('questions::comment.attributes.images') }}",
					filter: false,
					sortable: false,
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
                baseUrl: '{{ route("questions.comments.index", [], false) }}',
            }),
            theadPanelCols: {
                pager: 'col-sm-4',
                actions: 'col-sm-8'
            }
        });
    });
</script>
@endsection
