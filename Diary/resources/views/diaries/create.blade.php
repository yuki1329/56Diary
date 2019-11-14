@extends('layout')

  @section('title','新規投稿')

  @section('content')
    <section class="container m-5">
        <div class="row justify-content-center">
            <div cwlass="col-8">

            @if($errors->any())
            <ul>

            @foreach($errors->all() as $message)
              <li class="alert alert-danger">
              {{$message}}
              </li>
            @endforeach

            </ul>

            @endif

            <form action="{{ route('diary.store') }}" method="POST">
            <!-- 外部からのアクセス をされないためにするもの 勝手にトークンが生成されてそのトークンがなかったり書き換えられていたらエラーが出るようにする -->
            @csrf
            <div class="form-group">

            <label for="title">タイトル</label>
            <input type="text" class="form-control" id='title' name="title" value="{{old('title')}}">
            </div>

            <div class="form-group">

            <label for="body">本文</label>
            <textarea class="form-control" id="body" name="body">{{old('body')}}</textarea>
            </div>

            <div class="text-light">

            <button type="submit" class="btn btn-primary">投稿</button>
            </div>

            </form>
            </div>
        </div>
    </section>
</body>
</html>
@endsection