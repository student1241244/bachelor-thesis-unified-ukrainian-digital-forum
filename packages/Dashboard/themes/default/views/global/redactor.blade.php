<script>
    jQuery(document).ready(function ($) {
        $('#{{App::getLocale()}}_body').redactor({
            lang : '{{App::getLocale()}}',
            buttons: ['bold', 'italic', 'unorderedlist', 'orderedlist']
        });
    });
</script>
