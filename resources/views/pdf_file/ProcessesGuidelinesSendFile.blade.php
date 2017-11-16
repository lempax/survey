______________________________________________________________________________________________<br>
<table id="agent_stats" style="border-collapse: collapse; clear: both; margin-top: 6px !important; margin-bottom: 6px !important; max-width: none !important; width: 60%; border: 2px solid #F4F4F4;">

   
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;"><b>Sent: </b></label><label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;"><?php echo date("l, F j, Y g:i A"); ?> </label> <br>
        
    <thead>
    <label style="font-family: Helvetica,Arial,sans-serif; font-size: 16px; text-align: left; font-weight: bold">POSTING OF PROCESSES/GUIDELINES</label><br>
        -----------------------------------------------------------------------------------------------------------------------------
    </thead>
    
    <tbody>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; width: 40%; text-align: left;">Uploader:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{Auth::user()->name}}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; width: 40%; text-align: left;">PDF Title:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $pdf_title }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Type:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $type }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">File:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $pdf_name }}</td>
        </tr>
        
    </tbody>   
</table>

    <!--    footer-->
   <br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;">    To view the details of the posting of processes/guidelines please login to:</label><br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;"><a href="{{ asset('/posting/edit/'.$pdf_id.'') }}">{{ asset('/posting/edit/'.$pdf_id.'') }}</a></label>
    <br><br>
    ----------------------------------------------------------------------------------------------------------------------------<br> 
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;">This message is automatically generated by the 1&1 Posting of Processes/Guidelines Tool.<br>
    If you have received this email in error, please notify the IT Department and delete the email.</label>