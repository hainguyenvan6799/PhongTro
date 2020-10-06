@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Post Form</div>

                <div class="card-body">
                    <form method="POST" action="{{route('Post.save')}}">
                    	{{csrf_field()}}
                    	<div class="form-group">
                    	<label for="title">Title: </label>
                    	<input type="text" name="title" class="form-control" id="title">
                    </div>

                    <div class="form-group">
                    	<label for="content">Content: </label>
                    	<textarea class="form-control" name="content" id="content"></textarea>
                    </div>
                    <input type="submit" name="submit" value="Save">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
