@extends('layouts.app')

@section('content')

<h3 class="mb-4">Tasks</h3>

<div class="row">

<!-- LEFT SIDE (Create Task) -->
<div class="col-md-4">

<div class="card shadow-sm">
<div class="card-body">

<h5 class="mb-3">Create Task</h5>

<div class="mb-2">
<input type="text" id="title" class="form-control" placeholder="Title">
</div>

<div class="mb-2">
<input type="text" id="description" class="form-control" placeholder="Description">
</div>

<div class="mb-2">
<select id="status" class="form-control">
<option value="">status</option>
<option value="todo">Todo</option>
<option value="in-progress">in-Progress</option>
<option value="done">Done</option>
</select>
</div>

<div class="mb-2">
<select id="priority" class="form-control">
<option value="">Priority</option>
<option value="Low">Low</option>
<option value="Medium">Medium</option>
<option value="High">High</option>
</select>
</div>

<div class="mb-2">
<input type="date" id="due_date" class="form-control">
</div>

<div class="d-grid">
<button onclick="createTask()" class="btn btn-success">
+ Add Task
</button>
<a href="{{url('/api/')}}" class="btn btn-info mt-2">Back</a>
</div>

</div>
</div>

</div>

{{-- Filter section --}}
<div class="col-md-8">

<!-- Filter Right side-->
<div class="card shadow-sm mb-3">
<div class="card-body">

<div class="row g-2 align-items-end">

<div class="col-md-4">
<label>Status</label>
<select id="filter_status" class="form-control">
<option value="">All</option>
<option value="todo">Todo</option>
<option value="in-progress">In Progress</option>
<option value="done">Done</option>
</select>
</div>

<div class="col-md-4">
<label>Sort</label>
<select id="sort" class="form-control">
<option value="">None</option>
<option value="due_date">Due Date</option>
</select>
</div>

<div class="col-md-4 d-grid">
<button onclick="loadTasks()" class="btn btn-primary">
Apply
</button>
</div>

</div>

</div>
</div>
{{-- table create --}}
<div class="card shadow-sm">
<div class="card-body p-0">

<table class="table table-bordered ">

<thead>
<tr>
<th>Title</th>
<th>Description</th>
<th>Status</th>
<th>Priority</th>
<th>Due Date</th>
<th>Delete</th>
</tr>
</thead>

<tbody id="taskTable"></tbody>

</table>
<div class="modal" id="editModal" tabindex="-1">

<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">
<h5>Edit Task</h5>
</div>

<div class="modal-body">

<input type="hidden" id="task_id">

<div class="mb-2">
<label>Title</label>
<input type="text" id="edit_title" class="form-control">
</div>

<div class="mb-2">
<label>Description</label>
<input type="text" id="edit_description" class="form-control">
</div>

<div class="mb-2">
<label>Status</label>

<select id="edit_status" class="form-control">

<option value="todo">Todo</option>
<option value="in-progress">In Progress</option>
<option value="done">Done</option>

</select>

</div>

<div class="mb-2">

<label>Priority</label>

<select id="edit_priority" class="form-control">

<option value="low">Low</option>
<option value="medium">Medium</option>
<option value="high">High</option>

</select>

</div>

<div class="mb-2">

<label>Due Date</label>

<input type="date" id="edit_due_date" class="form-control">
</div>

</div>

<div class="modal-footer">

<button onclick="updateTask()" class="btn btn-primary">
Update
</button>

</div>

</div>

</div>
</div>

<script>
const params=new URLSearchParams(window.location.search);

const project_id=params.get('project');

function loadTasks(){

let status=document.getElementById('filter_status').value;

let sort=document.getElementById('sort').value;

let url = `/api/projects/${project_id}/tasks?status=${status}&sort=${sort}`;

fetch(url)

.then(res=>res.json())

.then(data=>{

let html='';

data.data.forEach(t=>{
html+=`

<tr>
<td>${t.title}</td>
<td>${t.description}</td>
<td>${t.status}</td>
<td>${t.priority}</td>
<td>${t.due_date}</td>

<td>
<button onclick="editTask(${t.id},'${t.title}','${t.description}','${t.status}','${t.priority}','${t.due_date}')"
class="btn btn-warning btn-sm">
Edit

</button>

<button onclick="deleteTask(${t.id})"
class="btn btn-danger btn-sm">
Delete

</button>

</td>

</tr>`;
});
document.getElementById('taskTable').innerHTML=html;
});

}
function deleteTask(id){

if(!confirm('Are you sure you want to delete this task?')) return;

fetch('/api/tasks/'+id,{
method:'DELETE'
})
.then(()=>loadTasks());
}

function editTask(id,title,desc,status,priority,due){

document.getElementById('task_id').value=id;
document.getElementById('edit_title').value=title;
document.getElementById('edit_description').value=desc;
document.getElementById('edit_status').value=status;
document.getElementById('edit_priority').value=priority;
document.getElementById('edit_due_date').value=due;

new bootstrap.Modal(document.getElementById('editModal')).show();
}

function updateTask()
{
let id = document.getElementById('task_id').value;

fetch('/api/tasks/' + id,{
method:'POST',
headers:{
'Accept':'application/json',
'Content-Type':'application/x-www-form-urlencoded'
},
body:new URLSearchParams({
title:document.getElementById('edit_title').value,
description:document.getElementById('edit_description').value,    
status:document.getElementById('edit_status').value,
priority:document.getElementById('edit_priority').value,
due_date:document.getElementById('edit_due_date').value
})
})
.then(res => res.json())
.then(data => {     
    console.log(data);
loadTasks();
bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
})
.catch(() => alert('Update failed'));
}

function createTask(){

fetch(`/api/projects/${project_id}/tasks`,{
method:'POST',
headers:{
'Accept':'application/json',
'Content-Type':'application/x-www-form-urlencoded'
},
body:new URLSearchParams({
title:document.getElementById('title').value,
description:document.getElementById('description').value,
status:document.getElementById('status').value,
priority:document.getElementById('priority').value,
due_date:document.getElementById('due_date').value
})
})
.then(res => res.json())
.then(() => {
loadTasks();

// clear fields
document.getElementById('title').value='';
document.getElementById('description').value='';
document.getElementById('priority').value='';
document.getElementById('due_date').value='';
})
.catch(()=>alert('Task creation failed'));
}

loadTasks();

</script>
@endsection