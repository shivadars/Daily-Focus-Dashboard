<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Focus Dashboard</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            background:#f4f6f9;
        }

        .container{
            width:80%;
            margin:40px auto;
        }

        .header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        .btn{
            background:#0d6efd;
            color:white;
            border:none;
            padding:10px 20px;
            border-radius:5px;
            cursor:pointer;
        }

        .progress-card{
            background:white;
            padding:20px;
            border-radius:8px;
            margin-bottom:30px;
            box-shadow:0 2px 8px rgba(0,0,0,.1);
        }

        .progress{
            width:100%;
            height:20px;
            background:#ddd;
            border-radius:20px;
            overflow:hidden;
            margin-top:10px;
        }

        .progress-bar{
            width:0%;
            height:100%;
            background:green;
        }

        .task-list{
            display:flex;
            flex-direction:column;
            gap:20px;
        }

        .empty{
            background:white;
            padding:40px;
            border-radius:8px;
            text-align:center;
            color:#777;
            box-shadow:0 2px 8px rgba(0,0,0,.1);
        }

        /* Modal */

        .modal{
            display:none;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,.5);
        }

        .modal-content{
            background:white;
            width:500px;
            margin:100px auto;
            padding:25px;
            border-radius:8px;
        }

        .modal-content h2{
            margin-bottom:20px;
        }

        .modal-content label{
            display:block;
            margin-top:15px;
            margin-bottom:5px;
        }

        .modal-content input,
        .modal-content textarea,
        .modal-content select{

            width:100%;
            padding:10px;
            border:1px solid #ccc;
            border-radius:5px;

        }

        .modal-content textarea{
            resize:none;
            height:100px;
        }

        .modal-buttons{
            margin-top:20px;
            display:flex;
            justify-content:flex-end;
            gap:10px;
        }

        #closeModal{

            padding:10px 20px;
            border:none;
            background:#888;
            color:white;
            cursor:pointer;
            border-radius:5px;

        }

    </style>

</head>

<body>

<div class="container">

    <div class="header">

        <div>
            <h1>🎯 Daily Focus Dashboard</h1>
            <p>Today's Tasks</p>
        </div>

        <button class="btn" id="addTaskBtn">
            + Add Task
        </button>

    </div>

    <div class="progress-card">

        <h2>Today's Progress</h2>

        <div class="progress">
            <div class="progress-bar"></div>
        </div>

        <p style="margin-top:10px;">
            0 / 0 Tasks Completed
        </p>

    </div>

    <div class="task-list">

        <div class="empty">

            <h3>No Tasks Yet</h3>

            <p>
                Click <b>Add Task</b> to create your first task.
            </p>

        </div>

    </div>

</div>

<!-- Modal -->

<div id="taskModal" class="modal">

    <div class="modal-content">

        <h2>Add New Task</h2>

        <form>

            <label>Task Title</label>
            <input type="text" placeholder="Enter task title">

            <label>Description</label>
            <textarea placeholder="Enter description"></textarea>

            <label>Priority</label>

            <select>
                <option>High</option>
                <option>Medium</option>
                <option>Low</option>
            </select>

            <div class="modal-buttons">

                <button type="button" id="closeModal">
                    Cancel
                </button>

                <button type="submit" class="btn">
                    Save Task
                </button>

            </div>

        </form>

    </div>

</div>

<!-- JavaScript -->

<script>

const addTaskBtn = document.getElementById("addTaskBtn");

const taskModal = document.getElementById("taskModal");

const closeModal = document.getElementById("closeModal");

addTaskBtn.onclick = function(){

    taskModal.style.display = "block";

}

closeModal.onclick = function(){

    taskModal.style.display = "none";

}

window.onclick = function(event){

    if(event.target == taskModal){

        taskModal.style.display = "none";

    }

}

</script>

</body>
</html>