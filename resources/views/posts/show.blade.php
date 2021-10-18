<x-welcome-master>
    @section('content')
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="">
                <div class="p-6">
                    <div class="flex items-center">
                        <img width="100%" src="{{asset($post->thumbnail)}}" alt="Post Image">
                    </div>

                    <div class="ml-12"> 
                        <div class=" text-lg leading-7 font-semibold">
                            <a href="javascript:void(0);" class="underline text-gray-900 dark:text-white">{{$post->title}}</a>
                        </div>
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            {{$post->excerpt}}
                        </div>
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            {{$post->body}}
                        </div>
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            {{Carbon\Carbon::parse($post->created_at)->diffForHumans()}}
                        </div>
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            <a class="btn btn-primary btn-sm" href="/">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-welcome-master>