let primaryFilter = document.getElementById("primary-filter");
let secondaryFilter = document.getElementById("secondary-filter");
let sortingOrder = document.getElementById("sorting-order");
let inMonth = document.getElementById("in-month");
let inYear = document.getElementById("in-year");

let tableHead = document.getElementById("table-heading");
let tableBody = document.getElementById("table-body");

let data;
async function getSecondaryFilters() {

    if(primaryFilter.value == 0) {

        getData();
    }
    secondaryFilter.innerHTML = "";
    let option = document.createElement("option");
    option.setAttribute("selected", true);
    option.setAttribute("value", 0);
    if(primaryFilter.value == 0) {
        
        option.textContent = "None";
        secondaryFilter.appendChild(option);
        return;
    }
    else {
        option.textContent = "Select a secondary filter";
        secondaryFilter.appendChild(option);
    }
    let response = await fetch("./api/employee/secondaryFilters.php?primary-filter="+primaryFilter.value);
    let filterList = await response.json();
    const l = filterList.length;
    for(let i=0; i<l; i++) {

        let option = document.createElement("option");
        option.setAttribute("value", filterList[i][0]);
        option.textContent = filterList[i][1];
        secondaryFilter.appendChild(option);
    }
    
}
async function getData() {

    const url = "./api/employee/employee.php?&primary-filter="+primaryFilter.value+"&secondary-filter="+secondaryFilter.value+"&in-month="+inMonth.value+"&in-year="+inYear.value+"&sorting-order="+sortingOrder.value;
    let response = await fetch(url);
    data = await response.json();
    console.log(data);
    genTable();
}
function genTable() {

    tableBody.innerHTML = "";
    const l = data.length;
    for(let i=0; i<l; i++) {

        const row = document.createElement("tr");
        for(let j=0; j<8; j++) {

            const column = document.createElement("td");
            if(j==0) {

                const date = document.createElement("input");
                date.setAttribute("type", "date");
                date.setAttribute("value", data[i][j]);
                date.setAttribute("class", "font-16");
                date.setAttribute("disabled", "");
                column.appendChild(date);
            }
            else if(j==2) {
                
                column.textContent= data[i][j]+" > "+data[i][j+1];
                j=j+1;
            }
            else if(j == 4 || j == 5) {

                let time = document.createElement("input");
                time.setAttribute("type", "time");
                time.setAttribute("class", "font-16");
                time.setAttribute("value", data[i][j]);
                time.setAttribute("class", "font-16");
                time.setAttribute("disabled", "");
                column.appendChild(time);
            }
            else if(j == 6) {

                column.textContent = data[i][j].substring(0, 5);
            }
            else if(j == 7) {

                column.style.width = "360px";
                column.textContent= data[i][j];
            }
            else {

                column.textContent= data[i][j];
            }
            row.appendChild(column);
        }
        tableBody.appendChild(row);
    }
}
window.onload = () => {
    getData();
}