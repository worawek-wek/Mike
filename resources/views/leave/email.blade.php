<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การแจ้งเตือนการอนุมัติการลา</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            margin: auto;
            max-width: 600px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #facc15;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .content h2 {
            color: #333333;
        }
        .content p {
            font-size: 16px;
            color: #666666;
        }
        .btn {
            display: inline-block;
            padding: 12px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #666666;
            border-radius: 0 0 5px 5px;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>รายการลางานใหม่!</h1>
        </div>
        <div class="content">

            <h2>{{ $leave->leave_name }}, {{ $user->name }}!</h2>

            <p>เลขที่เอกสาร &nbsp; <b>{{ $new_leave_number }}</b></p>

            <p>รายการ &nbsp; <b>{{ $leave->leave_name }}</b></p>
            <p>สาเหตุการลา &nbsp; <b>{{ $detail }}</b></p>

            <p> 
                วันที่ 
                &nbsp; 
                <b>
                {{ $from_date }}
                @if($from_date != $to_date)
                    -
                {{ $to_date }}
                @endif
                </b>
            </p>
            @if(@$from_time)
                <p> 
                    วันที่ 
                    &nbsp;
                    <b>
                        {{ date('H:i', strtotime($from_time)) }}
                    -
                        {{ date('H:i', strtotime($to_time)) }} น.
                    </b>
                </p>
            @endif
            
            <a href="{{url('check-employee-leave-page')}}" class="btn" style="color: white;">ปรับสถานะการลา</a>
        </div>
        
    </div>

</body>
</html>