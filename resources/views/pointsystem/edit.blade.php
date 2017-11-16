@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<form method="POST" action="{{ url('pointsystem/update/'.$personid.' ') }}" role="form">
<!--    <input type="hidden" name="_method" value="PUT">-->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">View Case</h3>
        </div>
        <div class="alert alert-info alert-dismissable"> 
            <b>Note:</b> Please input case remarks. </b>
        </div>
       
       <?php foreach ($content as $d):?>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="vertical-align:middle;">Agent name: </td>
                        <td><input readonly type="text" class="form-control" name="personid" value="<?php echo $personid ?>" style="width: 200px;" ></td>
                        
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Kudos: </td>
                        <td><input type="text" class="form-control" name="kudos" value="<?= $d->kodus ? $d->kodus:"0"?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> CRR: </td>
                        <td><input type="text" class="form-control" name="crr" value="<?= $d->crr ? $d->crr:"0"?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> NPS: </td>
                        <td><input type="text" class="form-control" name="nps" value="<?= $d->nps ?  $d->nps:"0"?>"  style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> AHT: </td>
                        <td><input type="text" class="form-control" name="aht" value="<?= $d->aht ?  $d->aht:"0"?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> SAS: </td>
                        <td><input type="text" class="form-control" name="sas" value="<?= $d->sas ?  $d->sas:"0"?>"  style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Agent positive feedback: </td>
                        <td><input type="text" class="form-control" name="agentposfb" value="<?= $d->agentposfb ? $d->agentposfb:"0"?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> No late: </td>
                        <td><input type="text" class="form-control" name="nolate" value="<?= $d->nolate ?  $d->nolate:"0"?>"  style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> No absent: </td>
                        <td><input type="text" class="form-control" name="noabsent" value="<?= $d->noabsent ?  $d->noabsent:"0"?>"  style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> OOTD: </td>
                        <td><input type="text" class="form-control" name="ootd" value="<?= $d->ootd ? $d->ootd:"0"?>"  style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Trivia: </td>
                        <td><input type="text" class="form-control" name="trivia" value="<?= $d->trivia ? $d->trivia:"0"?>" style="width: 200px;"></td>   
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Timestamp: </td>
                        <td>
                          <div class="input-group date" style="width: 150px;">
                            <div class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </div>
                          <input readonly type="text" class="form-control" name="timestamp" style="width: 150px;" value="<?php echo date('Y-m-d H:i:s') ?>">
                          </div>

                        </td>
                          <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="personid" value="<?php echo $personid; ?>">
        <div class="box-footer">
            <div class="foot-area" style="float: right;">
            <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-update"></i> Update Now</button>
            </div>
        </div>
             </div>
    </div>
</form>
 
@endsection

@section('additional_scripts')

@endsection


