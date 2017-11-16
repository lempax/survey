______________________________________________________________________________________________<br>
<table id="agent_stats" style="border-collapse: collapse; clear: both; margin-top: 6px !important; margin-bottom: 6px !important; max-width: none !important; width: 60%; border: 2px solid #F4F4F4;">

   
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;"><b>Sent: </b></label><label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;"><?php echo date("l, F j, Y g:i A"); ?> </label> <br>   
    
    <thead>
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 16px; text-align: left;">JOB ORDER TOOL</label><br>
        -----------------------------------------------------------------------------------------------------------------------------
    </thead>
    
    <tbody>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; width: 40%; text-align: left;">Requested By:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{Auth::user()->name}}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; width: 40%; text-align: left;">Title:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $title }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Type:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">
            <?php 
                if($type == "isdev") echo "IT Development"; 
                else if ($type == "itserv") echo "IT Service";
                else if ($type == "misc") echo "Miscellaneous"; 
            ?>
            </td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Priority:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">
            <?php 
                if($priority == "critical") echo "Critical"; 
                else if ($priority == "major") echo "Major";
                else if ($priority == "minor") echo "Minor"; 
            ?>
            </td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; text-align: left;">Status:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $status }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Description</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;"><?php echo $description ?></td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Attachments</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;"><a href="{{ asset('/joborder/download/'.$attachments.'') }}"><?php echo $attachments ?></td>
        </tr>
        
    </tbody>    
</table>

    <!---footer--->
    <br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;">    To view the details of the bug request please login to:</label><br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;"><a href="{{ asset('/joborder/view/'.$id.'') }}">{{ asset('/joborder/view/') }}</a></label>
    <br><br>
    ----------------------------------------------------------------------------------------------------------------------------<br> 
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;">This message is automatically generated by the 1&1 Job Order Tool.<br>
    If you have received this email in error, please notify the IT Department and delete the email.</label>