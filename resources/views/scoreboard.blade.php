@extends('layout.app')

@section('title', '記分板')

@section('content')
    <h1 class="has-text-centered is-1 title">記分板</h1>
    @if($chart !== null)
        <div>{!! $chart->container() !!}</div>
    @endif

    @if(count($scores) === 0)
        <div class="notification is-warning" style="margin-top: 20px;">
            <p class="has-text-centered has-text-weight-bold">沒有任何參賽者！</p>
        </div>
    @else
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
            @php($prev = -1)
            @php($j=0)
            @foreach($scores as $name => $score)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $name }}</td>
                    <td>{{ $score }}</td>
                </tr>
                @if($prev === $score)
                    @php($j+=1)
                @else
                    @php($i+=$j + 1)
                    @php($j = 0)
                    @php($prev = $score)
                @endif
            @endforeach
            </tbody>
        </table>
    @endif
@endsection

@section('js')
    <script src="//cdn.jsdelivr.net/npm/chart.js@2.7.2/dist/Chart.min.js"></script>
    @if($chart !== null)
        {!! $chart->script() !!}
    @endif
@endsection