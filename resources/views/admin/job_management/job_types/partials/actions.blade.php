<div class="text-center">
    <a href="{{ route('admin.job_types.edit', $row->id) }}" class="btn btn-sm btn-primary"><i
            class="fas fa-edit"></i></a>
    <button type="button" class="btn btn-sm btn-danger btn-delete"
        data-url="{{ route('admin.job_types.destroy', $row->id) }}">
        <i class="fas fa-trash"></i></button>
</div>