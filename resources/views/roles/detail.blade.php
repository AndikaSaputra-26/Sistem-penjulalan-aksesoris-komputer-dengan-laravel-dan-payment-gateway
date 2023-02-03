@extends('layouts.master')
@section('title', 'Detail Roles')
@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('roles-show', $role) }}
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group">
                           <a href="{{ route('roles.index') }}" class="btn btn-warning" style="float: right"><i class="fa fa-arrow-left"></i> Back</a>
                          </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nama Role</label>
                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="" readonly value="{{ $role->name }}">
                          </div>

                        <div class="row">

                            @foreach (config('permission.authorities') as $manageName => $permission)
                                <div class="col-md-3 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-dark" style="color: white">{{ ucwords($manageName) }}
                                        </div>
                                        <div class="card-body">
                                            @foreach ($permission as $list)
                                                <div class="form-check mb-1">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="{{ Str::slug($list) }}" name="permissions[]"
                                                        value="{{ $list }}"
                                                        {{ $role->hasPermissionTo($list) ? 'checked' : '' }}
                                                        {{ $role->id == 1 ? 'disabled' : '' }} />
                                                    <label class="form-check-label"
                                                        for="{{ Str::slug($list) }}">{{ $list }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
