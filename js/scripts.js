function handleSiteChange() {
  const selectedSite = document.getElementById("siteSelect").value;
  document.getElementById("charaenoForm").style.display =
    selectedSite === "charaeno" ? "block" : "none";
  document.getElementById("charasheetForm").style.display =
    selectedSite === "charasheet" ? "block" : "none";
  document.getElementById("iacharaForm").style.display =
    selectedSite === "iachara" ? "block" : "none";
}

function submitForm(event, formId, apiUrl) {
  event.preventDefault(); // デフォルトの送信を防止
  const form = document.getElementById(formId);
  const formData = new FormData(form);
  const messageElement = document.getElementById("message"); // メッセージ表示エリアを取得

  fetch(apiUrl, {
    method: "POST",
    body: formData
  })
    .then((response) => response.text())
    .then((data) => {
      messageElement.textContent = data; // サーバーからの応答を表示
      messageElement.style.color = "green"; // メッセージの色を設定
      form.reset(); // フォームをリセット
      updateCharacterList(); // キャラクター一覧を更新
    })
    .catch((error) => {
      console.error("エラー:", error);
      messageElement.textContent =
        "登録に失敗しました。もう一度お試しください。";
      messageElement.style.color = "red"; // エラーメッセージの色を設定
    });
}

function updateCharacterList() {
  const listContainer = document.getElementById("character-list-container");
  fetch("php/characters_list.php")
    .then((response) => response.text())
    .then((html) => {
      listContainer.innerHTML = html; // 最新の一覧を更新
    })
    .catch((error) => {
      console.error("キャラクター一覧の更新エラー:", error);
    });
}
