<x-admin-master>

@section('content')
    <h1>Show Post</h1>
        <div class="form-group">
            <label>Post Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter Title" value="{{$post->title}}" readonly/>

        </div>

        <div class="form-group">
            <label>Post Excerpt</label>
            <input type="text" name="excerpt" class="form-control" placeholder="Enter Excerpt" value="{{$post->excerpt}}" readonly />

        </div>

        <div class="form-group">
            <div><img src="{{asset($post->thumbnail)}}" width="340px" /></div>
            <label>Post Image</label>
            <input type="file" name="thumbnail" class="form-control-file">

        </div>

        <div class="form-group">
            <label>Post Body</label>
            <textarea name="body" class="form-control" cols=30 rows=10 required>{{$post->body}}</textarea>
        </div>

        <div class="form-group">
            <label>Post Category</label>
            <select name="category_id" class="form-control" style="width: 15%;">
                @foreach($categories as $category)
                    <option value="{{$category->id}}" {{$category->id == $post->category_id ? 'selected' : ''}}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>

        <a href="{{route('post.index')}}" class="btn btn-primary">Back</a>
    </form>
@endsection
</x-admin-master>