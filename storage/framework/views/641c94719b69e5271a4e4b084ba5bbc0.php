<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice - <?php echo e($order->order_number ?? '#' . $order->id); ?></title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            border-bottom: 2px solid #e62e04;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header .title {
            font-size: 24px;
            font-weight: 700;
            color: #e62e04;
        }
        .header .order-info {
            font-size: 13px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background: #f5f5f5;
            font-weight: 600;
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }
        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }
        table td.right {
            text-align: right;
        }
        .totals td {
            border-bottom: none;
            padding: 4px 10px;
        }
        .totals tr:last-child td {
            border-top: 2px solid #333;
            font-weight: 700;
            font-size: 14px;
        }
        .address-section {
            margin-bottom: 20px;
        }
        .address-section .label {
            font-weight: 600;
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .address-section .value {
            font-size: 12px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <table style="margin-bottom:0;">
            <tr>
                <td style="width:50%;border:none;">
                    <div class="title">INVOICE</div>
                    <div class="order-info">Order #<?php echo e($order->order_number ?? $order->id); ?></div>
                    <div class="order-info">Date: <?php echo e(optional($order->created_at)->format('d M Y')); ?></div>
                </td>
                <td style="width:50%;text-align:right;border:none;">
                    <img src="<?php echo e(public_path('assets/images/BwSkuSZ7ZYGWPc4Zk3CfeFzcn49dHpx3143n4WKS.png')); ?>" alt="Logo" style="max-height:50px;">
                </td>
            </tr>
        </table>
    </div>

    <?php
        $shipping = is_array($order->shipping_details)
            ? $order->shipping_details
            : json_decode($order->shipping_details, true);
        $shippingFee = $order->shipping_fee ?? 0;
        $taxAmount = $order->tax ?? 0;
        $totalAmount = $order->total_amount ?? 0;
        $subTotal = $totalAmount - $shippingFee - $taxAmount;
    ?>

    <div class="address-section">
        <table style="margin-bottom:0;">
            <tr>
                <td style="width:50%;border:none;">
                    <div class="label">Bill To</div>
                    <div class="value">
                        <?php echo e($shipping['name'] ?? $order->user->name ?? 'N/A'); ?><br>
                        <?php echo e($shipping['email'] ?? $order->user->email ?? ''); ?><br>
                        <?php echo e($shipping['phone'] ?? ''); ?><br>
                        <?php echo e($shipping['address'] ?? ''); ?><br>
                        <?php echo e($shipping['city'] ?? ''); ?>, <?php echo e($shipping['state'] ?? ''); ?> <?php echo e($shipping['zip_code'] ?? ''); ?><br>
                        <?php echo e($shipping['country'] ?? ''); ?>

                    </div>
                </td>
                <td style="width:50%;border:none;">
                    <div class="label">Payment Method</div>
                    <div class="value"><?php echo e($order->payment_method ? ucfirst(str_replace('_', ' ', $order->payment_method)) : 'N/A'); ?></div>
                    <br>
                    <div class="label">Delivery Type</div>
                    <div class="value"><?php echo e($order->delivery_type ?? 'Home Delivery'); ?></div>
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:5%;">#</th>
                <th style="width:45%;">Product</th>
                <th style="width:15%;">Qty</th>
                <th style="width:15%;" class="right">Price</th>
                <th style="width:20%;" class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key + 1); ?></td>
                <td><?php echo e($item->product->name ?? 'Product Unavailable'); ?></td>
                <td><?php echo e($item->quantity ?? $item->qty ?? 1); ?></td>
                <td class="right"><?php echo e(currency_format($item->price ?? 0)); ?></td>
                <td class="right"><?php echo e(number_format(($item->price ?? 0) * ($item->quantity ?? $item->qty ?? 1), 2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <table class="totals" style="width:40%;margin-left:auto;">
        <tr>
            <td style="width:50%;">Subtotal</td>
            <td class="right"><?php echo e(number_format($subTotal, 2)); ?></td>
        </tr>
        <tr>
            <td>Shipping</td>
            <td class="right"><?php echo e(number_format($shippingFee, 2)); ?></td>
        </tr>
        <tr>
            <td>Tax</td>
            <td class="right"><?php echo e(number_format($taxAmount, 2)); ?></td>
        </tr>
        <?php if(($order->coupon_discount ?? 0) > 0): ?>
        <tr>
            <td>Coupon Discount</td>
            <td class="right">-<?php echo e(number_format($order->coupon_discount, 2)); ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td>Total</td>
            <td class="right"><?php echo e(number_format($totalAmount, 2)); ?></td>
        </tr>
    </table>

    <div class="footer">
        Thank you for your business!
    </div>

</body>
</html>
<?php /**PATH /var/www/html/stautoparts/resources/views/user/orders/invoice.blade.php ENDPATH**/ ?>