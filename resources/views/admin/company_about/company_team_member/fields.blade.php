<div class="form-group">
    <label for="full_name">Full Name <span class="text-danger">*</span></label>
    <input type="text" name="full_name" class="form-control"
           value="{{ old('full_name', $member->full_name) }}" required>
</div>

<div class="form-group">
    <label for="job_title">Job Title</label>
    <input type="text" name="job_title" class="form-control"
           value="{{ old('job_title', $member->job_title) }}">
</div>

<div class="form-group">
    <label for="department">Department</label>
    <input type="text" name="department" class="form-control"
           value="{{ old('department', $member->department) }}">
</div>

<div class="form-group">
    <label for="location">Location</label>
    <input type="text" name="location" class="form-control"
           value="{{ old('location', $member->location) }}">
</div>

<div class="form-group">
    <label for="profile_image_url">Profile Image</label>
    <input type="file" name="profile_image_url" id="profile_image_url" class="form-control-file">
    @if ($member->profile_image_url)
        <div class="mt-2">
            <img src="{{ asset($member->profile_image_url) }}" width="100" class="rounded shadow" id="preview-profile-image">
        </div>
    @endif
</div>

<div class="form-group">
    <label for="rating">Rating</label>
    <input type="number" name="rating" class="form-control"
           value="{{ old('rating', $member->rating) }}" min="0" max="5">
</div>

<div class="form-group">
    <label for="review_count">Review Count</label>
    <input type="number" name="review_count" class="form-control"
           value="{{ old('review_count', $member->review_count) }}">
</div>

<div class="form-group">
    <label for="social_links">Social Links (JSON)</label>
    <textarea name="social_links" rows="2" class="form-control">{{ old('social_links', json_encode($member->social_links)) }}</textarea>
</div>

<div class="form-group">
    <label for="is_featured">Featured</label>
    <select name="is_featured" class="form-control">
        <option value="0" {{ !$member->is_featured ? 'selected' : '' }}>No</option>
        <option value="1" {{ $member->is_featured ? 'selected' : '' }}>Yes</option>
    </select>
</div>

<div class="form-group">
    <label for="display_order">Display Order</label>
    <input type="number" name="display_order" class="form-control"
           value="{{ old('display_order', $member->display_order) }}">
</div>
