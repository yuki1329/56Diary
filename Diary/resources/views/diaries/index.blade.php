@extends('layouts.app')

@section('title', '一覧')

@section('content')
  <a href="{{ route('diary.create') }}" class="btn btn-primary btn-block">新規投稿</a>
   @foreach ($diaries as $diary)
   <div class="m-4 p-4 border border-primary">
   <p>{{$diary->title}}</p>
   <p>{{$diary->body}}</p>
   <p>{{$diary->created_at}}</p>
   {{-- Auth::check() : ログインしていたらtrue,他はfalse --}}
   @if (Auth::check() && $diary->user_id == Auth::user()->id)

   {{-- edit --}}
   <a href="{{route('diary.edit',['id' =>$diary->id])}}"  class="btn btn-success">編集</a>
<!-- //delete -->
   <form action="{{ route('diary.destroy',['id' => $diary->id]) }}" method="POST" class="d-inline">
   @csrf
   @method('delete')
   <button class="btn btn-danger">削除</button>
</form>

   @endif
   <div class="mt-3 ml-3">
      <i class="far fa-heart fa-lg text-danger js-like"></i>
   <input type="hidden" class="diary-id" value="{{ $diary->id }}">
      <span class="js-like-num">200</span>
   </div>
   </div>
   @endforeach

   @endsection