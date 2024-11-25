function showTab(tabId) {
  // すべてのタブコンテンツを非表示にする
  const tabContents = document.querySelectorAll(".tab-content");
  tabContents.forEach((content) => {
    content.classList.remove("active");
  });

  // 指定されたタブコンテンツを表示
  const activeTab = document.getElementById(tabId);
  if (activeTab) {
    activeTab.classList.add("active");
  }

  // すべてのタブボタンのアクティブ状態をリセット
  const tabButtons = document.querySelectorAll(".tab-button");
  tabButtons.forEach((button) => {
    button.classList.remove("active");
  });

  // クリックされたタブボタンをアクティブ状態にする
  const activeButton = document.querySelector(
    `[onclick="showTab('${tabId}')"]`
  );
  if (activeButton) {
    activeButton.classList.add("active");
  }
}
