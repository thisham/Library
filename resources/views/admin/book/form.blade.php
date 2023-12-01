<x-app-admin-layout :assets="$assets ?? []">
    <div>
        <?php
        $id = $id ?? null;
        ?>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['admin.book.update', $id],
                'method' => 'put',
                'enctype' => 'multipart/form-data',
            ]) !!}
        @else
            {!! Form::open(['route' => ['admin.book.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
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
                            <a href="{{ route('admin.book.index') }}" class="btn btn-sm btn-primary"
                                role="button">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="title">Book Title<span
                                            class="text-danger">*</span></label>
                                    {!! Form::text('title', old('title'), [
                                        'class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''),
                                        'placeholder' => 'Book Title',
                                        'autofocus',
                                        'required',
                                    ]) !!}

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label" for="authors">Book Authors <span
                                            class="text-danger">*</span></label>
                                    {!! Form::select(
                                        'authors[]',
                                        $id ? $data->authors->pluck('name', 'id')->toArray() : [],
                                        old('authors', $id ? array_keys($data->authors->pluck('name', 'id')->toArray()) : []),
                                        [
                                            'class' => 'form-control authors' . ($errors->has('authors') ? ' is-invalid' : ''),
                                            'multiple' => 'multiple',
                                            'autofocus',
                                            'required',
                                        ],
                                    ) !!}

                                    @error('authors')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label" for="publisher">Book Publisher<span
                                            class="text-danger">*</span></label>
                                    {!! Form::text('publisher', old('publisher'), [
                                        'class' => 'form-control' . ($errors->has('publisher') ? ' is-invalid' : ''),
                                        'placeholder' => 'Book Publisher',
                                        'autofocus',
                                        'required',
                                    ]) !!}

                                    @error('publisher')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label" for="published_year">Book Published Year<span
                                            class="text-danger">*</span></label>
                                    {!! Form::number('published_year', old('published_year'), [
                                        'class' => 'form-control' . ($errors->has('published_year') ? ' is-invalid' : ''),
                                        'placeholder' => 'Book Published Year',
                                        'autofocus',
                                        'required',
                                        'min' => 1901,
                                        'max' => date('Y'),
                                    ]) !!}

                                    @error('published_year')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label" for="categories">Book Categories<span
                                            class="text-danger">*</span></label>
                                    {!! Form::select(
                                        'categories[]',
                                        $id ? $data->categories->pluck('name', 'id')->toArray() : [],
                                        old('categories', $id ? array_keys($data->categories->pluck('name', 'id')->toArray()) : []),
                                        [
                                            'class' => 'form-control categories' . ($errors->has('categories') ? ' is-invalid' : ''),
                                            'multiple' => 'multiple',
                                            'autofocus',
                                            'required',
                                        ],
                                    ) !!}

                                    @error('categories')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label" for="isbn">Book ISBN</label>
                                    {!! Form::text('isbn', old('isbn'), [
                                        'class' => 'form-control' . ($errors->has('isbn') ? ' is-invalid' : ''),
                                        'placeholder' => 'Book ISBN',
                                        'autofocus',
                                    ]) !!}

                                    @error('isbn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label" for="language">Book Language<span
                                            class="text-danger">*</span></label>
                                    {!! Form::select(
                                        'language',
                                        ['Indonesia' => 'Indonesia', 'Arab' => 'Arab', 'Inggris' => 'Inggris'],
                                        old('language'),
                                        [
                                            'class' => 'form-control' . ($errors->has('language') ? ' is-invalid' : ''),
                                            'placeholder' => 'Select Book Language',
                                            'required',
                                        ],
                                    ) !!}

                                    @error('language')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label" for="pages">Book Pages<span
                                            class="text-danger">*</span></label>
                                    {!! Form::number('pages', old('pages'), [
                                        'class' => 'form-control' . ($errors->has('pages') ? ' is-invalid' : ''),
                                        'placeholder' => 'Book Pages',
                                        'autofocus',
                                        'required',
                                    ]) !!}

                                    @error('pages')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="form-label" for="cover_image">Book Cover Image</label>
                                    {!! Form::file('cover_image', [
                                        'class' => 'form-control' . ($errors->has('cover_image') ? ' is-invalid' : ''),
                                        'accept' => 'image/jpeg,image/png,image/jpg',
                                    ]) !!}
                                    @error('cover_image')
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
        $(".authors").select2({
            placeholder: "Select a author",
            ajax: {
                url: "{{ route('admin.get.authors') }}",
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
        $(".categories").select2({
            placeholder: "Select a category",
            ajax: {
                url: "{{ route('admin.get.categories') }}",
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
