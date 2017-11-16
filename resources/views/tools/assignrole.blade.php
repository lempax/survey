@extends('layouts.master')

@section('additional_styles')

@endsection

@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ $name }}</h3>
    </div>
    <div class="box-body">
        <form method="POST" role="form" action="{{ asset('roles/update') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            @if($msg == 'success')
                <div class="alert alert-success alert-dismissible" style="width: 25%;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Successfully Updated!</h4>
                  </div>
            @endif
            
            <table id="table_breakdown" class="table table-bordered table-hover table-striped" style="width: 25%;">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select type="text" name="uid" class="form-control" required>
                                <option value="">Select Employee</option>
                                @foreach($agents AS $agent)
                                <option value="{{ $agent->uid }}">{{ $agent->lname.' '.$agent->fname }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select type="text" name="role" class="form-control" required>
                                <option value="">Select Role</option>
                                <option value="ST">Special Task</option>
                                <option value="L2">2ND LEVEL</option>
                                <option value="RTA">RTA</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="submit" class="btn btn-primary"></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
@endsection

@section('additional_scripts')
@endsection