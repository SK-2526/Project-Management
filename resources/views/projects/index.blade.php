@extends('layouts.app')

@section('content')

<h3>Projects</h3>

<div class="mb-3">

<input type="text" id="name" placeholder="Project name" class="form-control mb-2">

<textarea id="description" placeholder="Description" class="form-control mb-2"></textarea>

<button onclick="createProject()" class="btn btn-primary">
Create Project
</button>

</div>

<table class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Tasks</th>
<th>Delete</th>
</tr>
</thead>

<tbody id="projectTable"></tbody>

</table>

<script>

function loadProjects(url='/api/projects'){

fetch(url)
.then(res=>res.json())
.then(data=>{

let html='';

data.data.forEach(p=>{

html+=`
<tr>
<td>${p.id}</td>
<td>${p.name}</td>
<td>${p.description ?? ''}</td>

<td>
<a href="/api/tasks?project=${p.id}" class="btn btn-success btn-sm">
Tasks
</a>
</td>

<td>
<button onclick="deleteProject(${p.id})"
class="btn btn-danger btn-sm">
Delete
</button>
</td>

</tr>
`;
});

// ADD THIS pagination block (AFTER loop)
let pagination = '';

if(data.prev_page_url){
pagination += `<button onclick="loadProjects('${data.prev_page_url}')" class="btn btn-sm btn-info me-2">Prev</button>`;
}

if(data.next_page_url){
pagination += `<button onclick="loadProjects('${data.next_page_url}')" class="btn btn-sm btn-info">Next</button>`;
}

document.getElementById('projectTable').innerHTML = html + `
<tr>
<td colspan="5">${pagination}</td>
</tr>
`; });

}

function createProject(){

fetch('/api/projects',{
method:'POST',
headers:{
'Content-Type':'application/json'
},
body:JSON.stringify({
name:document.getElementById('name').value,
description:document.getElementById('description').value
})
})
.then(res=>res.json())
.then(()=>loadProjects());
}

function deleteProject(id)
{

if(!confirm('Are you sure you want to delete this Project?')) return;    
fetch('/api/projects/'+id,{
method:'DELETE'
})
.then(()=>loadProjects());

}

loadProjects();

</script>

@endsection