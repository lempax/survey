______________________________________________________________________________________________<br>
<table id="agent_stats" style="border-collapse: collapse; clear: both; margin-top: 6px !important; margin-bottom: 6px !important; max-width: none !important; width: 60%; border: 2px solid #F4F4F4;">

    <thead>
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;"><b>Sent: </b></label><label style="font-family: Helvetica,Arial,sans-serif; font-size: 14px; text-align: left;"><?php echo date("l, F j, Y g:i A"); ?> </label><br><br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 16px; text-align: left;"><b>REPAIRED ITEM TOOL</b></label><br>
        -----------------------------------------------------------------------------------------------------------------------------
    </thead>
    
    <tbody>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; width: 40%; text-align: left;">Name:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ Auth::user()->name }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Department:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $department }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Request ID:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $request_id }}</td>
        </tr>
    </tbody>    
</table>

<table id="agent_stats" style="border-collapse: collapse; clear: both; margin-top: 6px !important; margin-bottom: 6px !important; max-width: none !important; width: 60%; border: 2px solid #F4F4F4;">
    <thead>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9;">Description</th>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9;">Brand</th>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9;">Serial</th>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9;">Defect</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
                $units = json_decode($defect);
                foreach($units as $_test){
                   print '<tr>';
                   print '<td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">'.$_test->description.'</center></td>';
                   print '<td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">'.$_test->brand.'</center></td>';
                   print '<td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">'.$_test->serial.'</center></td>';
                   print '<td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">'.$_test->defect.'</center></td>';
                   print '</tr>';  
                }
            ?>
        </tr>
    </tbody>
</table>

    <!--    footer-->
   <br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;">    To view the details of the returned item please login to:</label><br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;"><a href="{{ asset('/repaireditem/edit/'.$id.'') }}">{{ asset('/repaireditem/edit/'.$id.'') }}</a></label>
    <br><br>
    ----------------------------------------------------------------------------------------------------------------------------<br> 
    <label style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; text-align: left;">This message is automatically generated by the 1&1 Repaired Item Tool.<br>
    If you have received this email in error, please notify the IT Department and delete the email.</label>