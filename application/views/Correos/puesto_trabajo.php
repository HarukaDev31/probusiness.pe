<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=gb18030">
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>laesystems</title>

        <style>
            a.btn-recuperar:link, a.btn-recuperar:visited {
                background-color: #00b8d4;
                color: white;
                padding: 14px 25px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                border-radius: 8px;
            }
            
            a.btn-recuperar:hover, a.btn-recuperar:active {
                background-color: #08c7e5;
            }
            
            .list-unstyled {
                padding-left: 0;
                list-style: none;
            }
            
            .list-inline li {
                display: inline-block;
                padding-right: 5px;
                padding-left: 5px;
                margin-bottom: 5px;
            }
            
            /*---- Genral classes end -------*/
            
            /*Change icons size here*/
            .social-icons .fa {
                font-size: 1.8em;
            }
            /*Change icons circle size and color here*/
            .social-icons .fa {
                border-radius: 8px;
                width: 50px;
                height: 50px;
                line-height: 50px;
                text-align: center;
                color: #FFF;
                color: rgba(255, 255, 255, 0.8);
                -webkit-transition: all 0.3s ease-in-out;
                -moz-transition: all 0.3s ease-in-out;
                -ms-transition: all 0.3s ease-in-out;
                -o-transition: all 0.3s ease-in-out;
                transition: all 0.3s ease-in-out;
            }
            
            .social-icons.icon-circle .fa{ 
                border-radius: 50%;
            }
            .social-icons.icon-rounded .fa{
                border-radius:5px;
            }
            .social-icons.icon-flat .fa{
                border-radius: 0;
            }
            
            .social-icons .fa:hover, .social-icons .fa:active {
                color: #FFF;
                -webkit-box-shadow: 1px 1px 3px #333;
                -moz-box-shadow: 1px 1px 3px #333;
                box-shadow: 1px 1px 3px #333; 
            }
            .social-icons.icon-zoom .fa:hover, .social-icons.icon-zoom .fa:active { 
                -webkit-transform: scale(1.1);
                -moz-transform: scale(1.1);
                -ms-transform: scale(1.1);
                -o-transform: scale(1.1);
                transform: scale(1.1); 
            }
            .social-icons.icon-rotate .fa:hover, .social-icons.icon-rotate .fa:active { 
                -webkit-transform: scale(1.1) rotate(360deg);
                -moz-transform: scale(1.1) rotate(360deg);
                -ms-transform: scale(1.1) rotate(360deg);
                -o-transform: scale(1.1) rotate(360deg);
                transform: scale(1.1) rotate(360deg);
            }
            
            .social-icons .fa-facebook,.social-icons .fa-facebook-square{background-color:#3C599F;} 
            .social-icons .fa-instagram{background-color:#A1755C;}
        </style>
    </head>
    <body style="margin: 0; padding: 0; font-family: Arial">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>
                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFF" style="order-bottom-left-radius: 3px; order-bottom-right-radius: 3px; border-color: transparent; border-image: none; border-style: none transparent solid; border-width: 0 1px 1px; max-width: 600px; min-width: 332px;">
                        <tr>
                            <td align="left" bgcolor="#fff" style="padding: 0px 0 0px 0;">
                                Nombres y Apellidos: <?php echo $name; ?><br>
                                Celular: <?php echo $celular; ?><br>
                                Email: <?php echo $email; ?><br>
                                Mensaje: <?php echo nl2br($message); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>