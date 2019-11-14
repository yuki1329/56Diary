
<!-- layout.blade.phpを読み込む -->
  @extends('layout')
  @section('title')
  一覧
  @endsection


    @section('content')

    <a href="{{route('diary.create')}}" class="btn btn-primary btn-block">新規投稿</a>
    @foreach($diaries as $diary)
    @endforeach
    @endsection