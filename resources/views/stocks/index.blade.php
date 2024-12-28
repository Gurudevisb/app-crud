<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <h1>STOCK</h1>
    <div>
        @if(session()->has('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif
    </div>

    <!-- Total Portfolio Value -->
    <div>
        <h2>Total Value: ${{ number_format($totalValue, 2) }}</h2>
    </div>

    <!-- Top Performing Stock -->
    <div>
        @if(isset($topStock))
            <h3>Top Performing Stock</h3>
            <p><strong>Name:</strong> {{ $topStock->name }}</p>
            <!-- <p><strong>Quantity:</strong> {{ $topStock->qty }}</p>
            <p><strong>Price:</strong> ${{ number_format($topStock->price, 2) }}</p>
            <p><strong>Value:</strong> ${{ number_format($topStock->qty * $topStock->price, 2) }}</p> -->
        @else
            <p>No stocks available to determine the top-performing stock.</p>
        @endif
    </div>

    <!-- Button to Create a Stock -->
    <div>
        <a href="{{ route('stock.create') }}" class="btn btn-create">Create a Stock</a>
    </div>

    <!-- Stock Table -->
    <div>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Ticker</th>
                <th>Distribution (%)</th> <!-- Added column for Distribution -->
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach($stocks as $stock)
                <tr>
                    <td>{{ $stock->id }}</td>
                    <td>{{ $stock->name }}</td>
                    <td>{{ $stock->qty }}</td>
                    <td>${{ number_format($stock->price, 2) }}</td>
                    <td>{{ $stock->ticker }}</td>
                    <td>{{ number_format($stock->distributionPercentage, 2) }}%</td> <!-- Display distribution -->
                    <td>
                        <a href="{{ route('stock.edit', ['stock' => $stock]) }}" class="btn btn-edit">Edit</a>
                    </td>
                    <td>
                        <form method="post" action="{{ route('stock.destroy', ['stock' => $stock]) }}">
                            @csrf 
                            @method('delete')
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>

                        <!-- <form action="{{ route('stocks.destroy', $stock) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this stock?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
 -->

                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
