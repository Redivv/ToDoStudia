import { getTablesData, addNewTable } from './functions.js';

getTablesData();
document.getElementById('addTableButton').addEventListener("click", addNewTable);