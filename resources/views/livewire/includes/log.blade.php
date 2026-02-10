<code>
    @if(Session::has('messages'))
        <ul>
            @foreach(Session::get('messages') as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif
</code>