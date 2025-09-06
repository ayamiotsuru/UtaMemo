// 検索フォームのクラスを探し、forEachで一つづつ処理。
document.querySelectorAll('.search-form').forEach((searchBox) => {
    // 引数（searchBox）を設定し、渡ってきた要素の中でクラスを検索し変数に代入している。
    const searchInput = searchBox.querySelector('.search-input');
    const resultList = searchBox.querySelector('.search-results');

    // もしクラスがなければ処理終了
    if(!searchInput || !resultList){
        return;
    }

    // 入力欄に対してのイベント追加
    searchInput.addEventListener('keyup', async() => {
        const searchWord = searchInput.value.trim();

        // 入力値が空なら表示箇所をクリア&非表示にして処理終了
        if(!searchWord){
            resultList.innerHTML = "";
            resultList.style.display = 'none';
            return;
        }

        try {
            //非同期処理の内容を書く
            // awaitでその非同期処理が終わるまで次の処理を待機

             // datasetでHTML（data-ajax-url属性）から現在のURLを取得する
            const url = searchInput.dataset.ajaxUrl;
            // 指定したURLにリクエストを送りサーバーからレスポンスオブジェクトを受け取る非同期処理。
            // コントローラーの$request->input('query');のqueryが一致しておかなければズレる。
            // 処理としてはユーザーが「abc」と入力したら/ajax/search?query=abcというURLにアクセス＝フロントエンドからサーバーに「query=abc」というリクエストが送られる。
            const res = await fetch(`${url}?query=${encodeURIComponent(searchWord)}`);// ?
             // 受け取ったレスポンスオブジェクトを扱えるようにjsのオブジェクト/配列に変換
            const data = await res.json();

            // 表示箇所を非表示&クリア
            resultList.style.display = 'block';
            resultList.innerHTML = "";

            // 検索結果が0なら該当なしと表示し処理終了
            if(data.length === 0){
                resultList.innerHTML = '<li>該当なし</li>';
                return;
            }

            // 検索結果を画面に表示する
            // dataが非同期処理の結果をjsオブジェクト/配列でもっている
            // postは配列dataの中の1件分の要素(コールバック関数の引数)
            data.forEach((post) => {
                // spanタグの生成とクラス名の付与
                const spanStatus = document.createElement('span');
                spanStatus.className = 'status-badge';

                // テキストの分岐とクラスによる見た目の振り分け
                let textStatus = post.status;
                if(textStatus){
                    textStatus = 'オハコ曲'
                    spanStatus.classList.add('favorite');
                } else {
                    textStatus = '練習中'
                    spanStatus.classList.add('practice');
                }
                spanStatus.textContent = textStatus;

                // li、aタグ関係
                const listItem = document.createElement('li');
                const listLink = document.createElement('a');
                listLink.href = `/post/${post.id}`;
                listLink.textContent = `${post.song} / ${post.artist}`;

                listItem.appendChild(spanStatus);
                listItem.appendChild(listLink);
                resultList.appendChild(listItem);
            });
        }
        catch(error) {
            // エラー時の処理
            console.error(error);
        }
    });
});
