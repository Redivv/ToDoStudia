document.getElementById('addTableButton').addEventListener("click", (e) => {
    let newTableName = prompt("Podaj nazwę tabelki").trim();
    if (newTableName === "") {
        return;
    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            if (xmlhttp.status == 200) {
                alert('lel');
            }
            else if (xmlhttp.status == 400) {
                alert('There was an error 400');
            }
            else {
                alert('something else other than 200 was returned');
                console.log(JSON.parse(xmlhttp.response));
            }
        }
    };

    let jsonData = { tableName: newTableName };
    let formattedJsonData = JSON.stringify(jsonData);

    xmlhttp.open("POST", "/addTable", true);
    xmlhttp.send(formattedJsonData);

});