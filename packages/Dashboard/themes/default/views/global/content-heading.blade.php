@section('title', $heading['title'] . ' - ' . trans('dashboard::dashboard.dashboard'))

@section('action_area')
    @if(array_key_exists('action_area', $heading))
        {!! $heading['action_area'] !!}
    @endif

    @if(!empty($action_area))
        {!! $action_area !!}
    @endif
@endsection

@section('heading_right')
    @if(array_key_exists('heading_right', $heading))
        {!! $heading['heading_right'] !!}
    @endif
@endsection

@section('heading_row_before_table')
    @if(array_key_exists('heading_row_before_table', $heading))
        {!! $heading['heading_row_before_table'] !!}
    @endif
@endsection

@if(isset($page_heading_top))
@section('page_heading_top')
    {!! $page_heading_top !!}
@endsection
@endif
@if(isset($page_heading_bottom))
@section('page_heading_bottom')
    {!! $page_heading_bottom !!}
@endsection
@endif
