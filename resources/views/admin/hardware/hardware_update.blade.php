<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Update</title>
</head>
 <h2>Update Hardware Info</h2>
<body>
    <a href="{{ route('hardware.index') }}"> Return </a>
    <form method="POST" action ="{{ route('hardware.update', $hardware->hardware_id) }}">
    @csrf
    @method('PUT')
    <label>Hardware Name:</label>
    <input type="text" name="hardware_info" value="{{ old('hardware_info') }}"><br>
    <label>Hardware Location:</label>
    <input type="text" name="hardware_location" value="{{ old('hardware_location') }}"><br>
    <button type="submit">Update</button>
    <!-- todo: create a pressable button for the located hardware -->
    </form>
</body>
</html>