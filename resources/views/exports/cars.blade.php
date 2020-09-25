<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Color</th>
        <th>Gov. Number</th>
        <th>VIN</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Year</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cars as $car)
        <tr>
            <td>{{ $car->name }}</td>
            <td>{{ $car->color }}</td>
            <td>{{ $car->gov_number }}</td>
            <td>{{ $car->vin_code }}</td>
            <td>{{ $car->brand }}</td>
            <td>{{ $car->model }}</td>
            <td>{{ $car->year }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
