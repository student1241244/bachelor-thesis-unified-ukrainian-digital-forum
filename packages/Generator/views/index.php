<table class="table table-striped dataTable no-footer table-hover agrid" id="items-grid"></table>

@section('footer-extras')
@parent
<script>
    $(function () {

        var tableAgrid = $('#items-grid').aGrid({
            url: '{{ route("<?= $packageNameSnake?>.<?= $modelNameForRoute?>.index", [], false) }}',
            permissions: {
                update: {{ can('<?= $packageNameSnake?>.<?= $modelNameForRoute?>.update') ? 1 : 0 }},
                destroy: {{ can('<?= $packageNameSnake?>.<?= $modelNameForRoute?>.destroy') ? 1 : 0 }},
            },
            columns: [
<?= $rawColumns?>
            ],
            sort: {
                attr: 'id',
                dir: 'asc'
            },
            rowActions: aGridExt.defaultRowActions({
                baseUrl: '{{ route("<?= $packageNameSnake?>.<?= $modelNameForRoute?>.index", [], false) }}',
            }),
            theadPanelCols: {
                pager: 'col-sm-4',
                actions: 'col-sm-8'
            }
        });
    });
</script>
@endsection
