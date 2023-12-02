<x-app-admin-layout :assets="$assets ?? []">
    <div>
        <?php
        $id = $id ?? null;
        ?>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['admin.loan.update', $id],
                'method' => 'put',
                'enctype' => 'multipart/form-data',
            ]) !!}
        @else
            {!! Form::open(['route' => ['admin.loan.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        @endif
        <div class="row">
            @empty(!$id)
                <div class="col-xl-9 col-lg-8">
                @endempty
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $id !== null ? 'Update' : 'New' }} Book</h4>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('admin.loan.index') }}" class="btn btn-sm btn-primary"
                                role="button">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="book_copy_id">Book <span
                                            class="text-danger">*</span></label>
                                    {!! Form::select(
                                        'book_copy_id',
                                        $id ? $data->bookCopy->pluck('name', 'id')->toArray() : [],
                                        old('book_copy_id', $id ? array_keys($data->BookCopy->pluck('name', 'id')->toArray()) : []),
                                        [
                                            'id' => 'book_copy_id',
                                            'class' => 'form-control book' . ($errors->has('book_copy_id') ? ' is-invalid' : ''),
                                            'autofocus',
                                            'required',
                                        ],
                                    ) !!}

                                    @error('book_copy_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label" for="user_id">User <span
                                            class="text-danger">*</span></label>
                                    {!! Form::select(
                                        'user_id',
                                        $id ? $data->user->pluck('name', 'id')->toArray() : [],
                                        old('user_id', $id ? array_keys($data->user->pluck('name', 'id')->toArray()) : []),
                                        [
                                            'id' => 'user_id',
                                            'class' => 'form-control user' . ($errors->has('user_id') ? ' is-invalid' : ''),
                                            'autofocus',
                                            'required',
                                        ],
                                    ) !!}

                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label" for="loan_date">Book Loan Date<span
                                            class="text-danger">*</span></label>
                                    {!! Form::date('loan_date', old('loan_date'), [
                                        'id' => 'loan_date',
                                        'class' => 'form-control' . ($errors->has('loan_date') ? ' is-invalid' : ''),
                                        'placeholder' => 'Loan Date',
                                        'autofocus',
                                        'required',
                                    ]) !!}

                                    @error('loan_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                            </div>
                            <button type="submit" class="btn btn-primary">{{ $id !== null ? 'Update' : 'Add' }}
                                Book</button>
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
<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
        $(".users").select2({
            placeholder: "Select a user",
            ajax: {
                url: "{{ route('admin.get.users') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });
</script>
