let sortingOrder = document.getElementById("sorting-order");
let inMonth = document.getElementById("in-month");
let inYear = document.getElementById("in-year");

let tableHead = document.getElementById("table-heading");
let tableBody = document.getElementById("table-body");
let tableBody2 = document.getElementById("table-body2");

var data, flow = -1;
async function getData(x) {
    if(typeof x != "undefined") {
        flow = x;
    }
    let projectFilter, pTaskFilter, employeeFilter;
    if(flow == 0) {
        document.getElementById("employee-filter-2").value = "";
        document.getElementById("ptask-filter-2").innerHTML = `<option selected value="">None</option>`;
        document.getElementById("project-filter-2").innerHTML = `<option selected value="">None</option>`;
        

        projectFilter = document.getElementById("project-filter-1");
        pTaskFilter = document.getElementById("ptask-filter-1");
        employeeFilter = document.getElementById("employee-filter-1");
    }
    else if(flow == 1) {
        document.getElementById("project-filter-1").value = "";
        document.getElementById("ptask-filter-1").innerHTML = `<option selected value="">None</option>`;
        document.getElementById("employee-filter-1").innerHTML = `<option selected value="">None</option>`;

        projectFilter = document.getElementById("project-filter-2");
        pTaskFilter = document.getElementById("ptask-filter-2");
        employeeFilter = document.getElementById("employee-filter-2");
    }
    else {
        return;
    }
    

    const parameters = new URLSearchParams({
        "project-filter": projectFilter.value,
        "employee-filter": employeeFilter.value,
        "ptask-filter": pTaskFilter.value,
        "in-month": inMonth.value,
        "in-year": inYear.value,
        "sorting-order": sortingOrder.value
    });

    const url = "./../api/admin/employees.php?"+parameters;
    let response = await fetch(url);
    data = await response.json();
    console.log(data);
    genTable();
}

async function getPrimaryTasks(x) {
    let timeArray;
    let parameters, primaryTask;
    if(x == 1) {
        const employeeFilter = document.getElementById("employee-filter-2");
        parameters = new URLSearchParams({
            "employee-filter": employeeFilter.value
        });
        
        primaryTask = document.getElementById("ptask-filter-2");
    }
    else {
        const projectFilter = document.getElementById("project-filter-1");
        parameters = new URLSearchParams({
            "project-filter": projectFilter.value
        });
        document.getElementById("employee-filter-1").innerHTML = `<option selected value="">None</option>`;
        primaryTask = document.getElementById("ptask-filter-1");
    }
    

    

    const url = "./../api/admin/getPrimaryTasks.php?"+parameters;
    let response = await fetch(url);
    data = await response.json();
    
    const l = data.length;

    primaryTask.innerHTML = `<option selected value="">None</option>`;
    for(let i=0; i<l; i++) {
        timeArray = data[i][2].split(":");
        primaryTask.innerHTML += `<option value="${data[i][0]}">${data[i][1]} - ${timeArray[0]} Hrs ${timeArray[1]} Mins</option>`;
    }
}

async function getEmployees() {
    const projectFilter = document.getElementById("project-filter-1");
    const ptaskFilter = document.getElementById("ptask-filter-1");

    const parameters = new URLSearchParams({
        "project-filter": projectFilter.value,
        "ptask-filter": ptaskFilter.value
    });

    const url = "./../api/admin/getEmployees.php?"+parameters;
    let response = await fetch(url);
    data = await response.json();
    
    const l = data.length;

    const employees = document.getElementById("employee-filter-1");

    employees.innerHTML = `<option selected value="">None</option>`;
    for(let i=0; i<l; i++) {
        timeArray = data[i][2].split(":");
        employees.innerHTML += `<option value="${data[i][0]}">${data[i][1]} - ${timeArray[0]} Hrs ${timeArray[1]} Mins</option>`;
    }
}



