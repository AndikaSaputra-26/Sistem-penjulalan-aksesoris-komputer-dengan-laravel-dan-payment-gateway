<td class="text-center">
    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
        action="{{ route('roles.destroy', $model->id) }}" method="POST">
        @can('role_detail')
            <a href="{{ route('roles.show', $model->id) }}"
                class="btn btn-sm btn-success">SHOW</a>
        @endcan
        @can('role_update')
            <a href="{{ route('roles.edit', $model->id) }}"
                class="btn btn-sm btn-primary">EDIT</a>
        @endcan
        @csrf
        @method('DELETE')
        @can('role_delete')
            <button type="submit" class="btn btn-sm btn-danger"
                {{ $model->id == 1 ? 'disabled' : null }}>HAPUS</button>
        @endcan
    </form>
</td>
