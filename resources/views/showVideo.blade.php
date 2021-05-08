<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $video->id.'#'.$video->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="p-6 bg-white border-b border-gray-200 flex flex-row align-center justify-center"
                >
                    <video
                        autoplay
                        controls
                        src="{{$video->fullUrl}}"
                        height="500"
                        width="500"
                    ></video>
                </div>

                <div class="flex flex-row gap-10 justify-center">
                    <form
                        action="{{route('video.like',$video->id)}}"
                        method="POST"
                        class="w-3/12 flex flex-row"
                    >
                        @csrf
                        <button
                            class="
                            @if(isset($likeStatus) && $likeStatus === 'like') bg-blue-100 @endif
                            w-full border-2 text-center font-bold text-xl"
                            type="submit"
                        >
                            Like
                            <span
                                class="inline-block rounded-full bg-green-100 p-2"
                            >
                                {{ $likes }}
                            </span>
                        </button>
                    </form>
                    <form
                        action="{{route('video.dislike',$video->id)}}"
                        method="POST"
                        class="w-3/12 flex flex-row"
                    >
                        @csrf

                        <button
                            class="
                            @if(isset($likeStatus) && $likeStatus === 'dislike') bg-blue-100 @endif
                            w-full border-2 text-center font-bold text-xl"
                            type="submit"
                        >
                            Dislike
                            <span
                                class="inline-block rounded-full bg-green-100 p-2"
                            >
                                {{ $dislikes }}
                            </span>
                        </button>
                    </form>
                    @if($video->isOwner)
                    <form
                        action="{{route('video.removeOne',$video->id)}}"
                        method="POST"
                        class="w-3/12 flex flex-row"
                    >
                        @csrf @method('DELETE')
                        <button
                            class="w-full border-2 text-center font-bold text-xl bg-red-50"
                            type="submit"
                        >
                            Delete
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
