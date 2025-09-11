<div class="form-group">
    <label for="section_key">Section Key</label>
    <input type="text" name="section_key" class="form-control"
        value="{{ old('section_key', $profile->section_key) }}" readonly>
</div>

<div class="form-group">
    <label for="title">Title <span class="text-danger">*</span></label>
    <input type="text" name="title" class="form-control"
        value="{{ old('title', $profile->title) }}" required>
</div>

<div class="form-group">
    <label for="headline">Headline <span class="text-danger">*</span></label>
    <input type="text" name="headline" class="form-control"
        value="{{ old('headline', $profile->headline) }}" required>
</div>

<div class="form-group">
    <label for="summary">Summary</label>
    <textarea name="summary" rows="3" class="form-control">{{ old('summary', $profile->summary) }}</textarea>
</div>

<div class="form-group">
    <label for="body">Body <span class="text-danger">*</span></label>
    <textarea name="body" rows="5" class="form-control" required>{{ old('body', $profile->body) }}</textarea>
</div>

<div class="form-group">
    <label for="featured_image">Featured Image</label>
    <input type="file" name="featured_image_url" id="featured_image_url" class="form-control-file">
    @if ($profile->featured_image_url)
        <div class="mt-2">
            <img src="{{ asset( $profile->featured_image_url) }}" 
                 alt="Featured Image" width="150" id="preview-featured-image" class="rounded shadow">
        </div>
    @endif
</div>

<div class="form-group">
    <label for="cta_label">CTA Label</label>
    <input type="text" name="cta_label" class="form-control"
        value="{{ old('cta_label', $profile->cta_label) }}">
</div>

<div class="form-group">
    <label for="cta_link">CTA Link</label>
    <input type="url" name="cta_link" class="form-control"
        placeholder="https://example.com"
        value="{{ old('cta_link', $profile->cta_link) }}">
</div>
