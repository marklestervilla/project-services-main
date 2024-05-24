<?php
include('config/dbcon.php');
?>

<!-- Task Modal Add -->
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel"> <i class="fas fa-plus-circle"></i> Add Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your form for adding a task goes here -->
                
                <!-- removed action code-proj.php -->

                <form id="taskFormAdd" method="post" enctype="multipart/form-data"> <!-- store to addedTasks Array -->
                    <div class="form-group">
                        <label for="taskName">Task Name</label>
                        <input type="text" class="form-control" id="taskNameAdd" name="task_name" placeholder="Enter task name" required>
                    </div>

                    <!-- Removed Project Name Select with Project id-->


                    <div class="form-group">
                        <label for="taskDescription">Description</label>
                        <textarea class="form-control" id="taskDescriptionAdd" name="description" rows="3" placeholder="Enter task description" required></textarea>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label>Worker</label>
                        <select name="worker">
                            <option value="" hidden>Select Worker</option>
                        </select>

                        <label>Materials</label>
                        <select name="worker">
                            <option value="" hidden>Select Worker</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="taskName">Start Date</label>
                        <input type="datetime-local" class="form-control" id="taskStartDateAdd" name="start_date" required>

                        <label for="taskName">Due Date</label>
                        <input type="datetime-local" class="form-control" id="taskDueDateAdd" name="due_date" required>
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority:</label>
                        <select id="taskPriorityAdd" name="priority" class="form-control" required>
                            <option value="" hidden>Select Priority Level</option>
                            <option value="0">Low</option>
                            <option value="1">Medium</option>
                            <option value="2">High</option>
                        </select>
                    </div>

                    <!-- Removed Status Selection fixed to 0 => Pending -->

                    <input type="text" id="taskStatusAdd" name="status" class="form-control" value="0" required readonly hidden>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Task</button> <!-- Removed name="saveTask" -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- // Task List Card -->
</div>