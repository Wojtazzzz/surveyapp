@extends('layouts.layout')

@section('title', 'List of Questions')

@section('content')
    <div class="w-full flex flex-col justify-center gap-6">
        <h2 class="text-3xl text-center font-bold">List of Questions</h2>

        <div class="ml-auto">
            <a href="/survey/question-create/{{ $survey->id }}"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">New
                Question</a>
        </div>

        @empty($questions[0])
            <span class="text-center text-lg mt-5 font-medium">There are no Questions within this Survey. You can create new one
                by click
                on button
                above</span>
        @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 md:px-6 py-1 md:py-3 text-center text-base md:text-lg lg:text-xl">
                                Position
                            </th>
                            <th scope="col" class="px-4 md:px-6 py-1 md:py-3 text-center text-base md:text-lg lg:text-xl">
                                Content
                            </th>
                            <th scope="col" class="px-4 md:px-6 py-1 md:py-3 text-center text-base md:text-lg lg:text-xl">
                                Type
                            </th>
                            <th scope="col" class="px-4 md:px-6 py-1 md:py-3 text-center text-base md:text-lg lg:text-xl">
                                Options
                            </th>
                            <th scope="col" class="px-4 md:px-6 py-1 md:py-3 text-center text-base md:text-lg lg:text-xl">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr @class([
                                'text-center border-b',
                                'bg-white' => $loop->odd,
                                'bg-gray-50' => $loop->even,
                            ])>
                                <th scope="row"
                                    class="px-4 md:px-6 py-1 md:py-4 text-sm md:text-base font-medium text-gray-900 whitespace-nowrap">
                                    {{ $question->position }} </th>
                                <td class="px-4 md:px-6 py-1 md:py-4 text-sm md:text-base uppercase">
                                    {{ $question->content }}
                                </td>
                                <td class="px-4 md:px-6 py-1 md:py-4 text-sm md:text-base whitespace-nowrap">
                                    {{ $question->type }}
                                </td>
                                <td class="px-4 md:px-6 py-1 md:py-4 text-sm md:text-base">
                                    <a href="/survey/question-options/{{ $survey->id }}/{{ $question->id }}"
                                        class="underline">Link</a>
                                </td>
                                <td class="px-4 md:px-6 py-1 md:py-4 text-sm md:text-base">
                                    <div class="flex gap-2 items-center justify-center">

                                        <a href="/survey/question-edit/{{ $survey->id }}/{{ $question->id }}"
                                            class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">Edit</a>

                                        <form action="/survey/question-delete/{{ $survey->id }}/{{ $question->id }}}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5"
                                                onclick="return confirm('Are you sure you want to delete this Question?');">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endempty
    </div>
@endsection
