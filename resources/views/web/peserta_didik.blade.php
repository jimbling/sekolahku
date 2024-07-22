@extends('components.frontend.app_statis')

@section('title', 'Direktori Peserta Didik')

@section('content')

    <div class="container mx-auto">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden p-5 mx-4 sm:mx-6 md:mx-8 lg:mx-10">


            <!-- Filter Form -->
            <form id="filterForm" class="flex flex-wrap gap-4 mb-8 items-end">
                <!-- Tahun Pelajaran -->
                <div class="flex-1 min-w-[200px]">
                    <label for="academic_year" class="block text-sm font-medium text-gray-700">Tahun Pelajaran</label>
                    <select id="academic_year" name="academic_year"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">Semua Tahun Pelajaran</option>
                        @foreach ($academicYears as $year)
                            <option value="{{ $year->id }}">
                                {{ $year->academic_year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kelas -->
                <div class="flex-1 min-w-[200px]">
                    <label for="classroom" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <select id="classroom" name="classroom"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">Semua Kelas</option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">
                                {{ $classroom->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="flex-none w-full sm:w-auto flex items-end">
                    <button type="button" id="filterButton"
                        class="w-full sm:w-auto px-4 py-2 bg-blue-500 text-white font-semibold rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm flex items-center justify-center space-x-2">
                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z"
                                clip-rule="evenodd" />
                        </svg>
                        <!-- Button Text -->
                        <span>Tampilkan</span>
                    </button>
                </div>
            </form>
            <!-- Alert Container -->
            <div id="alertContainer"
                class="hidden col-span-full text-center p-4 bg-yellow-100 text-yellow-800 border border-yellow-300 rounded-md relative">
                <button id="alertCloseButton" class="absolute top-2 right-2 text-yellow-800 hover:text-yellow-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <span id="alertMessage">Tidak ada hasil ditemukan.</span>
            </div>


            <div id="studentsCardsContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

            </div>

        </div>
    </div>

@endsection
