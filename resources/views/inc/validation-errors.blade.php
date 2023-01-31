@if ($errors->any())
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    <span class="font-medium">Error!</span> {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
