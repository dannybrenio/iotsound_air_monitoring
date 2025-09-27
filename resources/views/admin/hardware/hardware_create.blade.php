<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Create</title>
</head>
 <h2>Register Hardware</h2>
<body>
    <a href="{{ route('hardware.index') }}"> Return </a>

    <form method="POST" action ="{{ route('hardware.store') }}">
    @csrf

     <label>Unregistered Hardware:</label> 
    <select name="hardware_info">
    @foreach($pending_list as $pending)
        <option value="{{ $pending->pending_id}}">
            {{ $pending->hardware_info }}
        </option>
    @endforeach
    </select>
    <!-- <input type="text" name="hardware_info" value="{{ old('hardware_info') }}"><br> -->
    <!-- <label>Hardware Location:</label>
    <input type="text" name="hardware_location" value="{{ old('hardware_location') }}"><br> -->
    <button type="submit">Register</button>
    <!-- todo: create a pressable button for the located hardware -->
    </form>
</body>
</html>