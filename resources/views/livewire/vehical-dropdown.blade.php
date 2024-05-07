<select class="form-control form-select" wire:click="changeEvent($event.target.value)">
    <option value="1" {{ $post == 1 ? 'selected="selected"' : '' }}>Active</option>
    <option value="0" {{ $post == 0 ? 'selected="selected"' : '' }}>Inactive</option>
</select>
