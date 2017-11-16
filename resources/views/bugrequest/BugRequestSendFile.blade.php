______________________________________________________________________________________________<br>
<table id="agent_stats" style="border-collapse: collapse; clear: both; margin-top: 6px !important; margin-bottom: 6px !important; max-width: none !important; width: 60%; border: 2px solid #F4F4F4;">

   
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;"><b>Sent: </b></label><label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;"><?php echo date("l, F j, Y g:i A"); ?> </label> <br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;"><b>Subject: </b></label> <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px;">Bug Request {{ $subject }} </label><br><br><br>
    
    
    <thead>
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 16px; text-align: left;">BUG REQUEST</label><br>
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
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Tech ID:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $tech_id }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; text-align: left;">Domain/URL/Project ID:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $project_id }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; text-align: left;">Date Occurrence:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $date_occurrence }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Error Description/Description of the encountered wrong behavior:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;"><?php echo $description ?></td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; text-align: left;">Solution Steps:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;"><?php echo $solution ?></td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Expected Behavior:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;"><?php echo $behavior ?></td>
        </tr>
    
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Step by step instruction to<br> reproduce the problem: </th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;"><?php echo $instruction ?></td>
        </tr>
        <tr>
            <th colspan="2" style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; width: 40%; background-color: #F9F9F9; text-align: left;">Verification with: </th>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; text-align: left;">Browser 1 (Type/Version):</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $browser1 }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; text-align: left;">Browser 2 (Type/Version):</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $browser2 }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9; text-align: left;">Operating System:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $os }}</td>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;  background-color: #F9F9F9; text-align: left;">Status:</th>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $status }}</td>
        </tr>
        
    
    </tbody>    

</table>

    <!--    footer-->
   <br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;">    To view the details of the bug request please login to:</label><br>
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;"><a href="{{ asset('/bugrequest/edit/'.$id.'') }}">{{ asset('/bugrequest/edit/'.$id.'') }}</a></label>
    <br><br>
    ----------------------------------------------------------------------------------------------------------------------------<br> 
    <label style="font-family: Helvetica,Arial,sans-serif; font-style: bold; font-size: 14px; text-align: left;">This message is automatically generated by the 1&1 Bug Request Tool.<br>
    If you have received this email in error, please notify the IT Department and delete the email.</label>