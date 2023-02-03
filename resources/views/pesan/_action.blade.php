<td>
    @can('pesan_update')
        @if ($model->is_read == 0)
            <form action="{{ route('updateStatus', $model->id) }}" method="post" class="d-inline"
                onsubmit="return confirm('Yakin ingin update status terbaca ?')">
                @csrf
                @method('put')
                <button class="btn btn-success btn-xs mb-1">
                    <i class="fas fa-check"></i>
                </button>
            </form>


        @else
            <a href="#" title="Update Terbaca" class="btn btn-success btn-xs mb-1">
                <i class="fas fa-check"></i>
            </a>
        @endif

    @endcan

    @can('pesan_update')
        <a href="{{ route('pesan.edit', $model->id) }}" title="Edit" class="btn btn-primary btn-xs mb-1">
            <i class="fas fa-edit"></i>
        </a>
    @endcan
    @can('pesan_delete')
        <form action="{{ route('pesan.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('delete')
            <button class="btn btn-danger btn-xs mb-1">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>
