<td>
    @can('address_show')
    <a href="{{ route('address', $model->id) }}" class="btn btn-success btn-xs mb-1" title="Data Alamat">
        <i class="fas fa-address-book"></i>
    </a>
@endcan

    @can('customer_update')
        <a href="{{ route('customer.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1">
            <i class="fas fa-edit"></i>
        </a>
    @endcan
    @can('customer_delete')
        <form action="{{ route('customer.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('delete')
            <button class="btn btn-danger btn-xs mb-1">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>
