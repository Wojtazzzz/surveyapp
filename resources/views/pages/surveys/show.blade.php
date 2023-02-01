@extends('layouts.layout')

@section('title', substr($survey->name, 0, 32))

@section('content')
    <div class="w-full flex flex-col justify-center gap-7">
        <h2 class="text-3xl text-center font-bold">{{ $survey->name }}</h2>

        <div class="container max-w-4xl mx-auto">
            <form action="#" class="flex flex-col gap-5">
                @forelse ($survey->questions as $question)
                    <p class="text-lg">
                        <span class="text-gray-700/60">
                            {{ $loop->index + 1 }}.
                        </span>
                        <span class="text-black font-medium">{{ $question->content }}</span>
                        @if ($survey->status->name === 'TESTING')
                            <span class="text-gray-700/60 text-sm">
                                ID {{ $question->id }}
                            </span>
                        @endif
                    </p>

                    <div>
                        @switch($question->type->name)
                            @case('SINGLE_CHOICE')
                                @foreach ($question->options as $option)
                                    <div class="flex items-center mb-4">
                                        <input type="radio" name="question-{{ $question->id }}" value="{{ $option->id }}"
                                            id="{{ $option->id }}" @checked($loop->first)
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus-visible:ring-blue-500 focus:outline-none focus-visible:ring-2">
                                        <label for="{{ $option->id }}"
                                            class="ml-2 text-sm font-medium text-gray-900">{{ $option->title }}</label>
                                        @if ($survey->status->name === 'TESTING')
                                            <span class="text-gray-700/60 ml-1">
                                                ID {{ $option->id }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            @break

                            @case('MULTIPLE_CHOICE')
                                @foreach ($question->options as $option)
                                    <div class="flex items-center mb-4">
                                        <input id="{{ $option->id }}" @checked($loop->first) type="checkbox"
                                            name="question-{{ $question->id }}" value="{{ $option->id }}"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus-visible:ring-blue-500 focus:outline-none focus-visible:ring-2">
                                        <label for="{{ $option->id }}"
                                            class="ml-2 text-sm font-medium text-gray-900">{{ $option->title }}</label>
                                        @if ($survey->status->name === 'TESTING')
                                            <span class="text-gray-700/60 ml-1">
                                                ID {{ $option->id }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            @break

                            @default
                                <span class="text-3xl text-center">Sorry, there is error with determining question type</span>
                            @break
                        @endswitch
                    </div>
                    @empty
                        <span class="text-3xl text-center">
                            This Survey has no Questions
                        </span>
                    @endforelse

                    @isset($survey->questions[0])
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto text-center p-3">Submit</button>
                    @endisset
                </form>
            </div>
        </div>
    @endsection
