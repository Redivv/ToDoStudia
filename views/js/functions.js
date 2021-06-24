function getTableData() {
    fetch("/getTables", {
        method: "GET"
    }).then(response => {
        if (response.status === 200) {
            response.json().then(data => {
                let tablesHTML = "";
                data.forEach(tableName => {
                    tablesHTML += `<div class='tableLink'>${tableName}</div>`;
                });
                document.getElementById('tableLinks').innerHTML = tablesHTML;
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
                newTableName = data.newTableName;
                let newTableHtml = `<div class='tableLink'>${newTableName}</div>`;
                document.getElementById('tableLinks').innerHTML += newTableHtml;
            });
        } else {
            alert('Wystąpił Błąd');
        }
    })
}

export { getTableData, addNewTable };