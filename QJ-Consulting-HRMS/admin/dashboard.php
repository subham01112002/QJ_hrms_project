<?php
    session_start();
    include("./loginCheck.php");
    include("./../connection/connection.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include("./../title.php"); ?>
        <link rel="stylesheet" href="./../css/style.css">
        <link rel="stylesheet" href="./../css/navigation.css">
    </head>
    <body>
        <style>
            .button-sn:nth-of-type(1)
            {
                background-color: var(--theme-color-2);
                img
                {
                    filter: invert(1);
                }
                div
                {
                    color: var(--theme-color-3);
                }
            }
        </style>
        <?php include("./topNavigation.php"); ?>
        <?php include("./sideNavigation.php"); ?>
        <div class="container">
            <div class="my-32 px-2vw font-32">
                Welcome
            </div>
            <div class="flex flex-column gap-8 my-32 px-2vw font-22">
                Filters
                <div class="flex justify-between font-16">
                    <div class="flex flex-column gap-16">
                        <div class="flex gap-8">
                            <div class="flex flex-column">
                                Project
                                <select id="project-filter-1" class="input-field" onchange="getPrimaryTasks()" style="width: 256px;">
                                    <option selected value="">None</option>
                                    <?php
                                        $query = "SELECT 
                                                    pm.`project_id`,
                                                    pm.`title`,
                                                    SEC_TO_TIME(SUM(TIME_TO_SEC(ptm.total))) AS `total_time`
                                                FROM
                                                    `project_task_map` ptm
                                                LEFT JOIN `project_employee_map` pem ON ptm.`pe_id` = pem.`pe_id`
                                                LEFT JOIN `project_master` pm ON pem.`project_id` = pm.`project_id`
                                                GROUP BY
                                                    pm.`project_id`";
                                        $res = mysqli_query($connection, $query);
                                        while($ar = mysqli_fetch_array($res))
                                        {
                                            $timeArray = explode(":", $ar['total_time']);
                                    ?>
                                            <option value="<?php echo $ar['project_id']; ?>">
                                                <?php 
                                                echo $ar['title'] . " - " . $timeArray[0] . " Hrs " . $timeArray[1] . " Mins"; 
                                                ?>
                                            </option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="flex flex-column">
                                Primary Task
                                <select id="ptask-filter-1" class="input-field" onchange="getEmployees()" style="width: 256px;">
                                    <option selected value="">None</option>
                                </select>
                            </div>
                            <div class="flex flex-column">
                                Employee
                                <select id="employee-filter-1" class="input-field" onchange="getData(0)" style="width: 256px;">
                                    <option selected value="">None</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-8">
                        <div class="flex flex-column">
                                Employee
                                <select id="employee-filter-2" class="input-field" onchange="getProjects()" style="width: 256px;">
                                    <option selected value="">None</option>
                                    <?php
                                        $query = "SELECT 
                                                    em.`emp_id`,
                                                    em.`name`,
                                                    SEC_TO_TIME(SUM(TIME_TO_SEC(ptm.total))) AS `total_time`
                                                FROM
                                                    `project_task_map` ptm
                                                LEFT JOIN `project_employee_map` pem ON ptm.`pe_id` = pem.`pe_id`
                                                LEFT JOIN `employee_master` em ON pem.`emp_id` = em.`emp_id`
                                                GROUP BY
                                                    em.`emp_id`";
                                        $res = mysqli_query($connection, $query);
                                        while($ar = mysqli_fetch_array($res))
                                        {
                                            $timeArray = explode(":", $ar['total_time']);
                                    ?>
                                            <option value="<?php echo $ar['emp_id']; ?>">
                                                <?php 
                                                echo $ar['name'] . " - " . $timeArray[0] . " Hrs " . $timeArray[1] . " Mins"; 
                                                ?>
                                            </option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="flex flex-column">
                              <!--Project-->
                                <select id="project-filter-2" class="input-field" onchange="getPrimaryTasks(1)" style="width: 256px;">
                                    <option  value="">None</option>

                                </select>
                                <input type="hidden" id="project_filter_2" name="project_filter_2">
                            </div>
                            <div class="flex flex-column">
                                <!--Primary Task-->
                                <select id="ptask-filter-2" class="input-field" onchange="getData(1)" style="width: 256px;">
                                    <option  value="">None</option>
                                </select>
                                <input type="hidden" id="ptask_filter_2" name="ptask_filter_2">
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-8">
                        <div class="flex flex-column">
                            Month
                            <select id="in-month" class="input-field" name="in-month" onchange="data_em()">
                                <?php
                                    $currMonth = date("m");
                                    $monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                    for($i=0; $i<12; $i++)
                                    {
                                ?>
                                        <option value="<?php echo $i+1; ?>" <?php echo (($i+1) == $currMonth)? "selected" : ""; ?>><?php echo $monthNames[$i]; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="flex flex-column">
                            Year
                            <select id="in-year" class="input-field" name="in-year" onchange="data_em()">
                                <option value="2024" selected>2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                                <option value="2031">2031</option>
                                <option value="2032">2032</option>
                                <option value="2033">2033</option>
                                <option value="2034">2034</option>
                            </select>
                        </div>
                        <div class="flex flex-column">
                            Order
                            <select id="sorting-order" class="input-field" onchange="getData()">
                                <option value="0">Ascending</option>
                                <option value="1">Descending</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="my-32 px-2vw overflow-x-scroll">
                <table class="w100-percent" id="proj">
                    <thead id="table-heading">
                        <tr>
                            
                            <th style="text-wrap: nowrap;">Project Name</th>
                            <th style="text-wrap: nowrap;">Time</th>
                        
                        </tr>
                    </thead>
                    <tbody id="table-body">
                    
                    </tbody>
                </table>
            </div>
            <div class="my-32 px-2vw overflow-x-scroll">
                <table class="w100-percent" >
                    <thead id="table-heading">
                        <tr>
                            
                            <th style="text-wrap: nowrap;">Primary Task Name</th>
                            <th style="text-wrap: nowrap;">Time</th>
                        
                        </tr>
                    </thead>
                    <tbody id="table-body2">
                    
                    </tbody>
                </table>
            </div>
            <div class="my-32 px-2vw overflow-x-scroll">
                <table class="w100-percent">
                    <thead id="table-heading">
                        <tr>
                            <th>Date</th>
                            <th style="text-wrap: nowrap;">Project Name</th>
                            <th>Employee Name</th>
                            <th>Worked On</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Total Time Worked</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="table-body3">
                    
                    </tbody>
                </table>-->
    <table>
  
    <tr>
      <th>Employee</th>
      <th>Total Time</th>
    </tr>
    <tr>
      <td>
        
        <select id="employee-select" class="input-field" onchange="getProjects()" style="width: 256px;">
                                    <option selected value="">None</option>
                                    <?php
                                        $query = "SELECT 
                                                    em.`emp_id`,
                                                    em.`name`,
                                                    SEC_TO_TIME(SUM(TIME_TO_SEC(ptm.total))) AS `total_time`
                                                FROM
                                                    `project_task_map` ptm
                                                LEFT JOIN `project_employee_map` pem ON ptm.`pe_id` = pem.`pe_id`
                                                LEFT JOIN `employee_master` em ON pem.`emp_id` = em.`emp_id`
                                                GROUP BY
                                                    em.`emp_id`";
                                        $res = mysqli_query($connection, $query);
                                        while($ar = mysqli_fetch_array($res))
                                        {
                                            $timeArray = explode(":", $ar['total_time']);
                                    ?>
                                            <option value="<?php echo $ar['emp_id']; ?>">
                                                <?php 
                                                echo $ar['name'] . " - " . $timeArray[0] . " Hrs " . $timeArray[1] . " Mins"; 
                                                ?>
                                            </option>
                                    <?php
                                        }
                                    ?>
                                </select>
      </td>
      <td id="total-time">-</td>
    </tr>
    <?php
                                        $query = "SELECT 
                                                    pm.`project_id`,
                                                    pm.`title`
                                                    
                                                FROM
                                                    `project_master` pm
                                                INNER JOIN `project_employee_map` pem ON pm.`project_id` = pem.`project_id`
                                                 ";
                                        $res = mysqli_query($connection, $query);
                                        while($ar1 = mysqli_fetch_array($res)) { ?>
    <tr class="project-row">
      <td>
        <span class="expand-collapse">+</span>
        <span><?php  echo $ar1['title'] ?></span>
      </td>
      <td id="project-time-1">-</td>
    </tr>
    <tr class="project-details">
      <td colspan="2">
        <table>
          <tr class="task-row">
            <td>
              <span class="expand-collapse">+</span>
              <span>Task 1</span>
            </td>
            <td id="task-time-1">-</td>
          </tr>
          <tr class="task-details">
            <td>
              <table>
                <tr>
                  <th>Date</th>
                  <th>From</th>
                  <th>To</th>
                  <th>Total Time</th>
                </tr>
                <tr>
                  <td>2023-04-15</td>
                  <td>09:00</td>
                  <td>11:00</td>
                  <td>2 hours</td>
                </tr>
                <tr>
                  <td>2023-04-16</td>
                  <td>13:00</td>
                  <td>15:00</td>
                  <td>2 hours</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <?php } ?>
  </table>


  
            </div>
        </div>
        <script src="./../js/script.js"></script>
        <script src="./../js/api.js"></script>
        
    </body>
</html>