async function getProjects() {
    let timeArray;
    tableBody.innerHTML = "";
    const projectFilter = document.getElementById("employee-filter-2");
    document.getElementById("ptask-filter-2").innerHTML = `<option selected value="">None</option>`;
    
    const parameters = new URLSearchParams({
        "employee-filter": projectFilter.value,
    });

    const url = "./../api/admin/getProjects.php?"+parameters;
    let response = await fetch(url);
    data = await response.json();
    
    const l = data.length;

    const projects = document.getElementById("project-filter-2");
    
    projects.innerHTML = `<option selected value="">None</option>`;
    for(let i=0; i<l; i++) {
        timeArray = data[i][2].split(":");
        projects.innerHTML += `<option value="${data[i][0]}">${data[i][1]} - ${timeArray[0]} Hrs ${timeArray[1]} Mins</option>`;
        const row = document.createElement("tr");
        for(let j=0; j<1; j++) {

            const column = document.createElement("td");
            
            /*if(j==1){
                var button = document.createElement("input");
                button.setAttribute("type", "submit");
                button.setAttribute("value", "subtask");
                //button.setAttribute("id", "proj");
                

                column.appendChild(button);
            }*/
                
          if(j==0){
                //column.textContent= data[i][1]+" - "+timeArray[0]+" Hrs "+timeArray[1]+" Mins ";
                let data1=data[i][1]+" - "+timeArray[0]+" Hrs "+timeArray[1]+" Mins ";
                let id_data="proj"+i;
                const text1 = document.createElement("input");
                text1.setAttribute("type", "text");
                text1.setAttribute("value", data1);
                //text1.setAttribute("id", "id_data");
                text1.setAttribute("class", "font-16");
                text1.setAttribute('onclick', 'pro(this.value)');
                text1.setAttribute("readonly", "");
               // text1.setAttribute("onclick","getPrimaryTasks();");*/
                column.appendChild(text1);
            } 
            row.appendChild(column); 
        }
        
        
        tableBody.appendChild(row);
    }
    
}
/*var Table = document.getElementById('proj');
var rowLength = Table.rows.length;*/

