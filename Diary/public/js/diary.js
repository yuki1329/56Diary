$(document).on('click','.js-like',function(){
    ​
                //いいねされた日記のIDを取得したい
                //$(this)　：今回クリックされたiタグ（ハートマーク）
                //.siblings('xxx') :兄弟要素を取得する
                //val(); inputタグのvalueお値を取得する。
                let diaryId =$(this).siblings('.diary-id').val();
    ​
                //likeメソッドを実行
                like(diaryId,$(this));
    ​
    });
    ​
                //diaryId:いいねのする日記のID
                //clickedBtn: 今回クリックされたいいねアイコン
                function like(diaryId,clickedBtn){
                                                // ?にはIの数字が入るーーー？から置き換わる
                    $.ajax({
                            url:'diary/'+ diaryId +'/like',
                            type:'POST',
                            dataType:'json',
                            //CSRF対策の為、tokenを送信する.
                            headers:{
                                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                            }
                    }).done((data) => {
                        console.log(data);
                        //いいねの数を増やそう
                        //1,現在のいいね数を取得
                        //text(): <a>XXX</a>XXXの部分を取得
                        let num = clickedBtn.siblings('.js-like-num').text();
    ​
    ​
                        //numを数値に変換する
                        num =Number(num);
    ​
                        //２、１プラスした結果を設定する
                        //text(YYY); <a>XXX</a>XXXの部分をYYYに置き換える
                        clickedBtn.siblings('.js-like-num').text(num + 1);
    ​
    ​
                        //いいねのボタンの「デザイン」を変更
                        changeLikeBtn(clickedBtn);
    ​
    ​
                    }).fail((error) => {
                        console.log(error);
                    });
    ​
    }
    ​
                    //btn ：には色を変えたい、いいねアイコン。toggleClass〜があれば追加〜なければ削除
                    function changeLikeBtn(btn){
                        btn.toggleClass('far').toggleClass('fas');
                        btn.toggleClass('js-like').toggleClass('js-dislike');
                        //btn.toggleClass('far').toggleClass('fas');;;;;; も上の２行と同じ(メソッドチェーンと言うjqueryだけ)
                    }
    ​
                    //いいね解除の処理
                    $(document).on('click','.js-dislike',function(){
                        //いいね解除された日記のIDの取得
                        let diaryId =$(this).siblings('.diary-id').val();
    ​
                        //dislikeのメソッドの実行.
                        dislike(diaryId,$(this));
                    });
    ​
                    function dislike(diaryId,clickedBtn){
                        // ?にはIの数字が入るーーー？から置き換わる
                        $.ajax({
                        url:'diary/'+ diaryId +'/dislike',
                        type:'POST',
                        dataType:'json',
                        // dataType:'json',
                        //CSRF対策の為、tokenを送信する.
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        }
                    }).done((data) => {
                        console.log(data);
                        //いいねの数を増やそう
                        //1,現在のいいね数を取得
                        //text(): <a>XXX</a>XXXの部分を取得
                        let num = clickedBtn.siblings('.js-like-num').text();
    ​
    ​
                        //numを数値に変換する
                        num =Number(num);
    ​
                        //２、１マイナスした結果を設定する
                        //text(YYY); <a>XXX</a>XXXの部分をYYYに置き換える
                        clickedBtn.siblings('.js-like-num').text(num - 1);
    ​
    ​
                        //いいねのボタンの「デザイン」を変更
                        changeLikeBtn(clickedBtn);
    ​
    ​
                        }).fail((error) => {
                        console.log(error);
                        });
                    }