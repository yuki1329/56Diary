<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
//Diaryモデルを使用する宣言
use App\Diary;
//CreateDiaryを愛用する宣言
use App\Http\Requests\CreateDiary;
use Illuminate\Support\Facades\Auth;
class DiaryController extends Controller
{
    //一覧画面を表示する
public function index(){
    //diariesテーブルのデータを全権取得
    //取得した結果を画面で確認
    // $diaries = Diary::all();
    $diaries = Diary::with('likes')->orderBy('id','desc')->get();
    // dd($diaries);
    //dd():var_dump と die が同時に実行される
    //views/diaries/index.blade.phpを表示
    //フォルダ名、ファイル名(の以下blade.phpは除く)
    return view('diaries.index',[
        //連想配列 キー=>値
        'diaries' => $diaries
    ]);
    }
    //日記の作成画面を表示する
    public function create(){
        return view('diaries.create');
    }
    //新しい日記を保存する画面
    public function store(CreateDiary $request){
            //Diariyモデルのインスタンスを作成
                $diary = new Diary();
            //Diaryモデルを使って、DBに日記を保存
            //$diary->カラム名(DB)＝ カラムに設定したい値(create.blade.phpのカラム)
            $diary->title = $request-> title;
            $diary->body = $request-> body;
            //Auth::user( = 現在のログインユーザー情報を取得
            $diary->user_id = Auth::user()->id;
            //DBに保存実行
            $diary->save();
            //一覧ページにリダイレクト
            return redirect()->route('diary.index');
    }
            //日記を削除するためのメソッド
            public function destroy(int $id)
            {
                // dd($id);
                $diary = Diary::find($id);
                $diary->delete();
                //一覧画面にリダイレクト
                return redirect()->route('diary.index');
            }
            //編集画面を表示する
            public function edit(Diary $diary)
            {
                    //ログインユーザーが日記の投稿者かチェックする
                    if(Auth::user()->id != $diary->user_id){
                        //投稿者とユーザーが違う場合以下実行される
                        abort(403);
                    }
                    //受け取ったIDを元に日記を取得
                    // $diary = Diary::find($id);
                    //編集画面を返す、同時に画面に取得した日記を渡す。
                return view('diaries.edit',[
                    //連想配列 キー=>値
                    'diary' => $diary
                ]);
            }
            //日記を更新し、一覧画面にリダイレクトする
            //-$id : 編集対象の日記ID
            //-$request:リクエストの内容。ここに画面で入力された文字が格納されている。基本的にはstoreと同じ
            public function update(int $id, CreateDiary $request)
            {
                // dd($request->title);
                $diary= Diary::find($id);
                //ログインユーザーが日記の投稿者かチェックする
                if(Auth::user()->id != $diary->user_id){
                    //投稿者とユーザーが違う場合以下実行される
                    abort(403);
                }
                //取得した日記のタイトル、本文を書き換える。
                //$diary->カラム名　＝保存したい内容
                $diary->title = $request->title;
                $diary->body = $request->body;
                //Dbに保存
                $diary->save();
                //↑が終わった人→created_at,update_at　が変わっているか
                return redirect()->route('diary.index');
            }
                //いいねが押された時の処理
                public function like(int $id)
                {
                    //いいねされた日記の取得
                    $diary = Diary::find($id);
                    //Diary.php 9~16あたりに書いてあるlikesに紐もずく。attach:多対多のデータを登録するメソッド
                    $diary->likes()->attach(Auth::user()->id);
                    //通信が成功したことを返す
                    return response()->json(['success' => 'いいね完了！']);
                }
                //いいね解除が推された時の処理
                public function dislike(int $id)
                {
                    //いいね解除された日記の取得
                    $diary = Diary::find($id);
                    //detach:多対多のデータを解除するメソッド
                    $diary->likes()->detach(Auth::user()->id);
                    //通信が成功したことを返す
                    return response()->json(['success' => 'いいね解除完了！']);
                }
}