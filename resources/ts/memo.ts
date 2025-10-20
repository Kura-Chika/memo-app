async function createMemo(content: string) { //メモを登録
    const response = await fetch(`/`, {
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
    const response = await fetch(`/${id}`, { //文字列と認識されるようバックフォート(``)使用
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

const btn = document.getElementById('saveBtn') as HTMLButtonElement;
const input = document.getElementById('memoText') as HTMLTextAreaElement;

btn.addEventListener('click', (e) => {
    e.preventDefault();
    createMemo(input.value);
});

document.querySelectorAll('.delete-btn').forEach((button) => {
    button.addEventListener('click', (e) => {
      e.preventDefault();
      const id = (button as HTMLButtonElement).dataset.id; // data-id属性から取得
      if (id) {
          deleteMemo(Number(id));
      }
    });
});