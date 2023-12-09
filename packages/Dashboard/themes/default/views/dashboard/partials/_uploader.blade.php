<input type="file"
    name="{{ !empty($multiple) ? $name . '[]' : $name}}"
    {!! !empty($accept)      ? ' accept="' . $accept.'"'              : '' !!}
    {!! !empty($method)      ? ' data-method="' . $method.'"'         : '' !!}
    {!! !empty($maxfilesize) ? ' data-maxfilesize="'.$maxfilesize.'"' : '' !!}
    {!! !empty($layout)      ? ' data-layout="'.$layout.'"'           : '' !!}
    {!! !empty($count)       ? ' data-count="'.$count.'"'             : '' !!}
    {!! !empty($multiple)    ? ' multiple'                            : '' !!}
>
