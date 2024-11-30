<div class="mb-3">
    <label for="{{ $id }}">{{ ucfirst($label) }}</label>
    <select name="{{ $name }}" id="{{ $id }}" class="form-control" required>
        <option value="" disable selected>Select {{ ucfirst($label) }}</option>
        @foreach($options as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>
</div>

