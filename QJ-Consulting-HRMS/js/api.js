/*let sortingOrder = document.getElementById("sorting-order");
let inMonth = document.getElementById("in-month");
let inYear = document.getElementById("in-year");

let tableHead = document.getElementById("table-heading");
let tableBody = document.getElementById("table-body");
let tableBody2 = document.getElementById("table-body2");
let tableBody3= document.getElementById("table-body3");
var data, flow = -1;
async function getData(x) {
    alert(document.getElementById("ptask_filter_2"));
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

        projectFilter = document.getElementById("project_filter_2");
        pTaskFilter = document.getElementById("ptask_filter_2");
        employeeFilter = document.getElementById("employee-filter-2");
        alert(employeeFilter+""+projectFilter+""+pTaskFilter);
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
    tableBody2.innerHTML="";
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
        for(let j=0; j<=1; j++) {

            const column = document.createElement("td");
            
            /*if(j==1){
                var button = document.createElement("input");
                button.setAttribute("type", "submit");
                button.setAttribute("value", "subtask");
                //button.setAttribute("id", "proj");
                

                column.appendChild(button);
            }
                let data1=data[i][1]
                let time=timeArray[0]+" Hrs "+timeArray[1]+" Mins ";  
          if(j==0){
                //column.textContent= data[i][1]+" - "+timeArray[0]+" Hrs "+timeArray[1]+" Mins ";
                
                //let id_data="proj"+i;
                const text1 = document.createElement("input");
                text1.setAttribute("type", "text");
                text1.setAttribute("value", data1);
                //text1.setAttribute("id", "id_data");
                text1.setAttribute("class", "font-16");
                text1.setAttribute('onclick', 'pro(this.value)');
                text1.setAttribute("readonly", "");
               // text1.setAttribute("onclick","getPrimaryTasks();");
                column.appendChild(text1);
            } 
            if(j==1){
                column.textContent=time;
            }
            row.appendChild(column); 
        }
        
        
        tableBody.appendChild(row);
    }
    
}
/*var Table = document.getElementById('proj');
var rowLength = Table.rows.length;*/


/*var Table = document.getElementById('proj');
var rowLength = Table.rows.length;
var row = document.getElementById("proj");

for(let i=0; i<l; i++) {
    
        document.getElementById("proj").rows[i].cells[0].addEventListener("click",getPrimaryTasks());;
    
}
 

async function pro(x){
        tableBody2.innerHTML = "";
        let y=1;
        alert(x+""+y);
        let pro1=x;
        document.getElementById("project_filter_2").value=document.getElementById("project_filter_2").value;

        let timeArray;
        let parameters, primaryTask;
        if(y == 1) {
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
            
            const row = document.createElement("tr");
        
            for(let j=0; j<=1; j++) {

            const column = document.createElement("td");
            
            
                let data2=data[i][1]
                let time2=timeArray[0]+" Hrs "+timeArray[1]+" Mins ";  
                if(j==0){
                   
                let id_data="proj"+i;
                const text1 = document.createElement("input");
                text1.setAttribute("type", "text");
                text1.setAttribute("value", data2);
                //text1.setAttribute("id", "id_data");
                text1.setAttribute("class", "font-16");
                text1.setAttribute('onclick', 'data_em(this.value)');
                text1.setAttribute("readonly", "");
               // text1.setAttribute("onclick","getPrimaryTasks();");
                column.appendChild(text1);
                } 
                if(j==1){
                column.textContent=time2;
                }
            row.appendChild(column); 
        }
        
        
        tableBody2.appendChild(row);
    }

}
    
async function data_em(sub_task) {
    alert(sub_task);
    let x=1;
    document.getElementById("ptask_filter_2").value=sub_task;
    alert(document.getElementById("project_filter_2").value);
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

        projectFilter = document.getElementById("project_filter_2");
        pTaskFilter = document.getElementById("ptask_filter_2");
       
        employeeFilter = document.getElementById("employee-filter-2");
        alert(projectFilter.value+""+pTaskFilter.value+""+employeeFilter.value);
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

function genTable() {

    tableBody3.innerHTML = "";
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
        tableBody3.appendChild(row);
    }
}
*/
const employeeSelect = document.getElementById('employee-select');
    const totalTimeCell = document.getElementById('total-time');
    const projectRows = document.querySelectorAll('.project-row');
    const taskRows = document.querySelectorAll('.task-row');
    const expandCollapseBtns = document.querySelectorAll('.expand-collapse');
    const projectTimeCells = document.querySelectorAll('#project-time-1');
    const taskTimeCells = document.querySelectorAll('#task-time-1');

    employeeSelect.addEventListener('change', () => {
      const selectedEmployee = employeeSelect.value;
      alert(selectedEmployee);
      // Calculate and display total time for the selected employee
      updateTotalTime(selectedEmployee);
    });

    expandCollapseBtns.forEach((btn, index) => {
      btn.addEventListener('click', () => {
        const row = btn.closest('tr');
        const isProjectRow = row.classList.contains('project-row');
        const isTaskRow = row.classList.contains('task-row');

        if (isProjectRow) {
          row.classList.toggle('active');
          row.nextElementSibling.style.display = row.classList.contains('active') ? 'table-row' : 'none';
        } else if (isTaskRow) {
          row.classList.toggle('active');
          row.nextElementSibling.style.display = row.classList.contains('active') ? 'table-row' : 'none';
        }

        btn.textContent = row.classList.contains('active') ? '-' : '+';
      });
    });

    function updateTotalTime(employeetotaltime) {
        var myArray = employeetotaltime.split("-");
      // Calculate and update the total time for the selected employee
      totalTimeCell.textContent = myArray[2];
    }

    function updateProjectTime(projectId) {
      // Calculate and update the total time for the selected project
      projectTimeCells[projectId - 1].textContent = '4 hours';
    }

    function updateTaskTime(taskId) {
      // Calculate and update the total time for the selected task
      taskTimeCells[taskId - 1].textContent = '4 hours';
    }