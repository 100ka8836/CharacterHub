// キャラクター一覧を更新する関数
function updateCharacterList(sortColumn = "id", sortOrder = "asc") {
  const listContainer = document.getElementById("character-list-container");
  fetch(
    `php/characters_list.php?sortColumn=${sortColumn}&sortOrder=${sortOrder}`
  )
    .then((response) => response.text())
    .then((html) => {
      listContainer.innerHTML = html;
    })
    .catch((error) => {
      console.error("キャラクター一覧の更新エラー:", error);
    });
}

// ソートリンクのクリックイベントをハンドリング
document.addEventListener("click", function (event) {
  if (event.target.tagName === "A" && event.target.dataset.sortColumn) {
    event.preventDefault(); // デフォルト動作を防止
    const sortColumn = event.target.dataset.sortColumn;
    const sortOrder = event.target.dataset.sortOrder;
    updateCharacterList(sortColumn, sortOrder);
  }
});
