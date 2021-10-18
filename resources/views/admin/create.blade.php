
<x-admin-master>
@if(session()->has('imageMsg'))
    <div class="alert alert-success">
        {{ session()->get('imageMsg') }}
    </div>
@endif
    @section('content')
        <h1>Create Post</h1>
        <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Post Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter Title" value="{{old('title')}}" required />

                @error('title')
                    <p class="text-red-500 text-sm mt-2">
                        {{$message}}
                    </p>
                @enderror
            </div>

            <div class="form-group">
                <label>Post Excerpt</label>
                <input type="text" name="excerpt" class="form-control" placeholder="Enter Excerpt" value="{{old('excerpt')}}" required />

                @error('excerpt')
                    <p class="text-red-500 text-sm mt-2">
                        {{$message}}
                    </p>
                @enderror
            </div>

            <div class="form-group">
                <label>Post Image</label>
                <input type="file" name="thumbnail" class="form-control-file">

                @error('thumbnail')
                    <p class="text-red-500 text-sm mt-2">
                        {{$message}}
                    </p>
                @enderror
            </div>

            <div class="form-group">
                <label>Post Body</label>
                <textarea name="body" class="form-control" cols=5 rows=10 value="{{old('body')}}" required></textarea>

                @error('body')
                    <p class="text-red-500 text-sm mt-2">
                        {{$message}}
                    </p>
                @enderror
            </div>

            <div class="form-group">
                <label>Post Category</label>
                <select name="category_id" class="form-control" style="width: 15%;">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            <input type="submit" class="btn btn-primary" name="Submit"/>
            <a href="{{route('post.index')}}" class="btn btn-primary ml-4">Back</a>
        </form>
    @endsection
</x-admin-master>