fetch("php/save_category.php", {
  method: "POST",
  headers: { "Content-Type": "application/json" },
  body: JSON.stringify({ action: "add_category", field_name: "カテゴリ名" })
})
  .then((response) => response.json())
  .then((data) => {
    if (data.success) {
      alert("カテゴリが正常に追加されました！");
    } else {
      alert("カテゴリ追加に失敗しました: " + data.message);
    }
  })
  .catch((error) => console.error("エラー:", error));
