import {getTableData, addNewTable} from './functions.js';

getTableData();
document.getElementById('addTableButton').addEventListener("click", addNewTable);