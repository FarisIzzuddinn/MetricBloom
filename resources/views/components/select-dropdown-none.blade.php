<div class="mb-3" id="{{ $id }}" style="display:none;">
    <label for="{{ $id }}">{{ ucfirst($label) }}</label>
    <select name="{{ $name }}" id="{{ $id }}" class="form-control required">
        <option value="" disable selected>Select {{ ucfirst($label) }}</option>
        @foreach($options as $option)
            <option value="{{ $option->id}}">{{ $option->name}}</option>
        @endforeach
    </select>
</div>

