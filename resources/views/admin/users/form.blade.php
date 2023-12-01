<x-app-admin-layout :assets="$assets ?? []">
    <div>
        <?php
        $id = $id ?? null;
        ?>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['admin.user.update', $id],
                'method' => 'put',
                'enctype' => 'multipart/form-data',
            ]) !!}
        @else
            {!! Form::open(['route' => ['admin.user.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        @endif
        <div class="row">
            @empty(!$id)
                <div class="col-xl-9 col-lg-8">
                @endempty
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $id !== null ? 'Update' : 'New' }} User</h4>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-primary"
                                role="button">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="name">Name<span
                                            class="text-danger">*</span></label>
                                    {!! Form::text('name', old('name'), [
                                        'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                                        'placeholder' => 'User\'s Name',
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

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="email">Email<span
                                            class="text-danger">*</span></label>
                                    {!! Form::email('email', old('email'), [
                                        'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
                                        'placeholder' => 'User\'s Email',
                                        'required',
                                    ]) !!}

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="phone">Phone Number<span
                                            class="text-danger">*</span></label>
                                    {!! Form::tel('phone', old('phone'), [
                                        'class' => 'form-control' . ($errors->has('phone') ? ' is-invalid' : ''),
                                        'placeholder' => 'User\'s Phone Number',
                                        'required',
                                    ]) !!}

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="password">Password<span
                                            class="text-danger">*</span></label>
                                    {!! Form::password('password', old('password'), [
                                        'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
                                        'placeholder' => 'Password',
                                        'required',
                                    ]) !!}

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="password_confirmation">Password Confirmation<span
                                            class="text-danger">*</span></label>
                                    {!! Form::password('password_confirmation', old('password_confirmation'), [
                                        'class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''),
                                        'placeholder' => 'Password Confirmation',
                                        'required',
                                    ]) !!}

                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="address">Address<span
                                            class="text-danger">*</span></label>
                                    {!! Form::textarea('address', old('address'), [
                                        'class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : ''),
                                        'placeholder' => 'User\'s Address',
                                        'autofocus',
                                        'required',
                                    ]) !!}

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ $id !== null ? 'Update' : 'Add' }}
                                User</button>
                        </div>
                    </div>
                </div>
            </div>

            @empty(!$id)
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
