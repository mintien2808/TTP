<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px;">
        <h1 style="text-align: center; color: #333;">Cảm ơn bạn đã đặt hàng tại <span style="color: #007BFF;">TTP Shop</span>!</h1>
        <p style="text-align: center; font-size: 16px; color: #555;">Dưới đây là thông tin chi tiết về đơn hàng của bạn:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; background: #f7f7f7; border-radius: 8px;">
            <tr style="background-color: #007BFF; color: #ffffff; text-align: left;">
                <th style="padding: 10px;">Thông tin</th>
                <th style="padding: 10px;">Chi tiết</th>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">Mã đơn hàng</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">
                    <a href="{{ $forAdmin ? env('BACKEND_URL').'/app/orders/'.$order->id : route('order.view', $order, true) }}" style="color: #007BFF; text-decoration: none;">
                        {{ $order->id }}
                    </a>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">Trạng thái đơn hàng</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $order->status }}</td>
            </tr>

            <tr>
                <td style="padding: 10px;">Ngày đặt hàng</td>
                <td style="padding: 10px;">{{ now() }}</td>
            </tr>
        </table>

        <h2 style="color: #333; text-align: center;">Chi tiết sản phẩm</h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background-color: #007BFF; color: #ffffff; text-align: left;">
                    <th style="padding: 10px;">Hình ảnh</th>
                    <th style="padding: 10px;">Tên sản phẩm</th>
                    <th style="padding: 10px;">Đơn giá</th>
                    <th style="padding: 10px;">Số lượng</th>
                    <th style="padding: 10px;">Tổng giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px; text-align: center;">
                        <img src="{{ $item->product->image }}" alt="{{ $item->product->title }}" style="width: 80px; border-radius: 4px;">
                    </td>
                    <td style="padding: 10px;">{{ $item->product->title }}</td>
                    <td style="padding: 10px;">${{ number_format($item->unit_price, 2) }}</td>
                    <td style="padding: 10px; text-align: center;">{{ $item->quantity }}</td>
                    <td style="padding: 10px;">${{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p style="text-align: center; margin-top: 20px; color: #555;">Cảm ơn bạn đã lựa chọn <strong>TTP Shop</strong>. Hẹn gặp lại!</p>
    </div>
</body>
</html>
