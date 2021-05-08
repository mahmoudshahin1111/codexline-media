<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Upload Video") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="p-6 bg-white border-b border-gray-200 flex flex-row align-center justify-center"
                >
                    <form
                        class="flex flex-col w-6/12"
                        action="{{ route('video.createOne') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="m-2 flex flex-col">
                            <label for="">Name</label>
                            <input
                                type="text"
                                name="name"
                                class="rounded rounded-lg"
                                value="{{ old('name') }}"
                            />
                        </div>
                        <label
                            for=""
                            class="border-2 rounded rounded-lg bg-blue-400 color-white text-center"
                        >
                            <input
                                class=""
                                type="file"
                                name="video"
                                title="Choose Your Next Video"
                            />
                            Choose Your File
                        </label>

                        @if($errors->any())
                        <ul class="flex flex-col bg-red-200 text-dark">
                            @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        <button
                            type="submit"
                            class="border-2 rounded rounded-lg bg-blue-400"
                        >
                            Start Upload
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    <script>
        $(document).ready(function () {
            $("form").on("submit", function (e) {
                e.preventDefault();
                alert('{{__("Please Wait Until File Uploaded")}}');
                $(e.currentTarget).unbind();
                $(e.currentTarget).submit();
            });
        });
    </script>
    @endpush
</x-app-layout>