function genTable() {

    tableBody.innerHTML = "";
    const l = data.length;
    for(let i=0; i<l; i++) {

        const row = document.createElement("tr");
        for(let j=0; j<9; j++) {

            const column = document.createElement("td");
            if(j==0) {

                const date = document.createElement("input");
                date.setAttribute("type", "date");
                date.setAttribute("value", data[i][j]);
                date.setAttribute("class", "font-16");
                date.setAttribute("disabled", "");
                column.appendChild(date);
            }
            else if(j==3) {
                
                column.textContent= data[i][j]+" > "+data[i][j+1];
                j=j+1;
            }
            else if(j==5 || j==6) {

                let time = document.createElement("input");
                time.setAttribute("type", "time");
                time.setAttribute("class", "font-16");
                time.setAttribute("value", data[i][j]);
                column.appendChild(time);
            }
            else if(j == 7) {
                
                column.textContent = data[i][j].substring(0, 5);
            }
            else if(j == 8) {

                column.style.width = "256px";
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
/*var Table = document.getElementById('proj');
var rowLength = Table.rows.length;
var row = document.getElementById("proj");

for(let i=0; i<l; i++) {
    
        document.getElementById("proj").rows[i].cells[0].addEventListener("click",getPrimaryTasks());;
    
}*/
    
const table = document.getElementById("proj");
if(table.rows.length>2){
// Loop through all rows and cells
console.log(table.rows.length);
for (let i = 0; i < table.rows.length; i++) {
  for (let j = 0; j < table.rows[i].cells.length; j++) {
    // Add onclick event to each cell
    table.rows[i].cells[j].onclick = function () {
      alert(`You clicked on Row ${i + 1}, Col ${j + 1}`);
    };
  }
}
}
async function pro(x){
        let timeArray;
        let parameters, primaryTask;
        tableBody2.innerHTML = "";
        
        let pro1=x;
        if(pro1 != "") {
            const employeeFilter = document.getElementById("employee-filter-2");
            parameters = new URLSearchParams({
                "employee-filter": employeeFilter.value
            });
            
            primaryTask = document.getElementById("ptask-filter-2");
        }
        /*else {
            const projectFilter = document.getElementById("project-filter-1");
            parameters = new URLSearchParams({
                "project-filter": projectFilter.value
            });
            document.getElementById("employee-filter-1").innerHTML = `<option selected value="">None</option>`;
            primaryTask = document.getElementById("ptask-filter-1");
        }*/
        
    
        
    
        const url = "./../api/admin/getPrimaryTasks.php?"+parameters;
        let response = await fetch(url);
        data = await response.json();
        
        const l = data.length;
    
        primaryTask.innerHTML = `<option selected value="">None</option>`;
        for(let i=0; i<l; i++) {
            timeArray = data[i][2].split(":");
            primaryTask.innerHTML += `<option value="${data[i][0]}">${data[i][1]} - ${timeArray[0]} Hrs ${timeArray[1]} Mins</option>`;
            
            const row = document.createElement("tr");
        for(let j=0; j<1; j++) {

            const column = document.createElement("td");
            
            /*if(j==1){
                var button = document.createElement("input");
                button.setAttribute("type", "submit");
                button.setAttribute("value", "subtask");
                //button.setAttribute("id", "proj");
                

                column.appendChild(button);
            }*/
                
          if(j==0){
                //column.textContent= data[i][1]+" - "+timeArray[0]+" Hrs "+timeArray[1]+" Mins ";
                let data2=data[i][1]+" - "+timeArray[0]+" Hrs "+timeArray[1]+" Mins ";
                let id_data="proj"+i;
                const text1 = document.createElement("input");
                text1.setAttribute("type", "text");
                text1.setAttribute("value", data2);
                //text1.setAttribute("id", "id_data");
                text1.setAttribute("class", "font-16");
                text1.setAttribute('onclick', 'pri_task(this.value)');
                text1.setAttribute("readonly", "");
               // text1.setAttribute("onclick","getPrimaryTasks();");*/
                column.appendChild(text1);
            } 
            row.appendChild(column); 
        }
        
        
        tableBody2.appendChild(row);
    }

        }
    
async function pri_task(x,y) {
    alert(x);
   
    
            if(typeof x != "undefined") {
                flow = x;
            }
            let projectFilter, pTaskFilter, employeeFilter;
            /*if(flow == 0) {
                document.getElementById("employee-filter-2").value = "";
                document.getElementById("ptask-filter-2").innerHTML = `<option selected value="">None</option>`;
                document.getElementById("project-filter-2").innerHTML = `<option selected value="">None</option>`;
                
        
                projectFilter = document.getElementById("project-filter-1");
                pTaskFilter = document.getElementById("ptask-filter-1");
                employeeFilter = document.getElementById("employee-filter-1");
            }*/
            if(flow != "") {
                document.getElementById("project-filter-1").value = "";
                document.getElementById("ptask-filter-1").innerHTML = `<option selected value="">None</option>`;
                document.getElementById("employee-filter-1").innerHTML = `<option selected value="">None</option>`;
        
                projectFilter = pro1;
                pTaskFilter = x;
                employeeFilter = document.getElementById("employee-filter-2");
            }
            else {
                return;
            }
            
        
            const parameters = new URLSearchParams({
                "project-filter": projectFilter.value,
                "employee-filter": employeeFilter.value,
                "ptask-filter": pTaskFilter.value,
                "in-month": inMonth.value,
                "in-year": inYear.value,
                "sorting-order": sortingOrder.value
            });
        
            const url = "./../api/admin/employees.php?"+parameters;
            let response = await fetch(url);
            data = await response.json();
            console.log(data);
            genTable();
        }

