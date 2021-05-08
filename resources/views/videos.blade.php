<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Videos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-col flex-nowrap">
                    <div class="flex flex-row flex-wrap justify-center gap-10">
                        @foreach ($videos as $video)
                        <div class="flex flex-col w-3/12 h-56">
                            <div class="w-full video-template"
                                    data-src="{{$video->fullUrl}}"
                                    data-sample="{{$video->sampleUrl}}"
                                    data-thumbnail="{{$video->thumbnailUrl}}"
                                    data-loading="false"
                            >
                                <a
                                href="{{route('video.showOne',$video->id)}}"
                                >
                                    <img
                                    src="{{$video->thumbnailUrl}}"
                                    alt="{{$video->name}}"
                                    width="500"
                                    height="500"
                                    >
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{$videos->links()}}
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        $(document).ready(function() {
            $('.video-template').mouseenter(function(e) {
                if($(e.currentTarget).attr('data-loading') === 'false'){
                    $(e.currentTarget).attr('data-loading','true');
                    setTimeout(() => {
                    const sampleUrl = $(e.currentTarget).attr('data-sample');
                    const video= document.createElement('video');
                    video.src = sampleUrl;
                    video.currentTime = 0;
                    video.autoplay = true;
                    video.muted = true;
                    video.width="500";
                    $(e.currentTarget).find('a').fadeOut(function(){
                        $(e.currentTarget).find('video').remove();
                        $(e.currentTarget).append(video);
                    });
                    }, 800);
                }

            });
            $('.video-template').mouseleave(function(e) {

                $(e.currentTarget).find('video').remove();
                    $(e.currentTarget).find('a').fadeIn();
                    $(e.currentTarget).attr('data-loading','false');
            });
        })
    </script>
    @endpush
</x-app-layout>
