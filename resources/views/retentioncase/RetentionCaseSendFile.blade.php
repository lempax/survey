______________________________________________________________________________________________<br>
<table id="agent_stats" style="border-collapse: collapse; clear: both; margin-top: 6px !important; margin-bottom: 6px !important; max-width: none !important; width: 60%; border: 2px solid #F4F4F4;">

   
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;"><b>Sent: </b></label><label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;"><?php echo date("l, F j, Y g:i A"); ?> </label> <br>
        
    <thead>
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 16px; text-align: left;">RETENTION CASE</label><br>
        -----------------------------------------------------------------------------------------------------------------------------
    </thead>
    
    <tbody>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; width: 40%; text-align: left;">Logged By:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{Auth::user()->name}}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; width: 40%; text-align: left;">Customer ID:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $customer_id }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Contract ID:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $contract_id }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Email Address:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $email_address }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; text-align: left;">Date of Retention Offer Sent:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $date }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; text-align: left;">Current Price:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $current_price }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; text-align: left;">Price Offered:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $price_offered }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; text-align: left;">Status:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $status }}</td>
        </tr>
    </tbody>   
</table>

    <!--    footer-->
   <br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;">    To view the details of the bug request please login to:</label><br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;"><a href="{{ asset('/retentioncase/edit/'.$id.'') }}">{{ asset('/retentioncase/edit/'.$id.'') }}</a></label>
    <br><br>
    ----------------------------------------------------------------------------------------------------------------------------<br> 
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;">This message is automatically generated by the 1&1 Bug Request Tool.<br>
    If you have received this email in error, please notify the IT Department and delete the email.</label>