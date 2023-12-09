<script src="/{{ config('tpx_dashboard.public_resources') }}/redactor/redactor.min.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/redactor/_plugins/table/table.min.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/redactor/_plugins/alignment/alignment.min.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/redactor/_plugins/video/video.min.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/redactor/_plugins/fontcolor/fontcolor.min.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/redactor/_plugins/fontfamily/fontfamily.min.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/redactor/_plugins/fontsize/fontsize.min.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/redactor/_plugins/properties/properties.min.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/redactor/_plugins/columns/columns.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/redactor/_plugins/quote/quote.js"></script>
@if(app('translator')->getLocale() != 'en')
    <script src="/{{ config('tpx_dashboard.public_resources') }}/redactor/_langs/{{app('translator')->getLocale()}}.js"></script>
@endif
<script>
    $R.options = {
        buttons        : [
            'html',
            'format',
            'bold',
            'italic',
            'underline',
            'fontcolor',
            'fontfamily',
            'fontsize',
            'lists',
            'image',
            'video',
            'link',
            'table',
            'undo',
            'redo',
            'line',
        ],
        lang           : '{{app('translator')->getLocale()}}',
        imageUpload    : '{!!route('dashboard.media.redactorjs')!!}',
        imagePosition  : true,
        imageResizable : true,
        imageLink      : true,
        imageData      : {
            _token : '{!!csrf_token()!!}'
        },
        plugins        : ['table', 'alignment', 'video', 'fontcolor', 'fontsize', 'properties', 'columns', 'quote']
    };

    jQuery(function ($) {
        $('[data-redactor-input-full]').each(function() {
            tpx_init_redactor(this);
        });
        $('[data-redactor-input-min]').each(function() {
            tpx_init_redactor(this, true);
        });
    });

    function tpx_init_redactor(elem, min) {
        let $this = $(elem),
            $form = $this.closest('form'),
            $redactor,
            options = {};

        min = min||false;

        if(min) {
            options.buttons = ['bold', 'italic', 'underline', 'link', 'undo', 'redo'];
            options.plugins = [];
        }

        $redactor = $this.redactor(options);

        $form.on('submit', function () {
            $redactor.broadcast('hardsync');
        });
    }
</script>
