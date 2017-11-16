<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>{{ $title }}</title>

        <style type="text/css">
            div, p, a, li, td {
                -webkit-text-size-adjust:none;
            }

            .ExternalClass {
                width: 100%;
                line-height:100%;
            }

            body {
                width: 100%;
                height: 100%;
                margin:0;
                padding:0;
                -webkit-font-smoothing: antialiased;
                -webkit-text-size-adjust:100%;
            }

            html {
                width: 100%;
            }
            
            textArea{
                border: 0px; 
                background-color: #fcfcfd; 
                min-width: 500px; 
                font-family: arial;
                font-size: 10pt;

            }

            table[class=full] {
                padding:0 !important;
                border:none !important;
            }

            @media only screen and (max-width: 800px) {
                body {
                    width:auto!important;
                }

                table[class=full] {
                    width:100%!important;
                }

                table[class=devicewidth] {
                    width:100% !important;
                    padding-left:20px !important;
                    padding-right: 20px!important;
                }

            }

            @media only screen and (max-width: 800px) {
                table[class=devicewidth] {
                    width:100% !important;
                }

                table[class=inner] {
                    width:100%!important;
                    text-align: center!important;
                    clear: both;
                }

                .hide {
                    display:none !important;
                }
            }

            @media only screen and (max-width: 800px) {
                table {
                    border-collapse: collapse;
                }
            }

        </style>
    </head>

    <body>
        <table align="center" class="full" cellspacing="0" height="300" cellpadding="0" style="font-family: Helvetica,sans-serif; background-color: #fcfcfd; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius:5px; margin-top: 10px; font-size: 13px;">
            <tr>
                <td align="center">
                    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="devicewidth" style="border: 1px solid #e0e5e9; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius:5px 5px 0 0;">
                        <tr>
                            <td>
                                <table width="100%" cellspacing="0" cellpadding="0" align="center" class="full" style="background-color: #fcfcfd;">
                                    <tr>
                                        <td height="5">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table border="0" cellspacing="0" cellpadding="0" align="left" class="inner" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin: 0 20px 0 20px; font-size: 12px; color: #00354f;">
                                                <tr>
                                                    <td width="23" class="hide">&nbsp;</td>
                                                    <td height="55" class="inner" valign="middle" style="font-weight: bold;">Hi All,</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    @if($tickets)
                                    <tr>
                                        <td height="20"  colspan="2" style="padding: 0 43px 0 43px; font-size: 12px; color: #00354f;"> 
                                            The following tickets have been processed: <br><br>
                                            @foreach($tickets AS $ticket)
                                                <span>{{ $ticket->category }} - {{ $ticket->ticket_desc }}</span><br>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td height="20"  colspan="2" style="padding: 0 43px 0 43px; font-size: 12px; color: #00354f;"> 
                                            <br>TICKETS QUEUE:<br><br>
                                                <span>Number of tickets during start of the shift:&nbsp;&nbsp;{!!$start_no_tickets!!}</span><br>
                                                <span>Number of tickets during end of the shift:&nbsp;&nbsp;{!!$end_no_tickets!!}</span><br>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td height="20"  colspan="2" style="padding: 0 43px 0 43px; font-size: 12px; color: #00354f; padding-top: 20px;"> 
                                            Issues encountered: <br>
                                                <?php
                                                $string = $summary;
                                                    $token = strtok($string, "-");

                                                    while ($token !== false)
                                                        {
                                                        echo "- $token<br>";
                                                        $token = strtok("-");
                                                        } 
                                                ?>
                                                <br>
                                        </td>
                                    </tr>

                            <!-- Added columns-->
                                    <tr>
                                        <td height="20"  colspan="2" style="padding: 0 43px 0 43px; font-size: 12px; color: #00354f; padding-top: 20px;"> 
                                            Challenges during the shift: <br>
                                                <?php
                                                $string = $challenges;
                                                    $token = strtok($string, "-");

                                                    while ($token !== false)
                                                        {
                                                        echo "- $token<br>";
                                                        $token = strtok("-");
                                                        } 
                                                ?>
                                                <br>    
                                        </td>
                                    </tr>

                                    <tr>
                                        <td height="20"  colspan="2" style="padding: 0 43px 0 43px; font-size: 12px; color: #00354f; padding-top: 20px;"> 
                                            Financial Impact: <br>
                                                <?php
                                                $string = $fin_impact;
                                                    $token = strtok($string, "-");

                                                    while ($token !== false)
                                                        {
                                                        echo "- $token<br>";
                                                        $token = strtok("-");
                                                        } 
                                                ?>
                                                <br>
                                        </td>
                                    </tr>
                            
                                    <tr>
                                        <td height="20"  colspan="2" style="padding: 0 43px 0 43px; font-size: 12px; color: #00354f; padding-top: 20px;"> 
                                            Shift Highlight: <br>
                                            <?php
                                                $string = $shift_highlight;
                                                    $token = strtok($string, "-");

                                                    while ($token !== false)
                                                        {
                                                        echo "- $token<br>";
                                                        $token = strtok("-");
                                                        } 
                                                ?>
                                                <br>
                                        </td>
                                    </tr>
                            
                                     <tr>
                                        <td height="20"  colspan="2" style="padding: 0 43px 0 43px; font-size: 12px; color: #00354f; padding-top: 20px;"> 
                                            Shift Lowlight: <br>
                                            <?php
                                                $string = $shift_lowlight;
                                                    $token = strtok($string, "-");

                                                    while ($token !== false)
                                                        {
                                                        echo "- $token<br>";
                                                        $token = strtok("-");
                                                        } 
                                                ?>
                                                <br>
                                        </td>
                                    </tr>
                          
                            <!-- end Added columns-->
                            
                            
                                    <tr>
                                        <td height="60" colspan="2" style="padding: 0 43px 0 43px; font-size: 12px; color: #00354f;">
                                            Regards,<br>
                                                {{ $user }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" bgcolor="#222" border="0" cellspacing="0" cellpadding="0" align="center" class="full" style="color: #fff; -moz-border-radius: 0px 0px 4px 4px; -webkit-border-radius: 0px 0px 4px 4px; border-radius: 0px 0px 4px 4px; font-family: Helvetica,sans-serif; font-size: 12px;">
                                                <tr>
                                                    <td height="15">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td align="center">Copyright <i class="fa fa-copyright"></i> 2016 <a href="" style="color: #fff; text-decoration: none;">1&1 Internet Philippines, Inc</a> - IT Services Cebu</td>
                                                </tr>
                                                <tr>
                                                    <td height="15"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>