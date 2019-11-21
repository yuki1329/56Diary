$(document).on('click','.js-like', function(){
    //いいねされた日記のIDを取得
    //$(this) : 今回クリックされたiタグ(ハートマーク)
    // .sibligs('XXX') : 兄弟要素を取得する
    // .val() : inputタグのvalueの値を取得する
    let diaryId=$(this).siblings('.diary-id').val();

    //likeメソッドの実行
    like(diaryId,$(this));
});
    //diaryId:いいねする日記のID
    //clickedBtn:今回クリックされたいいねのアイコン
function like(diaryId ,clickedBtn){
    $.ajax({
        url:'diary/' + diaryId + '/like',
        type: 'POST',
        // CSRF対策のため、tokenを送信する
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done((data) =>{
        console.log(data);
        //いいねの数を増やす
        //1.現在のいいね数を取得
        //text() : <a>XXX</a> XXXの部分を取得
        let num =clickedBtn.siblings('.js-like-num').text();

        //numを数値に変換する
        num=Number(num);

        //2.1プラスした結果を設定する
        //text(YYY) : <a>XXX</a> XXXの部分をYYYに置き換える
        clickedBtn.siblings('.js-like-num').text(num +1);
        //いいねのボタンのデザインを変更
        changeLikeBtn(clickedBtn);
    }).fail((error) =>{
        console.log(error);
    });
}

    //btn:色を変えたい、いいねアイコン
function changeLikeBtn(btn){
    btn.toggleClass('far');
    btn.toggleClass('fas');
}