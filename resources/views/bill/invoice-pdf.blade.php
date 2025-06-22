<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบแจ้งชำระเงิน</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details table, th, td {
            border: 1px solid #000;
        }
        .invoice-details th, td {
            padding: 8px;
            text-align: left;
        }
        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h1>ใบแจ้งชำระเงิน</h1>
            <p>บริษัทตัวอย่าง จำกัด</p>
            <p>ที่อยู่: 123 ถนนหลัก, กรุงเทพฯ, 10100</p>
            <p>เบอร์โทร: 02-123-4567</p>
        </div>

        <!-- Invoice Details Section -->
        <div class="invoice-details">
            <table>
                <tr>
                    <th>หมายเลขใบแจ้งหนี้</th>
                    <td>INV-12345</td>
                </tr>
                <tr>
                    <th>วันที่ออกใบแจ้งหนี้</th>
                    <td>14 มีนาคม 2025</td>
                </tr>
                <tr>
                    <th>วันครบกำหนดชำระ</th>
                    <td>21 มีนาคม 2025</td>
                </tr>
                <tr>
                    <th>ชื่อผู้รับ</th>
                    <td>นายสมชาย ตัวอย่าง</td>
                </tr>
                <tr>
                    <th>ที่อยู่ผู้รับ</th>
                    <td>123/45 ซอยตัวอย่าง, กรุงเทพฯ, 10100</td>
                </tr>
            </table>
        </div>

        <!-- Itemized List Section -->
        <div class="invoice-details">
            <table>
                <thead>
                    <tr>
                        <th>รายการ</th>
                        <th>จำนวน</th>
                        <th>ราคา/หน่วย (บาท)</th>
                        <th>รวม (บาท)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>สินค้า A</td>
                        <td>2</td>
                        <td>500</td>
                        <td>1,000</td>
                    </tr>
                    <tr>
                        <td>สินค้า B</td>
                        <td>3</td>
                        <td>200</td>
                        <td>600</td>
                    </tr>
                    <tr>
                        <td>สินค้า C</td>
                        <td>1</td>
                        <td>1,000</td>
                        <td>1,000</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;">รวมทั้งหมด</td>
                        <td>2,600</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Total Section -->
        <div class="total">
            <p>ยอดรวมทั้งสิ้น: 2,600 บาท</p>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <p>ขอบคุณที่ใช้บริการของเรา!</p>
        </div>
    </div>

</body>
</html>
