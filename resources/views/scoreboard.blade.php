@extends('layout.app')

@section('title', '記分板')

@section('content')
    <h1 class="has-text-centered is-1 title">記分板</h1>
    {{--<div class="chart-container" style="position: relative; height:100px; width:100%;">--}}
        {{--<canvas id="scoreboard"></canvas>--}}
        {{--<p class="has-text-centered">Scoreboard chart is not available, coming soon...</p>--}}
    {{--</div>--}}

    <table class="table is-hoverable is-fullwidth is-striped">
        <thead>
        <tr>
            <th>名次</th>
            <th>名稱</th>
            <th>分數</th>
        </tr>
        </thead>
        <tbody>
        @php($i=1)
        @foreach($scores as $name => $score)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $name }}</td>
                <td>{{ $score }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('js')
    <script src="//cdn.jsdelivr.net/npm/chart.js@2.7.2/dist/Chart.min.js"></script>
    <script>
        var scores = JSON.parse('{{ $scores }}'.replace(/&quot;/g, '"'));
        // var ctx = $('canvas#scoreboard');
        // var scoreChart = new Chart(ctx, {
        //     type: line,
        //     datasets: [
        //
        //     ]
        // });
    </script>
@endsection