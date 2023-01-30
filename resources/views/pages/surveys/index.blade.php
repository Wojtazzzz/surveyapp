@extends('layouts.layout')

@section('title', 'List of surveys')

@section('content')
    <div class="w-full flex flex-col justify-center gap-5">
        <h1 class="text-3xl text-center font-bold">List of Surveys</h1>

        <div class="ml-auto">
            <a href="/survey/create"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">New
                Survey</a>
        </div>

        @empty($surveys[0])
            <span class="text-center text-lg mt-5 font-medium">There are no Surveys in the App. You can create new one by click
                on button
                above</span>
        @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 md:px-6 py-1 md:py-3 text-center text-base md:text-lg lg:text-xl">
                                Name
                            </th>
                            <th scope="col" class="px-4 md:px-6 py-1 md:py-3 text-center text-base md:text-lg lg:text-xl">
                                Status
                            </th>
                            <th scope="col" class="px-4 md:px-6 py-1 md:py-3 text-center text-base md:text-lg lg:text-xl">
                                Created at
                            </th>
                            <th scope="col" class="px-4 md:px-6 py-1 md:py-3 text-center text-base md:text-lg lg:text-xl">
                                Questions
                            </th>
                            <th scope="col" class="px-4 md:px-6 py-1 md:py-3 text-center text-base md:text-lg lg:text-xl">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surveys as $survey)
                            <tr @class([
                                'text-center border-b',
                                'bg-white' => $loop->odd,
                                'bg-gray-50' => $loop->even,
                            ])>
                                <th scope="row"
                                    class="px-4 md:px-6 py-1 md:py-4 text-sm md:text-base font-medium text-gray-900 whitespace-nowrap">
                                    {{ $survey->name }} </th>
                                <td class="px-4 md:px-6 py-1 md:py-4 text-sm md:text-base uppercase">
                                    {{ $survey->status }}
                                </td>
                                <td class="px-4 md:px-6 py-1 md:py-4 text-sm md:text-base whitespace-nowrap">
                                    {{ $survey->created_at }}
                                </td>
                                <td class="px-4 md:px-6 py-1 md:py-4 text-sm md:text-base">
                                    <a href="/survey/questions/{{ $survey->id }}" class="underline">Link</a>
                                </td>
                                <td class="px-4 md:px-6 py-1 md:py-4 text-sm md:text-base">
                                    <div class="flex gap-2 items-center justify-center">

                                        <a href="/survey/edit/{{ $survey->id }}"
                                            class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">Edit</a>

                                        <button type="button"
                                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">Delete</button>
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
