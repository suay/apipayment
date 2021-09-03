@if($user->count() > 0)
<?php
$key = $from = (($user->currentPage() - 1) * $user->perPage()) + 1;
$allpage = $user->lastPage();
$curPage = $user->currentPage();
$from = (($user->currentPage() - 1) * $user->perPage()) + 1;
$to = (($user->currentPage() - 1) * $user->perPage()) + $user->perPage();
$to = ($to > $user->total()) ? $user->total() : $to;

$lang = App::getLocale();

?>

<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{trans('messages.User.user_list')}}</h3>
            <div class="box-tools">
                <div class="input-group">
                    <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>firstName</th>
                    <th>email</th>
                    <th>typeUser</th>
                    <th>label</th>
                </tr>
                 @if(!empty($user))
                 @foreach($user as $row)
                <tr>
                    <td>{{ $key++}}</td>
                    <td>{{ $row->firstName }}</td>
                    <td>{{ $row->email }}</td>
                    <td>
                        @if(is_null($row->typeUser) && $row->groupType != 1 && $row->groupType != 2) <span class="label label-success">User</span>
                        @elseif($row->typeUser == 0 && $row->groupType != 1 && $row->groupType != 2) <span class="label label-primary">System Admin</span>
                        @elseif($row->groupType == 1 ) <span class="label label-danger">Tier1</span>
                        @elseif($row->groupType == 2 ) <span class="label label-danger">Tier2</span>@endif
                    </td>
                    <td> 
                         <a href="#" class="btn btn-info view_user" data-status="0" data-uid="{{ $row->id }}"
                                data-toggle="modal" data-target="#user-modal" data-placement="top"
                                data-original-title="view">
                                <i class="fa fa-eye">view</i>
                            </a>
                            <a href="#" class="btn btn-success"
                                data-uid="{{ $row->id }}" data-toggle="modal" data-placement="top"
                                data-original-title="{{ trans('messages.edit') }}">
                                <i class="fa-edit">edit</i>
                            </a>
                        
                      </td>
                </tr>
                 @endforeach
                 <tr>
                    <td> Not found </td>
                </tr>
                @endif
            </table>
        </div><!-- /.box-body -->
        <!-- <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">&raquo;</a></li>
            </ul>
        </div> -->
        <div class="row"> 
    @if($allpage > 1)
    <div class="col-sm-3 text-left">

        <div class="dataTables_paginate paging_simple_numbers post-parcel-pagination">
            @if($curPage > 1)
            <a class="btn btn-white paginate-link" href="#"
                data-page="{{ $curPage-1 }}">{{ trans('messages.prev') }}</a>
            @endif
            @if($allpage > 1)
            {!! Form::selectRange('page', 1, $allpage, $curPage, ['class' => 'form-control paginate-select']); !!}
            @endif
            @if($user->hasMorePages())
            <a class="btn btn-white paginate-link" href="#"
                data-page="{{ $curPage+1 }}">{{ trans('messages.next') }}</a>
            @endif
        </div>
    </div>
    @endif
</div>
@else
<div class="col-sm-12 text-center">{{ trans('messages.no_data') }}</div>
<div class="clearfix"></div>
@endif
    </div><!-- /.box -->
</div>
