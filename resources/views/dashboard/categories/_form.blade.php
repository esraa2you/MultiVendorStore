@if ($errors->any())
    <div class="alert alert-danger">
        <h3>Errors Occured!</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif

<div class="form-group">

    {{-- <input type="text" name="name" @class(['form-control', 'is-invalid' => $errors->has('name')]) value="{{ old('name', $category->name) }}">
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror --}}
    <x-form.input label="Category Name" name="name" :value="$category->name" class="form-control" role="input" />
</div>

<div class="form-group">
    <label>Parent</label>
    <select type="text" name="parent_id" class="form-control form-select">
        <option value="">Primary Category</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @if (old('parent_id', $category->parent_id) == $parent->id) selected @endif>
                {{ $parent->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    {{-- <label for="">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea> --}}
    <x-form.textarea label="Description" name="description" :value="$category->description" />
</div>

<div class="form-group">
    {{-- <label for="">Image</label>
    <input type="file" name="image" class="form-control" accept="image/*"> --}}
    <x-form.label for="image">Image</x-form.label>
    <x-form.input type="file" name="image" accept="image/*" />
    @if ($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="" height="100">
    @endif
</div>
<div class="form-group">
    {{-- <label for="">Status</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" @if (old('status', $category->status) == 'active') checked @endif
            value="active">
        <label class="form-check-label">
            active
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status"@if (old('status', $category->status) == 'archived') checked @endif
            value="archived">
        <label class="form-check-label">
            archived
        </label>
    </div> --}}
    <x-form.radio label="Category Status" name="status" :checked="$category->status" :options="['active' => 'Active', 'archived' => 'Archived']" />
</div>

<div class="form-group">

    <button type="submit" class="btn btn-primary"> {{ $button_label ?? 'Save' }}</button>
</div>
