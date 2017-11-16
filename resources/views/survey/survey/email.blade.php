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
        <table align="center" class="full" cellspacing="0" height="300" cellpadding="0" style="font-family: Helvetica,sans-serif; background-color: #fcfcfd; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius:5px; margin-top: 10px;">
            <tr>
                <td align="center">
                    <table width="480" border="0" cellspacing="0" cellpadding="0" align="center" class="devicewidth" style="border: 1px solid #e0e5e9; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius:5px 5px 0 0;">
                        <tr>
                            <td>
                                <table width="100%" cellspacing="0" cellpadding="0" align="center" class="full" style="background-color: #fcfcfd;">
                                    <tr>
                                        <td height="5">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    @if($name)
                                    <tr>
                                        <td>
                                            <table border="0" cellspacing="0" cellpadding="0" align="left" class="inner" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin: 0 20px 0 20px; font-size: 12px; color: #00354f;">
                                                <tr>
                                                    <td width="23" class="hide">&nbsp;</td>
                                                    <td height="55" class="inner" valign="middle" style="font-weight: bold;">Hi {{ $name }}, </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td height="20"  colspan="2" style="padding: 0 43px 0 43px; font-size: 12px; color: #00354f;"> 
                                            You have been invited to answer a survey. Please click the link below to view.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"  align="center" height="75">
                                            <table cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="center" bgcolor="#007DC1" style=" padding: 12px 45px; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; display: block; margin: 25px 0px 25px">
                                                        <a href="{{ $url }}" style=" font-size: 13px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; width:100%;" target="_blank">
                                                            <span style="color: #fff">
                                                                {{ $survey_name }}
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <tr>
                                            <td height="60" colspan="2" style="padding: 0 43px 0 43px; font-size: 12px; color: #00354f;">
                                                Regards,<br>
                                                    <a href="{{ URL::to('/') }}" style="color: #0061A7; text-decoration: none;">MIS-EWS Online</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="29">
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