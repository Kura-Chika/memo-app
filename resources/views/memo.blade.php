<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メモアプリ</title>
    @vite('resources/css/app.css')
  </head>
  <body>
    <div class="container">
      <h1>
        日時(1時間前)：{{ $dates['oneHourAgo'] }}<br>
        今月月末：{{ $dates['endOfMonth']}}<br>
        来月月初：{{ $dates['startOfNextMonth']}}<br>
        メモアプリ</h1>  
      <div class="memo-input">
        <form action="{{ route('memo.store') }}" method="POST">
          @csrf
          <textarea name="content" id="memoText" placeholder="メモを入力してください…"></textarea>
          <button type="submit" id="saveBtn">保存</button>
        </form>
      </div>
      <h2>メモ一覧</h2>
      <ul id="memoList">
        @foreach ($memos as $memo)
          <li>{{ $memo->content }}
            <form action="{{ route('memo.destroy', $memo->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" id="deleteBtn" class="delete-btn">削除</button>
            </form>
          </li>
        @endforeach
      </ul>
    </div>
  </body>
</html>