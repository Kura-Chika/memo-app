async function createMemo(content: string) { //メモを登録
    const response = await fetch(`/api`, { //文字列と認識されるようバックフォート(``)使用
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]')as HTMLMetaElement).content
        },
        body: JSON.stringify({ content })
    });

    if (!response.ok) {
        console.error('保存中にエラーが発生しました');
        return;
    }

    const data = await response.json();
    console.log('登録成功', data);
    location.reload(); //保存成功後、ページを更新
}

async function deleteMemo(id: number) { //メモを削除
    const response = await fetch(`/api/${id}`, { //文字列と認識されるようバックフォート(``)使用
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]')as HTMLMetaElement).content
        }
    });

    if (!response.ok) {
        console.error('削除中にエラーが発生しました');
        return;
    }

    console.log('削除成功');
    location.reload(); //削除成功後、ページを更新
}

async function updateMemo(id: number, content: string) { //メモ更新
    const response = await fetch(`/api/${id}`, { //文字列と認識されるようバックフォート(``)使用
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement).content
        },
        body: JSON.stringify({ content }),
    });

    if (!response.ok) {
        console.error('更新に失敗しました');
        return;
    }

    const data = await response.json();
    console.log('更新成功', data);
    location.reload(); //更新成功後、ページを更新
        
}

let editingId: number | null = null; // 編集中のメモIDを保持

/**
 * 登録ボタン
 */
const saveBtn = document.getElementById('saveBtn') as HTMLButtonElement;
const input = document.getElementById('memoText') as HTMLTextAreaElement;

saveBtn.addEventListener('click', (e) => {
    e.preventDefault();
    if (!input.value)return alert("メモを入力してください");

    if (editingId) { //編集と更新
        updateMemo(editingId, input.value);
        editingId = null;
        saveBtn.textContent = "保存";
    } else { //新規作成
        createMemo(input.value);
    }
    input.value = "";
});

/**
 * 削除ボタン
 */
document.querySelectorAll('.delete-btn').forEach((button) => {
    button.addEventListener('click', (e) => {
      e.preventDefault();
      const li = (button as HTMLButtonElement).closest('li');
      const id = li?.dataset.id;
      if (id && confirm("このメモを削除しますか？")) {
          deleteMemo(Number(id));
      }
    });
});

/**
 * 編集ボタン
 */
document.querySelectorAll('.edit-btn').forEach((button) => {
    button.addEventListener('click', (e) => {
      e.preventDefault();
      const li = (button as HTMLButtonElement).closest('li');
      if (!li) return;
      const id = Number(li.dataset.id);
      const currentContent = li.querySelector('.memo-content')?.textContent ?? "";

      input.value = currentContent; //textareaに更新したいメモの内容をセット
      saveBtn.textContent = "更新"; //ボタンを保存から更新に変更
      editingId = id; 
    });
});