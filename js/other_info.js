document.addEventListener("DOMContentLoaded", () => {
  let currentTab = "tab-basic"; // 現在のタブIDを記録する（デフォルトは基本タブ）

  // タブを切り替える関数
  window.showTab = (tabId) => {
    currentTab = tabId; // 現在のタブを記録
    const tabContents = document.querySelectorAll(".tab-content");
    tabContents.forEach((content) => {
      content.style.display = "none";
    });
    const activeTab = document.getElementById(tabId);
    if (activeTab) {
      activeTab.style.display = "block";
    }
    const tabButtons = document.querySelectorAll(".tab-button");
    tabButtons.forEach((button) => {
      button.classList.remove("active");
    });
    const activeButton = document.querySelector(
      `[onclick="showTab('${tabId}')"]`
    );
    if (activeButton) {
      activeButton.classList.add("active");
    }
  };
});
