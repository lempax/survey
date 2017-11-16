<table id="agent_stats" style="border-collapse: collapse; clear: both; margin-top: 6px !important; margin-bottom: 6px !important; max-width: none !important; width: 100%; border: 2px solid #F4F4F4;">
    <thead>
        <tr>
            <th rowspan="2" style="border: 2px solid #F4F4F4; background-color: transparent; font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; width: 20%;">{{ $tname }}</th>
            <th colspan="3" style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Productivity</th>
            <th colspan="2" style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Blacklist</th>
            <th colspan="3" style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">CRR Rating</th>
            <th colspan="2" style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">SAS Rating</th>
            <th colspan="3" style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Cosmocom</th>
        </tr>
        <tr>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Calls</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Emails</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Cases</span></th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">BL</span></th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">%</span></th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Ret.</span></th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Yes</span></th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">%</span></th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Sales</span></th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">CR %</span></th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Rel.%</span></th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</span></th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">AVG</span></th>
        </tr>
    </thead>

    <tbody>
        @foreach($ops as $stat)
        <tr>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; background-color: #F9F9F9;">{{ $stat[0] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[1] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[2] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[3] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[4] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[5] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[6] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[7] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[8] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[9] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[10] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[11] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[12] }}</td>
            <td style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif;  font-size: 14px; color: #333; padding: 6px 6px 6px 6px; text-align: center;">{{ $stat[13] }}</td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
            <th style="border: 2px solid #F4F4F4; background-color: transparent; font-family: Source Sans Pro, Helvetica Neue,Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px;">Total</th>
        </tr>
    </tfoot>
</table>