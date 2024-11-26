// サイト選択に応じたフォーム表示
function handleSiteChange() {
  const selectedSite = document.getElementById("siteSelect").value;
  document.getElementById("charaenoForm").style.display =
    selectedSite === "charaeno" ? "block" : "none";
  document.getElementById("charasheetForm").style.display =
    selectedSite === "charasheet" ? "block" : "none";
  document.getElementById("iacharaForm").style.display =
    selectedSite === "iachara" ? "block" : "none";
}

// フォーム送信時にリストを更新
function submitForm(event, formId, apiUrl) {
  event.preventDefault();
  const form = document.getElementById(formId);
  const formData = new FormData(form);
  const messageElement = document.getElementById("message-box");

  fetch(apiUrl, {
    method: "POST",
    body: formData
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        messageElement.textContent = "キャラクターが正常に登録されました！";
        messageElement.style.color = "green";
        const activeTabId = localStorage.getItem("activeTabId") || "tab-basic";
        refreshCharacterList(activeTabId); // 一覧を更新し現在のタブを維持
      } else {
        messageElement.textContent = data.message || "エラーが発生しました。";
        messageElement.style.color = "red";
      }
      form.reset();
    })
    .catch(() => {
      messageElement.textContent =
        "通信エラーが発生しました。もう一度お試しください。";
      messageElement.style.color = "red";
    });
}
