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
                const divs = document.querySelectorAll('.tableLink');
                divs.forEach(
                    el => el.addEventListener(
                        'click',
                        event => {
                            let activeLinks = document.querySelectorAll('.tableLink.activeTable');
                            activeLinks.forEach(link => link.className = "tableLink");
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
                        <span id="tableEditButton" data-tableid="${data.id}">Edytuj</span>
                        <span id="tableName">${data.name}</span>
                        <span id="tableDeleteButton" data-tableid="${data.id}">Usuń</span>
                    </header>
                    <div id="todoTable">
                        <div class="tableColumn">
                            <header>Nowe</header>
                            <output>
                                <article>
                                    <div class="taskTitle">Tytuł Zadania</div>
                                    <div class="taskLevel">13</div>
                                </article>
                                <article>
                                    <div class="taskTitle">Tytuł Zadania</div>
                                    <div class="taskLevel">13</div>
                                </article>
                                <article>
                                    <div class="taskTitle">Tytuł Zadania</div>
                                    <div class="taskLevel">13</div>
                                </article>
                                <article>
                                    <div class="taskTitle">Tytuł Zadania</div>
                                    <div class="taskLevel">13</div>
                                </article>
                                <article>
                                    <div class="taskTitle">Tytuł Zadania</div>
                                    <div class="taskLevel">13</div>
                                </article>
                                <article>
                                    <div class="taskTitle">Tytuł Zadania</div>
                                    <div class="taskLevel">13</div>
                                </article>
                                <article>
                                    <div class="taskTitle">Tytuł Zadania</div>
                                    <div class="taskLevel">13</div>
                                </article>
                            </output>
                            <footer>
                                Dodaj Zadanie
                            </footer>
                        </div>
                        <div class="tableColumn">
                            <header>W Trakcie</header>
                            <output>
                                <div class="lds-circle">
                                    <div></div>
                                </div>
                            </output>
                            <footer>
                                Dodaj Zadanie
                            </footer>
                        </div>
                        <div class="tableColumn">
                            <header>Testowane</header>
                            <output></output>
                            <footer>
                                Dodaj Zadanie
                            </footer>
                        </div>
                        <div class="tableColumn">
                            <header>Gotowe</header>
                            <output></output>
                            <footer>
                                Dodaj Zadanie
                            </footer>
                        </div>
                    </div>
                    `;
                    document.getElementById('tableContainer').innerHTML = tableHTML;
                    document.getElementById('tableDeleteButton').addEventListener(
                        'click',
                        event => deleteTable(
                            event.target.getAttribute('data-tableId')
                        )
                    )
                    document.getElementById('tableEditButton').addEventListener(
                        'click',
                        event => editTable(
                            event.target.getAttribute('data-tableId'),
                        )
                    )
                } else {
                    alert("Błędne Dane");
                }
            });
        } else {
            alert('Wystąpił Bład');
        }
    });
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
                newTableElement.setAttribute("class", "tableLink");
                newTableElement.setAttribute("data-tableid", data.id);
                newTableElement.addEventListener(
                    'click',
                    event => getTableData(
                        event.target.getAttribute('data-tableId')
                    )
                )

                document.getElementById('tableLinks').appendChild(newTableElement);
                getTableData(data.id);

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

export { getTablesData, addNewTable };