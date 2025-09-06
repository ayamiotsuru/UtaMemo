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

        // 入力値が空なら表示箇所をクリアして処理終了
        if(!searchWord){
            resultList.innerHTML = "";
            return;
        }

        try {
            //非同期処理の内容を書く
            const url = searchInput.dataset.ajaxUrl; // HTML側から現在のURLを取得する
            const res = await fetch(`${url}?query=${encodeURIComponent(searchWord)}`); // 指定したURLにリクエストを送りサーバーからレスポンスオブジェクトを受け取る非同期処理
            const data = await res.json(); // 受け取ったレスポンスオブジェクトを扱えるようにjsのオブジェクト/配列に変換

            // 表示箇所をクリア
            resultList.innerHTML = "";

            // 検索結果が0なら該当なしと表示し処理終了
            if(data.length === 0){
                resultList.innerHTML = '<li>該当なし</li>';
                return;
            }

            // 検索結果を画面に表示する
            data.forEach((post) => {
                const listItem = document.createElement('li');

                const listLink = document.createElement('a');
                listLink.href = `/post/${post.id}`;
                listLink.textContent = `${post.song}`;

                listItem.appendChild(listLink);
                resultList.appendChild(listItem);
            });
        }
        catch(error) {
            console.error(error);
        }
    });
});
