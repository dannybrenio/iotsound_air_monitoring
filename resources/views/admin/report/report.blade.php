<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reports</title>
</head>
<h2>Reports</h2>
<body>
    <table>
    <tr>
        <th>Report ID</th>
        <th>User Name</th>
        <th>Report Body</th>
        <th>Image Path</th>
        <th>Created At</th>
    </tr>
    @foreach ($reports as $report)
    <tr>
        <td>{{ $report->report_id}}</td>
        <td>{{ $report->user->name}}</td>
        <td>{{ $report->report_body}}</td>
        <!-- no image path yet -->
        <td>{{ $report->image_path}}</td>
        <td>{{ $report->created_at}}</td>
    </tr>
    @endforeach
    </table>
</body>
</html>