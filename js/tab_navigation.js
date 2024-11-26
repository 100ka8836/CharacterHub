// キャラクター一覧をリロードして更新する関数
function refreshCharacterList(activeTabId = "tab-basic") {
  const listContainer = document.getElementById("character-list-container");
  fetch("php/characters_list.php")
    .then((response) => response.text())
    .then((html) => {
      listContainer.innerHTML = html; // 最新のキャラクターリストを反映
      showTab(activeTabId); // 現在のタブを再表示
    })
    .catch(() => {
      alert("キャラクター一覧の更新に失敗しました。");
    });
}

// 初期化
document.addEventListener("DOMContentLoaded", () => {
  const savedTabId = localStorage.getItem("activeTabId") || "tab-basic";
  refreshCharacterList(savedTabId); // 初期ロード時にキャラクター一覧をロード
});

// タブを切り替える関数
function showTab(tabId) {
  const tabContents = document.querySelectorAll(".tab-content");
  const tabButtons = document.querySelectorAll(".tab-button");

  // すべてのタブを非表示
  tabContents.forEach((content) => {
    content.style.display = "none";
  });

  // 選択されたタブを表示
  const activeTab = document.getElementById(tabId);
  if (activeTab) {
    activeTab.style.display = "block";
  }

  // タブボタンのアクティブクラスを更新
  tabButtons.forEach((button) => {
    button.classList.remove("active");
  });

  const activeButton = document.querySelector(
    `.tab-button[onclick="showTab('${tabId}')"]`
  );
  if (activeButton) activeButton.classList.add("active");

  // ローカルストレージにアクティブなタブを保存
  localStorage.setItem("activeTabId", tabId);
}
