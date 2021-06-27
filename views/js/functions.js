function getTablesData() {
    fetch("/getTables", {
        method: "GET"
    }).then(response => {
        if (response.status === 200) {
            response.json().then(data => {
                let tablesHTML = "";
                data.forEach(tableData => {
                    tablesHTML += `<div class='tableLink' data-tableid='${tableData.id}'>${tableData.name}</div>`;
                });
                document.getElementById('tableLinks').innerHTML = tablesHTML;
                document.getElementById('tableContainer').innerHTML = `
                <div class="initialInformation">
                    Wybierz lub dodaj tablicę
                </div>`.trim();
                document.querySelectorAll('.tableLink').forEach(
                    el => el.addEventListener(
                        'click',
                        event => {
                            makeAllTableLinksNotActive();
                            event.target.className += " activeTable";
                            getTableData(event.target.getAttribute('data-tableId'));
                        }
                    )
                );
            });
        } else {
            alert('Wystąpił Bład');
        }
    });
}

function getTableData(tableId) {
    document.getElementById('tableContainer').innerHTML = `<div class="lds-circle"><div></div></div>`;
    fetch(`/getTable?tableId=${tableId}`, {
        method: "GET"
    }).then(response => {
        if (response.status === 200) {
            response.json().then(data => {
                if (data) {
                    let tableHTML = `
                    <header>
                        <span id="tableEditButton" data-tableid="${data.tableData.id}">Edytuj</span>
                        <span id="tableName">${data.tableData.name}</span>
                        <span id="tableDeleteButton" data-tableid="${data.tableData.id}">Usuń</span>
                    </header>
                    <div id="todoTable">
                        <div id="column1" class="tableColumn">
                            <header>Nowe</header>
                            <output>
                                ${generateTasksHtml(data.tasks['1'])}
                            </output>
                            <footer class="addTaskButton" data-tableid="${data.tableData.id}" data-columnnumber="1">
                                Dodaj Zadanie
                            </footer>
                        </div>
                        <div id="column2" class="tableColumn">
                            <header>W Trakcie</header>
                            <output>
                                ${generateTasksHtml(data.tasks['2'])}
                            </output>
                        </div>
                        <div id="column3" class="tableColumn">
                            <header>Testowane</header>
                            <output>
                                ${generateTasksHtml(data.tasks['3'])}
                            </output>
                        </div>
                        <div id="column4" class="tableColumn">
                            <header>Gotowe</header>
                            <output>
                                ${generateTasksHtml(data.tasks['4'])}
                            </output>
                        </div>
                    </div>
                    `;
                    document.getElementById('tableContainer').innerHTML = tableHTML;
                    document.getElementById('tableDeleteButton').addEventListener(
                        'click',
                        event => deleteTable(
                            event.target.getAttribute('data-tableId')
                        )
                    );
                    document.getElementById('tableEditButton').addEventListener(
                        'click',
                        event => editTable(
                            event.target.getAttribute('data-tableId')
                        )
                    );
                    document.querySelector(".addTaskButton").addEventListener("click", event => {
                        addNewTask(event.target.getAttribute("data-tableid"))
                    });
                } else {
                    alert("Błędne Dane");
                }
            });
        } else {
            alert('Wystąpił Bład');
        }
    });
}

function generateTasksHtml(tasks) {
    let tasksHTML = "";
    tasks.forEach(task => {
        tasksHTML += `
            <article>
                <div class="taskTitle">${task.title}</div>
                <div class="taskLevel">0</div>
            </article>
            `;
    });
    return tasksHTML;
}

function addNewTable() {
    let newTableName = prompt("Podaj nazwę tabelki").trim();
    if (newTableName === "") {
        return;
    }

    let jsonData = { tableName: newTableName };
    let formattedJsonData = JSON.stringify(jsonData);

    fetch("/addTable", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
        },
        body: formattedJsonData
    }).then(response => {
        if (response.status === 201) {
            response.json().then(data => {
                let newTableElement = document.createElement("div")
                newTableElement.appendChild(
                    document.createTextNode(data.name)
                );
                newTableElement.setAttribute("class", "tableLink activeTable");
                newTableElement.setAttribute("data-tableid", data.id);
                newTableElement.addEventListener(
                    'click',
                    event => getTableData(
                        event.target.getAttribute('data-tableId')
                    )
                )
                makeAllTableLinksNotActive();

                document.getElementById('tableLinks').appendChild(newTableElement);
                getTableData(data.id);
                z
            });
        } else {
            alert('Wystąpił Błąd');
        }
    })
}

function addNewTask(tableId) {
    let newTaskName = prompt("Podaj tytuł zadania").trim();
    if (newTaskName === "") {
        return;
    }

    let jsonData = {
        taskName: newTaskName,
        tableId: tableId,
    };
    let formattedJsonData = JSON.stringify(jsonData);

    fetch("/addTask", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
        },
        body: formattedJsonData
    }).then(response => {
        if (response.status === 201) {
            response.json().then(data => {
                let newTaskElement = document.createElement("article");

                let newTaskTitleElement = document.createElement("div");
                newTaskTitleElement.setAttribute("class", "taskTitle")
                newTaskTitleElement.appendChild(
                    document.createTextNode(data.title)
                )
                newTaskElement.appendChild(newTaskTitleElement);

                let newTaskLevelElement = document.createElement("div");
                newTaskLevelElement.setAttribute("class", "taskLevel")
                newTaskLevelElement.appendChild(
                    document.createTextNode("0")
                )
                newTaskElement.appendChild(newTaskLevelElement);

                document.querySelector("#column1 output").appendChild(newTaskElement);
            });
        } else {
            alert('Wystąpił Błąd');
        }
    })
}

function deleteTable(tableId) {
    let isConfirmed = confirm("Czy na pewno chcesz usunąć tabelę wraz zawartością?");

    if (isConfirmed) {
        fetch(`/deleteTable?tableId=${tableId}`, {
            method: "POST",
        }).then(response => {
            if (response.status === 204) {
                document.getElementById('tableContainer').innerHTML = `
                <div class="initialInformation">
                    Wybierz lub dodaj tablicę
                </div>`.trim();
                document.querySelector(".tableLink.activeTable").remove();
            } else {
                alert('Wystąpił Błąd');
            }
        })
    }
}

function editTable(tableId) {
    let newTableName = prompt("Podaj nową nazwę tabeli.").trim();
    if (newTableName !== "") {
        fetch(`/editTable?tableId=${tableId}`, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(newTableName)
        }).then(response => {
            if (response.status === 200) {
                response.json().then(data => {
                    document.getElementById("tableName").innerHTML = data.newName;
                    document.querySelector(`.tableLink[data-tableid="${data.id}"]`).innerHTML = data.newName;
                });
            } else {
                alert('Wystąpił Błąd');
            }
        })
    }
}

function makeAllTableLinksNotActive() {
    document.querySelectorAll('.tableLink.activeTable').forEach(link => link.className = "tableLink");
}

export { getTablesData, addNewTable };