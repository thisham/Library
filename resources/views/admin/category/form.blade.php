<x-app-admin-layout :assets="$assets ?? []">
    <div>
        <?php
        $id = $id ?? null;
        ?>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['admin.category.update', $id],
                'method' => 'put',
                'enctype' => 'multipart/form-data',
            ]) !!}
        @else
            {!! Form::open(['route' => ['admin.category.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        @endif
        <div class="row">
            @empty(!$id)
                <div class="col-xl-9 col-lg-8">
                @endempty
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $id !== null ? 'Update' : 'New' }} Category</h4>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('admin.category.index') }}" class="btn btn-sm btn-primary"
                                role="button">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="fname">Name<span
                                            class="text-danger">*</span></label>
                                    {!! Form::text('name', old('name'), [
                                        'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                                        'placeholder' => 'Book Category Name',
                                        'autofocus',
                                        'required',
                                    ]) !!}

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ $id !== null ? 'Update' : 'Add' }}
                                Category</button>
                        </div>
                    </div>
                </div>

                @empty(!$id)
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <p class="mb-0"><b>Created at</b></p>
                                    <p class="mb-2">
                                        {{ $data->created_at == null ? '-' : \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}
                                    </p>
                                    <p class="mb-0"><b>Last modified at</b></p>
                                    <p class="mb-0">
                                        {{ $data->updated_at == null ? '-' : \Carbon\Carbon::parse($data->updated_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty
        </div>
        {!! Form::close() !!}
    </div>
</x-app-admin-layout>
