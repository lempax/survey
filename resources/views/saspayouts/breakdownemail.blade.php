<?php

echo '<p style="font-family: arial; font-size: 12px;">Hi '.$emp.',<br><br>';
echo 'You have '.$count_packages.' upsells for the month of '.$month.'.<br><br>';
echo 'You may check your SAS payout with the link below:<br>';
echo 'URL: <a href="' . url('sas/payout_breakdown') . '">' . url('sas/payout_breakdown') . '</a><br><br>';
echo "-----------------------------------------------------------------------------------------<br>";
echo "<div style='text-align: left; font-size: 12px; font-family: arial;'>This message is automatically generated by the 1&1 MIS-EWS Website.<br>";
echo "If you have received this email in error, please notify the IT Department and delete the email.<br>";