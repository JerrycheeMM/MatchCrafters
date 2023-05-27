@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

            @if(session()->has('failures'))
                @foreach (session()->get('failures') as $failure)
                    <span>Row #{{ $failure->row() }}</span>
                    <ul>
                        @foreach ($failure->errors() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                @endforeach
            @endif
        </ul>
    </div>
@endif

@if(session()->has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ session()->get('success') }}</li>
        </ul>
    </div>
@endif