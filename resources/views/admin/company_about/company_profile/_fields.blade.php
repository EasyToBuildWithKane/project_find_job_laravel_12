<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control"
        value="{{ old('title', $profile->title) }}" required>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" rows="4" class="form-control" required>{{ old('description', $profile->description) }}</textarea>
</div>

<div class="form-group">
    <label for="image">Image (optional)</label>
    <input type="file" name="image" class="form-control-file">
    @if ($profile->image)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $profile->image) }}" alt="Image" width="150" id="preview-image">
        </div>
    @endif
</div>
