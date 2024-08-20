<form action="{{ route('updateChartTitle') }}" method="POST">
    @csrf
    <input type="text" name="chart_title" value="{{ old('chart_title', $chartConfiguration->chart_title ?? '') }}" required>
    <button type="submit" class="btn btn-primary">Update Chart Title</button>
</form>