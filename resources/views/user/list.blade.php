@extends('layouts.base-layout')
<?php
$typeUser = [
    '-' => trans('messages.User.role'),
    'null' => 'User',
    0 => 'System Admin',
    1 => 'Tier 1',
    2 => 'Tier 2',
];
$lang = App::getLocale();
?>
@section('content')
<section class="content-header">
                    <h1>
                        ผู้ใช้
                        <!-- <small>{{trans('messages.User.user_list')}}</small> -->
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                        <li class="active">ผู้ใช้</li>
                    </ol>
</section>
                <!-- search content -->
                <section class="content">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">ค้นหา</h3>
                        </div>
                        <div class="panel-body search-form">
                             <form method="POST" id="search-form" action="#" accept-charset="UTF-8" class="form-horizontal">
                                <div class="row">
                                    <div class="col-sm-3 block-input">
                                        <input class="form-control" size="25" placeholder="{{ trans('messages.fname') }} " name="firstName">
                                    </div>


                                    <div class="col-sm-3 block-input">
                                        {!! Form::select('typeUser', $typeUser,null,['id'=>'role','class'=>'form-control']) !!}
                                    </div>
                                    <br>
                                    <div class="col-sm-12 text-right">
                                        <button type="reset" class="btn btn-white reset-s-btn">ยกเลิก</button>
                                        <button type="button"
                                            class="btn btn-secondary @if(isset($demo)) d-search-property @else p-search-property @endif">ค้นหา</button>
                                    </div>
                                </div>
                            </form>
                        </div> 
                    </div>
                    <!-- add user -->
                <div class="text-right">

                    <a href="{{ route('add_user') }}" class="btn btn-info btn-primary action-float-right" data-toggle="tooltip"
                        data-placement="top" data-original-title="{{trans('messages.User.add_user')}}">
                        <i class="fa fa-plus"></i> เพิ่มผู้ใช้งาน
                    </a>

                </div>

                </section>


<!-- Main content -->
<section class="content"> 
    <div class="row">
        <!-- data -->
        @include('user.list-element')
        
    </div>
</section><!-- /.content --> 

{{--view user--}}
<div class="modal fade" id="user-modal" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> รายละเอียดผู้ใช้</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="view_user" class="form">

                        </div>
                    </div>
                </div>
                <span class="v-loading">กำลังค้นหาข้อมูล...</span>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')

@endsection