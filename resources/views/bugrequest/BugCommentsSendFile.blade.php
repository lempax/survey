______________________________________________________________________________________________<br>
<table id="agent_stats" style="border-collapse: collapse; clear: both; margin-top: 6px !important; margin-bottom: 6px !important; max-width: none !important; width: 60%; border: 2px solid #F4F4F4;">

   
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;"><b>Sent: </b></label><label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;"><?php echo date("l, F j, Y g:i A"); ?> </label> <br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;"><b>Subject: </b></label> <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px;">Bug Request Comment </label><br><br><br>
    
    
    <thead>
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 16px; text-align: left;">BUG REQUEST COMMENT</label><br>
        -----------------------------------------------------------------------------------------------------------------------------
    </thead>
    
    <tbody>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; width: 40%; text-align: left;">Comment by:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $username }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Message:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $message }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Comment Date</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $comment_date }}</td>
        </tr>
    </tbody>    

</table>
    <!--    footer-->
    ----------------------------------------------------------------------------------------------------------------------------<br> 
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;">This message is automatically generated by the 1&1 Bug Request Tool.<br>
    If you have received this email in error, please notify the IT Department and delete the email.</label>