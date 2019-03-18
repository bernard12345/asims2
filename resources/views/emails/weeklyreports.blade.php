<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

  
    <style>
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }

        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],  /* iOS */
        .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }
        /* If the above doesn't work, add a .g-img class to any image in question. */
        img.g-img + div {
            display: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            .email-container {
                min-width: 320px !important;
            }
        }
        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            .email-container {
                min-width: 375px !important;
            }
        }
        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            .email-container {
                min-width: 414px !important;
            }
        }

table.redTable {
  border: 2px solid #0B6FA4;
  background-color: #FFFFFF;
  width: 100%;
  text-align: center;
  border-collapse: collapse;
}
table.redTable td, table.redTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.redTable tbody td {
  font-size: 17px;
}
table.redTable tr:nth-child(even) {
  background: #12B9FF;
}
table.redTable thead {
  background: #0B6FA4;
}
table.redTable thead th {
  font-size: 19px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
  border-left: 2px solid #0B6FA4;
}
table.redTable thead th:first-child {
  border-left: none;
}

table.redTable tfoot {
  font-size: 13px;
  font-weight: bold;
  color: #FFFFFF;
  background: #0B6FA4;
}
table.redTable tfoot td {
  font-size: 13px;
}
table.redTable tfoot .links {
  text-align: right;
}
table.redTable tfoot .links a{
  display: inline-block;
  background: #FFFFFF;
  color: #0B6FA4;
  padding: 2px 8px;
  border-radius: 5px;
}
    </style>
    
    <style>

	    /* What it does: Hover styles for buttons */
	    .button-td,
	    .button-a {
	        transition: all 100ms ease-in;
	    }
	    .button-td-primary:hover,
	    .button-a-primary:hover {
	        background: #555555 !important;
	        border-color: #555555 !important;
	    }

	    /* Media Queries */
	    @media screen and (max-width: 600px) {

	        /* What it does: Adjust typography on small screens to improve readability */
	        .email-container p {
	            font-size: 17px !important;
	        }

	    }

    </style>
    

</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
	<center style="width: 100%; background-color:DodgerBlue;">
   
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            (Good day !,Please be inform {{$student['student_firstname']}} {{$student['student_lastname']}}  
        </div>
        
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
	        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div>
        
        <div style="max-width: 700px; margin: 0 auto;" class="email-container">
           
	        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0 auto;">
		       
	         <br><br>
                <tr>
                    <td style="background-color: #ffffff;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                                    <h1 style="margin: 0 0 10px 0; font-family: sans-serif; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal; font-weight: bold;" align = "center">Android Student Monitoring and Identification System</h1>
                                    <h4 style="margin: 0 0 10px 0; font-family: sans-serif; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal; font-weight: bold;" align = "center">Weekly Report</h>

                                    
                                </td>
                            </tr>
		                       
                            <tr>
                                <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                                    <h2 style="margin: 0 0 10px 0; font-family: sans-serif; font-size: 18px; line-height: 22px; color: #333333; font-weight: bold;">.</h2>
                                    <ul style="padding: 0; margin: 0 0 10px 0; list-style-type: disc;">
                                        <li style="margin:0 0 10px 30px;" class="list-item-first">
                                            <b>Name:</b> {{$student->student_firstname}}  {{$student->student_lastname}}</li>
										<li style="margin:0 0 10px 30px;" class="list-item-first"><b>Schedule Time:</b> {{$sched['schedule_start_24']}} - {{$sched['schedule_end_24']}}</li>
										<li style="margin:0 0 10px 30px;"><b>Subject:</b> {{$sched->subjects['subject_title']}}</li>
										<li style="margin:0 0 10px 30px;"><b>Schedule Day:</b> {{$sched['schedule_day']}}</li>
										<li style="margin:0 0 10px 30px;"><b>Please talk to Your Professor</b></li>

									</ul>




<h2 align = "center">Attendance Report</h2>
<div>
<h4>{{$sched->subjects['subject_title']}}</h4>
<h4>{{$sched->sections['section_name']}}</h4>
</div>


<table class="redTable" >
          <thead>
          <tr>
            <th>Date</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
    <?php $monday = Carbon\Carbon::now()->startOfWeek();
          $sunday = Carbon\Carbon::now()->endOfWeek(); ?>
          @foreach($student->attendances as $att)
        
     @if($att->schedule_id == $sched->id)
              <tr> 
                    <td>{{$att['a_date']}}</td>
                    <td>{{$att['a_timestamp']}}</td>
                    <td>{{$att['time']}}</td>
                    <td>{{$att['status']}}</td>
                </tr>
                @endif
            @endforeach
          </tbody>
          <tfoot>
          <tr>
            <th>Date</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Status</th>
          </tr>
          </tfoot>
</table>


                                    <p style="margin: 0;">Please always check email for more information.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td aria-hidden="true" height="40" style="font-size: 0px; line-height: 0px;">
                        &nbsp;
                    </td>
                </tr>
                <!-- Clear Spacer : END -->

              <br><br>

            </table>
  
        </div>

    </center>
</body>
</html>