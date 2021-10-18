<x-welcome-master>
    @section('content')
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            @foreach($posts as $post)
                    <div class="p-6">
                        <div class="flex items-center">
                            <img width="80%" src="{{asset($post->thumbnail)}}" alt="Post Image">
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-lg leading-7 font-semibold">
                                <a href="javascript:void(0);" class="underline text-gray-900 dark:text-white">{{$post->title}}</a>
                            </div>
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                {{Str::limit($post->body, 50, '...')}}
                            </div>
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                <a href="{{route('home.show', $post->id)}}" class="btn-sm btn btn-info">Read More</a>
                            </div>
                        </div>
                        
                    </div>
                    <hr style="border:dotted;">
                
            @endforeach

            <div style="margin-bottom:25px;" class="flex justify-center mt-4 sm:items-center mb-18">
                <div class="text-center text-sm text-gray-500 mb-20">
                    <div class="flex items-center mb-18 border">
                        {{$posts->links()}}
                    </div>
                </div>
            </div>
        </div>
        
    @endsection
</x-welcome-master>