@extends('layouts.layout')

@section('title', 'Create new Survey')

@section('content')
    <div class="w-full flex flex-col justify-center gap-5">
        <h2 class="text-3xl text-center font-bold">Create new Survey</h2>

        <div class="container mx-auto">
            @include('inc.validation-errors')

            <form method="POST" action="{{ route('surveys.store') }}">
                @csrf
                @method('POST')
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                    <input type="text" id="name" name="name" class="input @error('name') input-invalid @enderror"
                        placeholder="Example Survey" value="{{ old('name') }}" required>
                </div>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto text-center p-3">Submit</button>
            </form>
        </div>
    </div>
@endsection
