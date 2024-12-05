function toggleOverlay() {

    let t = document.getElementById("overlay-form");
    if(t.style.display == "flex") {

        t.style.display = "none";
    }
    else {

        t.style.display = "flex";
    }
}
function showDetails(x) {

    if(x.style.transform == "rotate(90deg)") {

        x.style.transform = "rotate(0deg)";
        x.parentNode.parentNode.parentNode.parentNode.style.height = "65px";
    }
    else {
        x.style.transform = "rotate(90deg)";
        x.parentNode.parentNode.parentNode.parentNode.style.height = "fit-content";
    }
}
let primaryTask = document.getElementById("primary-task");
let secondaryTask = document.getElementById("secondary-task");
async function getSecondaryTasks() {

    let response = await fetch("./api/secondaryTask.php?primary-task="+primaryTask.value);
    let secondaryTaskList = await response.json();
    secondaryTask.innerHTML = "";
    let option = document.createElement("option");
    option.setAttribute("selected", true);
    option.setAttribute("value", 0);
    option.textContent = "Select a secondary task";
    secondaryTask.appendChild(option);
    const l = secondaryTaskList.length;
    for(let i=0; i<l; i++) {

        let option = document.createElement("option");
        option.setAttribute("value", secondaryTaskList[i][0]);
        option.textContent = secondaryTaskList[i][1];
        secondaryTask.appendChild(option);
    }
}