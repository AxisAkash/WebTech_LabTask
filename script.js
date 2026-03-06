let addBtn=document.getElementById("addBtn")
let nameInput=document.getElementById("name")
let rollInput=document.getElementById("roll")
let list=document.getElementById("studentList")

let students = JSON.parse(localStorage.getItem("students")) || []

nameInput.addEventListener("input",function(){
addBtn.disabled=nameInput.value.trim()===""
})

function saveStudents(){
localStorage.setItem("students",JSON.stringify(students))
}

function render(){

list.innerHTML=""

students.forEach((student,index)=>{

let li=document.createElement("li")

let check=document.createElement("input")
check.type="checkbox"
check.checked=student.present

check.onchange=function(){

student.present=check.checked

saveStudents()

updateAttendance()

li.classList.toggle("present",check.checked)

}

let span=document.createElement("span")
span.className="student-info"
span.textContent=student.roll+" – "+student.name

let edit=document.createElement("button")
edit.innerHTML='<i class="fa fa-edit"></i>'

edit.onclick=function(){

let newRoll=prompt("Edit Roll",student.roll)
let newName=prompt("Edit Name",student.name)

if(newRoll && newName){

student.roll=newRoll
student.name=newName

saveStudents()
render()

}

}

let del=document.createElement("button")
del.innerHTML='<i class="fa fa-trash"></i>'

del.onclick=function(){

if(confirm("Delete student?")){

students.splice(index,1)

saveStudents()
render()

}

}

if(student.present) li.classList.add("present")

li.append(check,span,edit,del)

list.appendChild(li)

})

updateCount()
updateAttendance()

}

addBtn.onclick=function(){

let name=nameInput.value.trim()
let roll=rollInput.value.trim()

if(name===""||roll==="") return

students.push({roll,name,present:false})

saveStudents()
render()

nameInput.value=""
rollInput.value=""

addBtn.disabled=true

}

function updateCount(){

document.getElementById("total").textContent=
"Total students: "+students.length

}

function updateAttendance(){

let present=students.filter(s=>s.present).length
let absent=students.length-present

document.getElementById("attendance").textContent=
"Present: "+present+" | Absent: "+absent

}

document.getElementById("search").addEventListener("input",function(){

let text=this.value.toLowerCase()

Array.from(list.children).forEach(li=>{

let name=li.querySelector(".student-info").textContent.toLowerCase()

li.style.display=name.includes(text)?"":"none"

})

})

document.getElementById("sortBtn").onclick=function(){

students.sort((a,b)=>a.name.localeCompare(b.name))

saveStudents()
render()

}

document.getElementById("highlightBtn").onclick=function(){

Array.from(list.children).forEach(li=>li.classList.remove("highlight"))

if(list.firstElementChild){
list.firstElementChild.classList.add("highlight")
}

}

render()