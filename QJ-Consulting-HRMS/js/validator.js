try {
    document.getElementById("add-task-draft").addEventListener("click", (event) => {
    
        if(!validateTaskDraft()) {
            
            event.preventDefault();
        }
    });
}
catch (error) {
    
}

try {
    document.getElementById("apply-leave").addEventListener("click", (event) => {
    
        if(!validateLeaveForm()) {
            
            event.preventDefault();
        }
    });
}
catch (error) {
    
}

const errorDiv = document.createElement("div");
errorDiv.style.color = "red";
errorDiv.style.fontSize = "14px";
errorDiv.innerHTML="This field is required."
function validateTaskDraft() {

    const peID = document.getElementById("pe-id");
    const primaryTask = document.getElementById("primary-task");
    const secondaryTask = document.getElementById("secondary-task");
    const date = document.getElementById("task-date");
    const startTime = document.getElementById("task-start-time");
    const endTime = document.getElementById("task-end-time");

    if(!(checkInputField(peID) && checkInputField(primaryTask) && checkInputField(secondaryTask) && checkInputField(date) && checkInputField(startTime) && checkInputField(endTime))) {

        return false;
    }

    if(startTime.value >= endTime.value) {

        return false;
    }

    return true;
}
function validateLeaveForm() {

    const startDate = document.getElementById("start-date");
    const endDate = document.getElementById("end-date");
    const reason = document.getElementById("reason");

    if(!(checkInputField(startDate) && checkInputField(endDate) && checkInputField(reason))) {

        return false;
    }

    return true;
}
function checkInputField(x)
{
    if(x.nextSibling) {

        x.nextSibling.remove();
    }
    if(x.value == 0 || x.value == "") {
        
        x.parentNode.insertBefore(errorDiv.cloneNode(true), x.nextSibling);
        return false;
    }
    return true;
}