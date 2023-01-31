@extends('layouts.layout')

@section('title', 'Create new Option')

@section('content')
    <div class="w-full flex flex-col justify-center gap-5">
        <h2 class="text-3xl text-center font-bold">Create new Option</h2>

        <div class="container mx-auto">
            @include('inc.validation-errors')

            <form method="POST"
                action="{{ route('questions.options.store', ['survey' => $survey, 'question' => $question]) }}">
                @csrf
                @method('POST')
                <div class="mb-6">
                    <label for="name" class="block mb-1 text-sm font-medium text-gray-900">Question</label>
                    <input type="text" id="name" class="input-readonly"
                        value="{{ substr($question->content, 0, 16) }}" disabled readonly>
                </div>

                <div class="mb-6">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                    <input type="text" id="title" name="title" class="input @error('name') input-invalid @enderror"
                        placeholder="Example Title" value="{{ old('title') }}" required>
                </div>


                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto text-center p-3">Submit</button>
            </form>
        </div>
    </div>
@endsection
