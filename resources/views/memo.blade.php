<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>メモアプリ</title>
    @vite(['resources/css/app.css', 'resources/ts/memo.ts'])
  </head>
  <body>
    <div class="container">
      <h1>
        対象日時：{{ $dates }}<br>
        メモアプリ</h1>  
      <div class="memo-input">
        <textarea id="memoText" placeholder="メモを入力してください…"></textarea>
        <button type="submit" id="saveBtn">保存</button>
      </div>
      <h2>メモ一覧</h2>
      <ul id="memoList">
        @foreach ($memos as $memo)
          <li>{{ $memo->content }}
            <button data-id="{{ $memo->id }}" type="submit" class="delete-btn">削除</button>
          </li>
        @endforeach
      </ul>
    </div>
  </body>
</html>