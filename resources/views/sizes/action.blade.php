<div class="bn-group">
    <button type="button" class="btn btn-info btn-sm text-white mx-1" data-toggle="modal" data-target="#edit{{ $size->id }}"
        title="{{ __('Edit') }}">
        <i class="fa fa-edit"></i>
    </button>
    <a data-href="{{route('sizes.destroy', $size->id)}}" title="{{ __('Delete') }}"
        class="btn btn-warning btn-sm delete_item"><i class="fa fa-trash"></i>
    </a>
</div>

{{-- modal edit --}}
<div class="modal fade" id="edit{{ $size->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('sizes.editsize') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('sizes.update',$size->id) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">@lang('sizes.sizename')</label>
                        <div class="select_body d-flex justify-content-between align-items-center">
                            <input type="text" class="form-control" placeholder="@lang('sizes.sizename')"
                                name="name" value="{{ old('name', $size->name) }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <button class="btn btn-primary btn-sm ml-2" type="button"
                                data-toggle="collapse" data-target="#translation_table_size"
                                aria-expanded="false" aria-controls="collapseExample">
                                {{ __('categories.addtranslations') }}
                            </button>
                        </div>
                        @include('layouts.translation_inputs', [
                            'attribute' => 'name',
                            'translations' => [],
                            'type' => 'size',
                            'data' => $size,
                        ])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end modal edit --}}
