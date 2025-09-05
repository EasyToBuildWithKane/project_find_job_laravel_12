<form id="form-company-profile" data-section="{{ $profile->section_key }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $profile->title) }}"
            required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4" class="form-control" required>{{ old('description', $profile->description) }}</textarea>
    </div>

    <div class="form-group">
        <label for="image">Image (optional)</label>
        <input type="file" name="image" id="image" class="form-control-file">
        @if ($profile->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $profile->image) }}" alt="Image" width="150">
            </div>
        @endif
    </div>

    <button type="submit" class="btn btn-primary btn-submit">Update Section</button>
</form>

<script>
    $(document).ready(function() {
        $('#form-company-profile').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let section = form.data('section');
            let url = "{{ url('admin/company_about/') }}/" + section;

            let formData = new FormData(this);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(res) {
                    Swal.fire({
                        icon: res.icon,
                        title: res.title,
                        text: res.text
                    });
                    $('#modal-company-profile').modal('hide');
                    if ($.fn.DataTable.isDataTable('#table-2')) {
                        $('#table-2').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    let err = xhr.responseJSON;
                    let msg = '';

                    if (err) {
                        msg = err.text || err.message || JSON.stringify(err);
                    } else {
                        msg = xhr.status + ' - ' + xhr.statusText;
                    }

                    Swal.fire('Error', msg, 'error');
                    console.error('AJAX Error:', xhr);
                }

            });
        });
    });
</script>
