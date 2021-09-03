<div class="">
    <div class="user-detail">
        <div class="row">
        
            <div class="col-sm-9">

                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group"><b> firstName</b></div>
                    </div>
                    <div class="col-sm-7">
                        <div class="form-group">{{ $user->firstName}}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group"><b>email</b></div>
                    </div>
                    <div class="col-sm-7">
                        <div class="form-group">{{ $user->email }}</div>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group"><b>typeUser</b></div>
                    </div>
                    <div class="col-sm-7">
                        <div class="form-group">
                            @if(is_null($row->typeUser) && $row->groupType != 1 && $row->groupType != 2)
                            User
                            @elseif($row->typeUser == 0 && $row->groupType != 1 && $row->groupType != 2)
                            System Admin
                            @elseif($row->groupType == 1 )
                            Tier 1
                            @elseif($row->groupType == 2 )
                            Tier 2

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group"><b>{{ trans('messages.regis_date') }} </b></div>
                    </div>
                    <div class="col-sm-7">
                        <div class="form-group"> {{ localDateShort( $user->created_at) }}
                        </div>
                    </div>
                </div>



            </div>


            <div style="clear:both"></div>
        </div>