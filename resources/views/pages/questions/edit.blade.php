@extends('layouts.layout')

@section('title', 'Edit Question')

@section('content')
    <div class="w-full flex flex-col justify-center gap-5">
        <h2 class="text-3xl text-center font-bold">Edit Question</h2>

        <div class="container mx-auto">
            @include('inc.validation-errors')

            <form method="POST"
                action="{{ route('surveys.questions.update', ['survey' => $survey, 'question' => $question]) }}">
                @csrf
                @method('PATCH')
                <div class="mb-6">
                    <label for="name" class="block mb-1 text-sm font-medium text-gray-900">Survey</label>
                    <input type="text" id="name" class="input-readonly" value="{{ $survey->name }}" disabled readonly>
                </div>

                <div class="mb-6">
                    <label for="position" class="block mb-1 text-sm font-medium text-gray-900">Position</label>
                    <select id="position" name="position" class="input @error('name') input-invalid @enderror">
                        @foreach ($survey->questions as $surveyQuestion)
                            <option value="{{ $surveyQuestion->position }}" @selected(old('position', $question->position) === $surveyQuestion->position)>
                                {{ $surveyQuestion->position }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="content" class="block mb-2 text-sm font-medium text-gray-900">Content</label>
                    <textarea id="content" rows="4" name="content" class="input @error('name') input-invalid @enderror"
                        placeholder="Lorem ipsum dolot sit amet...">{{ old('content', $question->content) }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="type" class="block mb-1 text-sm font-medium text-gray-900">Type</label>
                    <select id="type" name="type" class="input @error('name') input-invalid @enderror">
                        <option value="Single choice" selected @selected(old('type', $question->type) === 'Single choice')>Single choice</option>
                        <option value="Multiple choice" @selected(old('type', $question->type) === 'Multiple choice')>Multiple choice</option>
                    </select>
                </div>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto text-center p-3">Submit</button>
            </form>
        </div>
    </div>
@endsection
