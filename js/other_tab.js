let additionalFields = []; // 保存されているカテゴリのリスト
let isEditing = false; // 編集中かどうかのフラグ

// カテゴリを追加
function addNewCategory() {
  const categoryNameInput = document.getElementById("new-category-name");
  const categoryName = categoryNameInput.value.trim();

  if (!categoryName) {
    alert("カテゴリ名を入力してください！");
    return;
  }

  fetch("php/save_category.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ field_name: categoryName })
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("カテゴリが正常に追加されました！");
        loadAdditionalFields(); // テーブルを再ロード
        categoryNameInput.value = ""; // 入力フィールドをクリア
      } else {
        alert("カテゴリの追加に失敗しました: " + data.message);
      }
    })
    .catch((error) => {
      console.error("カテゴリ追加エラー:", error);
    });
}

// カテゴリと値をロード
function loadAdditionalFields() {
  fetch("php/get_categories.php")
    .then((response) => response.json())
    .then((data) => {
      const tableBody = document.getElementById("additional-fields-table-body");
      tableBody.innerHTML = ""; // テーブルをリセット
      additionalFields = []; // ローカルリストをクリア

      if (data.fields && Array.isArray(data.fields)) {
        data.fields.forEach((field) => {
          addCategoryToTable(field.field_name, field.values);
        });
      } else {
        console.error("カテゴリデータ形式が不正です。", data);
      }
    })
    .catch((error) => {
      console.error("カテゴリロードエラー:", error);
    });
}

// テーブルにカテゴリを追加
function addCategoryToTable(categoryName, characterValues = []) {
  const fieldId = `field-${additionalFields.length}`;
  const tableRow = `
        <tr id="${fieldId}">
            <td>${escapeHtml(categoryName)}</td>
            ${characterValues
              .map(
                (value) => `
                        <td data-character-id="${value.character_id}">
                            <span>${escapeHtml(value.value)}</span>
                            <input type="text" value="${escapeHtml(
                              value.value
                            )}" style="display: none;">
                        </td>
                    `
              )
              .join("")}
            <td>
                <button onclick="startEdit(this)">編集</button>
                <button onclick="saveEdit(this)" style="display: none;">完了</button>
            </td>
        </tr>
    `;
  document
    .getElementById("additional-fields-table-body")
    .insertAdjacentHTML("beforeend", tableRow);
  additionalFields.push(categoryName);
}

// 編集開始
function startEdit(button) {
  if (isEditing) {
    alert("他の編集を完了してください！");
    return;
  }
  isEditing = true;

  const row = button.closest("tr");
  row.querySelectorAll("span").forEach((span) => (span.style.display = "none"));
  row.querySelectorAll("input").forEach((input) => (input.style.display = ""));
  button.style.display = "none"; // 編集ボタンを非表示
  row.querySelector("button[onclick='saveEdit(this)']").style.display = ""; // 完了ボタンを表示
}

// 編集完了
function saveEdit(button) {
  const row = button.closest("tr");
  const categoryName = row.querySelector("td:first-child").innerText;
  const values = Array.from(row.querySelectorAll("td[data-character-id]"))
    .map((td) => {
      const input = td.querySelector("input");
      if (!input) return null;
      return {
        character_id: td.dataset.characterId,
        value: input.value.trim()
      };
    })
    .filter((value) => value !== null);

  fetch("php/save_category_values.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      category_name: categoryName,
      values
    })
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("保存が完了しました！");
        loadAdditionalFields(); // 最新データで更新
      } else {
        alert("保存に失敗しました: " + data.message);
      }
    })
    .catch((error) => {
      console.error("保存エラー:", error);
    })
    .finally(() => {
      isEditing = false;
    });
}

// HTMLエスケープ
function escapeHtml(value) {
  if (!value) return "";
  return value
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

// 初期化
document.addEventListener("DOMContentLoaded", () => {
  loadAdditionalFields(); // ページロード時にカテゴリと値を読み込み
});
