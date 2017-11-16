<table id="agent_stats" style="border-collapse: collapse; clear: both; margin-top: 6px !important; margin-bottom: 6px !important; width:1200px; border: 2px solid #F4F4F4;">
    <thead>
        <tr>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; width: 10%; background-color: #F9F9F9;">Logged By</th>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; width: 5%; background-color: #F9F9F9;">Customer ID</th>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; width: 5%; background-color: #F9F9F9;">Contract ID</th>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; width: 10%; background-color: #F9F9F9;">Email Address</th>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; width: 5%; background-color: #F9F9F9;">Product ID</th>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; width: 10%; background-color: #F9F9F9;">Date of Request</th>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; width: 10%; background-color: #F9F9F9;">Date of Effect</th>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; width: 15%; background-color: #F9F9F9;">Type</th>
            <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; width: 30%; background-color: #F9F9F9;">Reason</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $name->name }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $customer_id }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $contract_id }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $email }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $product_id }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ date("F j, Y", strtotime($cancellation_date)) }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ date("F j, Y", strtotime($effective_date)) }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;">{{ $type }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center; vertical-align: top;"><?php echo $reason ?></td>
        </tr>
    </tbody>
</table>

----------------------------------------------------------------------------------------------------------------------------------<br>
This message is automatically generated by the 1&1 Cancellation Request Tool.<br>
If you have received this email in error, please notify the IT Department and delete the email.
