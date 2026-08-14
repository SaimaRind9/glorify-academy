<!DOCTYPE html>
<html>
<head>
    <title>Add Teacher</title>
</head>

<body>

<h1>Add New Teacher</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('teachers.store') }}" method="POST">

    @csrf

    <label>Teacher Name</label>
    <br>
    <input type="text" name="name" value="{{ old('name') }}">
    <br><br>

    <label>Email Address</label>
    <br>
    <input type="email" name="email" value="{{ old('email') }}">
    <br><br>

    <label>Phone</label>
    <br>
    <input type="text" name="phone" value="{{ old('phone') }}">
    <br><br>

    <label>Qualification</label>
    <br>
    <input type="text" name="qualification" value="{{ old('qualification') }}">
    <br><br>

    <label>Experience</label>
    <br>
    <input type="text" name="experience" value="{{ old('experience') }}">
    <br><br>

    <label>Assign Class</label>
    <br>

    <select name="class_room_id">

        <option value="">Select Class</option>

        @foreach($classes as $class)

            <option value="{{ $class->id }}"
                {{ old('class_room_id') == $class->id ? 'selected' : '' }}>
                {{ $class->class_name }}
            </option>

        @endforeach

    </select>

    <br><br>

    <label>Status</label>
    <br>

    <select name="status">

        <option value="Active"
            {{ old('status') == 'Active' ? 'selected' : '' }}>
            Active
        </option>

        <option value="Inactive"
            {{ old('status') == 'Inactive' ? 'selected' : '' }}>
            Inactive
        </option>

    </select>

    <br><br>

    <button type="submit">
        Save Teacher
    </button>

</form>

</body>
</html>