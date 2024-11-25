document.addEventListener("DOMContentLoaded", () => {
  const addColumnForm = document.getElementById("add-column-form");
  const tableBody = document.getElementById("other-info-table-body");
  const editButton = document.getElementById("toggle-edit-mode");
  const saveButton = document.getElementById("save-changes");

  let editMode = false;

  // 現在のタブIDを記録する
  let currentTab = "tab-other";

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

  // カラムを追加する
  addColumnForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const newColumnName = document.getElementById("new-column-name").value;

    fetch("php/add_column.php", {
      method: "POST",
      body: JSON.stringify({ column_name: newColumnName }),
      headers: {
        "Content-Type": "application/json"
      }
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // 新しい行をテーブルに追加
          const newRow = document.createElement("tr");
          const newCell = document.createElement("td");
          newCell.textContent = data.column_name;
          newRow.appendChild(newCell);

          // 各キャラクターの値を空欄として追加
          const columns = document.querySelectorAll("thead th");
          for (let i = 1; i < columns.length; i++) {
            const newCell = document.createElement("td");
            newCell.classList.add("editable");
            newCell.contentEditable = false; // デフォルトで編集不可
            newRow.appendChild(newCell);
          }

          tableBody.appendChild(newRow);

          // フォームをリセット
          document.getElementById("new-column-name").value = "";
        }
        // カラム追加後、現在のタブを表示
        showTab(currentTab);
      })
      .catch((error) => {
        console.error("カラム追加エラー:", error);
      });
  });

  // 編集モードの切り替え
  editButton.addEventListener("click", () => {
    editMode = !editMode;
    const cells = document.querySelectorAll(".editable");
    cells.forEach((cell) => {
      cell.contentEditable = editMode; // 編集モード時のみ編集可能
    });
    editButton.style.display = editMode ? "none" : "block";
    saveButton.style.display = editMode ? "block" : "none";
  });

  // 編集内容を保存
  saveButton.addEventListener("click", () => {
    const rows = document.querySelectorAll("#other-info-table-body tr");
    const updatedData = {};

    rows.forEach((row) => {
      const cells = row.querySelectorAll("td");
      const columnName = cells[0].textContent.trim();
      updatedData[columnName] = [];
      cells.forEach((cell, index) => {
        if (index > 0) {
          updatedData[columnName].push(cell.textContent.trim());
        }
      });
    });

    fetch("php/save_other_info.php", {
      method: "POST",
      body: JSON.stringify({ data: updatedData }),
      headers: {
        "Content-Type": "application/json"
      }
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          const cells = document.querySelectorAll(".editable");
          cells.forEach((cell) => {
            cell.contentEditable = false; // 保存後は編集不可
          });
          saveButton.style.display = "none";
          editButton.style.display = "block";
        }
      })
      .catch((error) => {
        console.error("保存エラー:", error);
      });
  });

  // 初期化：すべてのeditableセルを編集不可にする
  const cells = document.querySelectorAll(".editable");
  cells.forEach((cell) => {
    cell.contentEditable = false; // 初期状態で編集不可
  });
});
