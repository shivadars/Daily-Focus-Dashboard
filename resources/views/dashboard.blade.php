<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daily Focus Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f4f6f9;
        }

        .container {
            width: 80%;
            margin: 40px auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .btn {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-warning {
            background: #ffc107;
            color: #000;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .progress-card, .task-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,.1);
        }

        .progress {
            width: 100%;
            height: 20px;
            background: #ddd;
            border-radius: 20px;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress-bar {
            height: 100%;
            background: green;
        }

        .task-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .task-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .task-card-actions {
            display: flex;
            gap: 10px;
        }

        .empty {
            background: white;
            padding: 40px;
            border-radius: 8px;
            text-align: center;
            color: #777;
            box-shadow: 0 2px 8px rgba(0,0,0,.1);
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,.5);
        }

        .modal-content {
            background: white;
            width: 500px;
            margin: 100px auto;
            padding: 25px;
            border-radius: 8px;
        }

        .modal-content h2 {
            margin-bottom: 20px;
        }

        .modal-content label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        .modal-content input,
        .modal-content textarea,
        .modal-content select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .modal-content textarea {
            resize: none;
            height: 100px;
        }

        .modal-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-cancel {
            padding: 10px 20px;
            border: none;
            background: #888;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Daily Focus Dashboard</h1>
            <p>Today's Tasks</p>
        </div>

        <button class="btn" id="addTaskBtn">+ Add Task</button>
    </div>

    @php
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'completed')->count(); 
        $percentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
    @endphp

    <div class="progress-card">
        <h2>Today's Progress</h2>
        <div class="progress">
            <div class="progress-bar" style="width: {{ $percentage }}%;"></div>
        </div>
        <p style="margin-top:10px;">
            {{ $completedTasks }} / {{ $totalTasks }} Tasks Completed ({{ $percentage }}%)
        </p>
    </div>

    <div class="task-list">
    @if($tasks->count() > 0)
        @foreach($tasks as $task)
            <div class="task-card">
                <div class="task-card-header">
                    <div style="display: flex; align-items: flex-start; gap: 15px;">
                        <input 
                            type="checkbox" 
                            class="toggle-status-btn" 
                            data-id="{{ $task->id }}" 
                            {{ $task->status === 'completed' ? 'checked' : '' }}
                            style="margin-top: 6px; transform: scale(1.3); cursor: pointer;"
                        >
                        <div>
                            <h3 id="task-title-{{ $task->id }}" style="{{ $task->status === 'completed' ? 'text-decoration: line-through; color: #888;' : '' }}">{{ $task->title }}</h3>
                            <p id="task-desc-{{ $task->id }}" style="color: {{ $task->status === 'completed' ? '#aaa' : '#666' }}; margin-top: 5px;">{{ $task->description }}</p>
                            <small style="display:inline-block; margin-top: 10px; padding: 2px 8px; background: #eee; border-radius: 3px;">
                                Priority: {{ $task->priority }}
                            </small>
                        </div>
                    </div>

                    <div class="task-card-actions">
                        <button 
                            type="button" 
                            class="btn btn-warning editTaskBtn"
                            data-id="{{ $task->id }}"
                            data-title="{{ $task->title }}"
                            data-description="{{ $task->description }}"
                            data-priority="{{ $task->priority }}"
                        >
                            Edit
                        </button>

                        <form action="/tasks/{{ $task->id }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this task?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty">
            <h3>No Tasks Yet</h3>
            <p>Click <b>Add Task</b> to create your first task.</p>
        </div>
    @endif
    </div>

</div>

<div id="addTaskModal" class="modal">
    <div class="modal-content">
        <h2>Add New Task</h2>
        <form method="POST" action="/savetask">
            @csrf

            <label>Task Title</label>
            <input type="text" name="title" placeholder="Enter task title" required>

            <label>Description</label>
            <textarea placeholder="Enter description" name="description"></textarea>

            <label>Priority</label>
            <select name="priority">
                <option value="High">High</option>
                <option value="Medium" selected>Medium</option>
                <option value="Low">Low</option>
            </select>

            <div class="modal-buttons">
                <button type="button" class="btn-cancel closeModalBtn">Cancel</button>
                <button type="submit" class="btn">Save Task</button>
            </div>
        </form>
    </div>
</div>

<div id="editTaskModal" class="modal">
    <div class="modal-content">
        <h2>Edit Task</h2>
        <form id="editTaskForm" method="POST" action="">
            @csrf
            @method('PUT')

            <label>Task Title</label>
            <input type="text" id="edit_title" name="title" required>

            <label>Description</label>
            <textarea id="edit_description" name="description"></textarea>

            <label>Priority</label>
            <select id="edit_priority" name="priority">
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>

            <div class="modal-buttons">
                <button type="button" class="btn-cancel closeModalBtn">Cancel</button>
                <button type="submit" class="btn">Update Task</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal Elements
    const addTaskBtn = document.getElementById("addTaskBtn");
    const addTaskModal = document.getElementById("addTaskModal");
    const editTaskModal = document.getElementById("editTaskModal");
    const closeBtns = document.querySelectorAll(".closeModalBtn");

    // Open Add Modal
    addTaskBtn.onclick = function() {
        addTaskModal.style.display = "block";
    }

    // Open Edit Modal with Dynamic Data
    document.querySelectorAll(".editTaskBtn").forEach(button => {
        button.onclick = function() {
            const taskId = this.getAttribute("data-id");
            const taskTitle = this.getAttribute("data-title");
            const taskDesc = this.getAttribute("data-description");
            const taskPriority = this.getAttribute("data-priority");

            // Update form action route dynamically
            document.getElementById("editTaskForm").action = "/tasks/" + taskId;

            // Fill form inputs
            document.getElementById("edit_title").value = taskTitle;
            document.getElementById("edit_description").value = taskDesc;
            document.getElementById("edit_priority").value = taskPriority;

            // Show Edit Modal
            editTaskModal.style.display = "block";
        }
    });

    // Close Modals on Cancel
    closeBtns.forEach(btn => {
        btn.onclick = function() {
            addTaskModal.style.display = "none";
            editTaskModal.style.display = "none";
        }
    });

    // Close Modal when clicking outside content area
    window.onclick = function(event) {
        if (event.target == addTaskModal) addTaskModal.style.display = "none";
        if (event.target == editTaskModal) editTaskModal.style.display = "none";
    }

    // Toggle Task Status (AJAX)
    document.querySelectorAll(".toggle-status-btn").forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const taskId = this.getAttribute("data-id");
            const isCompleted = this.checked;
            const titleEl = document.getElementById("task-title-" + taskId);
            const descEl = document.getElementById("task-desc-" + taskId);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Optimistic UI update (instantly cross out text)
            if (isCompleted) {
                titleEl.style.textDecoration = "line-through";
                titleEl.style.color = "#888";
                descEl.style.color = "#aaa";
            } else {
                titleEl.style.textDecoration = "none";
                titleEl.style.color = "#000";
                descEl.style.color = "#666";
            }

            // Send request to backend
            fetch(`/tasks/${taskId}/toggle`, {
                method: 'PATCH', 
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ status: isCompleted ? 'completed' : 'pending' })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Reload page to update the progress bar at the top
                    // (We can do this without reloading later by updating the DOM directly)
                    window.location.reload(); 
                }
            })
            .catch(error => console.error('Error updating task:', error));
        });
    });
</script>

</body>
</html>