@extends('user.reservasi')

@section('content')
    <section class="flex flex-col grow gap-4 p-6 bg-white  border-2 rounded-lg shadow-md w-1/2">
        <div class="flex justify-between">
            <h1 class="text-xl font-medium">Pilih Ruangan</h1>
            <div class="flex justify-end gap-3 my-auto">
                <form class="flex">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute top-3 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" id="search"
                            class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                            placeholder="Cari Ruangan..." required>
                    </div>
                </form>
                @include('user.partials.components.dropdown')
                <button type="button"
                    class="text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-5 py-3">
                    ...
                </button>
            </div>
        </div>
        <form method="POST" action="{{ route('reservation2.store') }}">
            @csrf
            <div class="grid grid-cols-3 gap-4 ">
                @foreach ($rooms as $room)
                    <x-dashboard.card-room status="kosong" :name="$room->name" :image="$room->image" :capacity="$room->capacity"
                        :code="$room->code" :floor="$room->floor" :id="$room->id" />
                @endforeach
                <input type="text" id="room_id" hidden name="room_id">
            </div>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-10 text-white py-3 mt-10 ">
                Pilih
            </button>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let bookingButtons = document.querySelectorAll('.bookBtn');
            let selectedButton = null;

            bookingButtons.forEach((button) => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const input = document.getElementById('room_id');

                    if (button === selectedButton) {
                        // The button was already selected. Deselect it and re-enable all buttons.
                        button.classList.remove('bg-green-500');
                        button.classList.add('bg-gray-800');
                        bookingButtons.forEach((btn) => {
                            btn.disabled = false;
                            btn.classList.remove('bg-gray-400');
                            btn.classList.add('bg-gray-800');
                        });
                        selectedButton = null;
                        input.value = '';
                    } else {
                        // A new button was selected. Disable all other buttons.
                        bookingButtons.forEach((btn) => {
                            btn.disabled = true;
                            btn.classList.remove('bg-green-500');
                            btn.classList.add('bg-gray-400');
                        });
                        // Select the clicked button.
                        button.disabled = false;
                        button.classList.remove('bg-gray-400');
                        button.classList.add('bg-green-500');
                        selectedButton = button;
                        input.value = button.id.replace('bookBtn', '');
                    }
                });
            });
        });
    </script>
@endsection
