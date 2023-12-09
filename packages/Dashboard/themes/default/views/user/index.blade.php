<table class="table table-striped dataTable no-footer table-hover agrid" id="users-grid"></table>

@section('footer-extras')
@parent<script>
$(function () {

    var tableAgrid = $('#users-grid').aGrid({
        url: '{{ route("dashboard.users.index", [], false) }}',
        permissions: {
            update: {{ can('dashboard.users.update') ? 1 : 0 }},
            destroy: {{ can('dashboard.users.destroy') ? 1 : 0 }},
        },
        columns: [
			{
				name: 'id',
				label: "id"
			},
            /**
      		{
				name: 'image',
				label: "{{ __('dashboard::user.attributes.image') }}",
                render: function(value) {
                    return aGridExt.renderImage(value);
                },
                filter: false,
                sortable: false,
			},
            */
      		{
				name: 'email',
				label: "{{ __('dashboard::user.attributes.email') }}"
			},
			{
				name: 'username',
				label: "{{ __('dashboard::user.attributes.username') }}"
			},
			{
				name: 'role_id',
				label: "{{ __('dashboard::user.attributes.role_id') }}",
                filter: {
                    type: 'select',
                    options: {!!  json_encode(\Packages\Dashboard\App\Models\Role::getList()) !!},
                },
            },
            {
                name: 'is_ban',
                label: "{{ __('dashboard::user.attributes.is_ban') }}",
                filter: {
                    type: 'select',
                    options: {!!  json_encode(\Packages\Dashboard\App\Helpers\CrudHelper::getYesNoList()) !!},
                },
                render: function(value) {
                    return aGridExt.renderYesNo(value);
                },
            },
            {
                name: 'ban_to',
                label: "{{ __('dashboard::user.attributes.ban_to') }}",
                filter: false,
            },
          ],
        sort: {
            attr: 'id',
            dir: 'asc'
        },
        rowActions: aGridExt.defaultRowActions({
            baseUrl: '{{ route("dashboard.users.index", [], false) }}',
        }),
        theadPanelCols: {
            pager: 'col-sm-4',
            actions: 'col-sm-8'
        }
    });
});
</script>
@endsection
