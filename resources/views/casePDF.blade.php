<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<h1>{{ $title }}</h1>
<table  id="cases">
    <thead>
    <tr>
        <th style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd">Case Number</th>
        <th style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Court</th>
        <th style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Bench</th>
        <th style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Case Details</th>
        <th style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Stage</th>
        <th style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Item number</th>
    </tr>
    </thead>
    <tbody>
    @foreach($case_entries as $case)
        <tr>
            <td style="border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd">{{$case['case_number']}} </td>
            <td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd">{{$case['court']}} </td>
            <td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd">{{$case['bench']}} </td>
            <td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd">{{$case['client']}} <br> VS <br> {{$case['opponent_name']}} <br> ({{$case['opponent_advocate']}})</td>
            <td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd">{{$case['stage']}}</td>
            <td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd">{{$case['item_number']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
