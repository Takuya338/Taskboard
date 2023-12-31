document.addEventListener("DOMContentLoaded", () => {
    initializeBoard();
});

function initializeBoard() {
    const tasks = [
        { id: 1, content: "タスク1\n0000/00/00", column: "1-1" },
        { id: 2, content: "タスク2\n0000/00/00", column: "1-2" },
        { id: 3, content: "タスク3\n0000/00/00", column: "2-3" },
    ];

    tasks.forEach((task) => {
        const taskElement = document.createElement("textarea");
        taskElement.textContent = task.content;
        taskElement.className = "draggable";
        taskElement.readOnly = true;
        taskElement.draggable = true;
        taskElement.id = `task-${task.id}`;
        taskElement.ondragstart = drag;

        const columnElement = document.getElementById(task.column);
        columnElement.appendChild(taskElement);
    });
}

function allowDrop(event) {
    event.preventDefault();
}

function drag(event) {
    event.dataTransfer.setData("text", event.target.id);
}

function drop(event) {
    event.preventDefault();

    const taskId = event.dataTransfer.getData("text");
    const targetElement = event.target;

    // ターゲットがcolumnか確認
    if (targetElement.classList.contains("column")) {
        targetElement.appendChild(document.getElementById(taskId));
    } else {
        // ターゲットがcolumnでない場合は、その親要素（column）に追加する
        targetElement
            .closest(".column")
            .appendChild(document.getElementById(taskId));
    }

    // タスクの状態を更新する
    const taskElement = document.getElementById(taskId);
    alert(taskElement.closest(".column").id);
}
