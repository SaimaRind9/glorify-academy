<h1>Add New Class</h1>

<form action="{{route('class-rooms.store')}}" method="POST">

@csrf

<input 
type="text"
name="class_name"
placeholder="Class Name">


<textarea 
name="description"
placeholder="Description">
</textarea>


<button type="submit">
Save Class
</button>

</form>