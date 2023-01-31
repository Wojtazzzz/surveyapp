@extends('layouts.layout')

@section('title', 'Create new Survey')

@section('content')
    <div class="w-full flex flex-col justify-center gap-5">
        <h2 class="text-3xl text-center font-bold">Create new Survey</h2>

        <div class="container mx-auto">
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

            <form method="POST" action="{{ route('surveys.store') }}">
                @csrf
                @method('POST')
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                    <input type="text" id="name" name="name"
                        class="@error('name')
                        text-red-900 border-red-500 focus:border-red-500 placeholder-red-700 focus:ring-red-500
                        @enderror border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                        placeholder="Example Survey" value="{{ old('name') }}" required>
                </div>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto text-center p-3">Submit</button>
            </form>
        </div>
    </div>
@endsection
