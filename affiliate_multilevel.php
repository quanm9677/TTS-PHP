<?php
$users = [
    1 => ['name' => 'Alice', 'referrer_id' => null],
    2 => ['name' => 'Bob', 'referrer_id' => 1],
    3 => ['name' => 'Charlie', 'referrer_id' => 2],
    4 => ['name' => 'David', 'referrer_id' => 3],
    5 => ['name' => 'Eva', 'referrer_id' => 1],
];

$orders = [
    ['order_id' => 101, 'user_id' => 4, 'amount' => 200.0],
    ['order_id' => 102, 'user_id' => 3, 'amount' => 150.0],
    ['order_id' => 103, 'user_id' => 5, 'amount' => 300.0],
];

$commissionRates = [
    1 => 0.10,
    2 => 0.05,
    3 => 0.02,
];

function getReferrerChain(int $userId, array $users, int $maxLevel = 3, int $currentLevel = 1): array
{
    if ($currentLevel > $maxLevel || empty($users[$userId]['referrer_id'])) {
        return [];
    }
    $referrerId = $users[$userId]['referrer_id'];
    return [$currentLevel => $referrerId] + getReferrerChain($referrerId, $users, $maxLevel, $currentLevel + 1);
}

function calculateOrderCommission(array $order, array $users, array $commissionRates): array
{
    $result = [];
    $refChain = getReferrerChain($order['user_id'], $users, count($commissionRates));
    foreach ($refChain as $level => $referrerId) {
        if ($referrerId && isset($commissionRates[$level])) {
            $result[] = [
                'receiver_id' => $referrerId,
                'level' => $level,
                'order_id' => $order['order_id'],
                'buyer_id' => $order['user_id'],
                'commission' => $order['amount'] * $commissionRates[$level],
            ];
        }
    }
    return $result;
}

function calculateCommission(array $orders, array $users, array $commissionRates): array
{
    $allCommissions = [];
    foreach ($orders as $order) {
        $orderCommissions = calculateOrderCommission($order, $users, $commissionRates);
        foreach ($orderCommissions as $c) {
            $allCommissions[] = $c;
        }
    }
    return $allCommissions;
}

function summarizeCommission(array $commissions): array
{
    $summary = [];
    foreach ($commissions as $c) {
        if (!isset($summary[$c['receiver_id']])) {
            $summary[$c['receiver_id']] = 0;
        }
        $summary[$c['receiver_id']] += $c['commission'];
    }
    return $summary;
}

function logMessage(string $msg): void
{
    static $count = 0;
    global $logArr;
    $count++;
    $logArr[] = "[$count] $msg";
}
$logArr = [];

function sumCommissions(float ...$commissions): float
{
    return array_sum($commissions);
}

$commissions = calculateCommission($orders, $users, $commissionRates);
$summary = summarizeCommission($commissions);
$level1 = array_filter($commissions, fn($c) => $c['level'] === 1);
$level1Amounts = array_map(fn($c) => $c['commission'], $level1);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h1>Báo cáo hoa hồng Affiliate đa cấp</h1>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: #f6f8fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 32px 28px 28px 28px;
        }

        h1,
        h2,
        h3,
        b {
            color: #2d3a4a;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        th,
        td {
            border: 1px solid #e0e6ed;
            padding: 10px 8px;
            text-align: center;
        }

        th {
            background: #f0f4f8;
            font-weight: 700;
        }

        tr:nth-child(even) {
            background: #f9fbfc;
        }

        tr:hover {
            background: #e6f7ff;
        }

        .section {
            margin-bottom: 32px;
        }

        .log {
            background: #f7f7f7;
            border-left: 4px solid #4caf50;
            padding: 12px 18px;
            margin: 12px 0 0 0;
            font-size: 15px;
        }

        .summary-box {
            background: #e3f2fd;
            border-radius: 6px;
            padding: 12px 18px;
            margin-bottom: 18px;
            font-size: 16px;
            color: #1565c0;
        }
    </style>
</head>

<body>
    <div class="container">
        <title>Báo cáo hoa hồng Affiliate đa cấp</title>
        <section class="section">
            <h2>BÁO CÁO HOA HỒNG TỔNG HỢP</h2>
            <table>
                <tr>
                    <th>STT</th>
                    <th>Tên người nhận hoa hồng</th>
                    <th>Tổng hoa hồng (USD)</th>
                </tr>
                <?php
                $stt = 1;
                foreach ($summary as $userId => $total) {
                    echo "<tr><td>$stt</td><td>" . $users[$userId]['name'] . "</td><td>" . number_format($total, 2) . "</td></tr>";
                    logMessage("Tổng hoa hồng của {$users[$userId]['name']} là $total USD");
                    $stt++;
                }
                ?>
            </table>
        </section>
        <section class="section">
            <h2>CHI TIẾT HOA HỒNG</h2>
            <table>
                <tr>
                    <th>STT</th>
                    <th>Người nhận được hoa hồng</th>
                    <th>Cấp</th>
                    <th>Đơn hàng</th>
                    <th>Người mua</th>
                    
                    <th>Số tiền nhận được (USD)</th>
                </tr>
                <?php
                $stt = 1;
                array_walk($commissions, function ($c) use ($users, &$stt) {
                    echo "<tr><td>$stt</td><td>{$users[$c['receiver_id']]['name']}</td><td>{$c['level']}</td><td>{$c['order_id']}</td><td>{$users[$c['buyer_id']]['name']}</td><td>" . number_format($c['commission'], 2) . "</td></tr>";
                    $stt++;
                });
                ?>
            </table>
        </section>
        <section class="section">
            <div class="summary-box">
                <b>Hoa hồng cấp 1:</b> <?php echo count($level1); ?> tài khoản<br>
                Tổng hoa hồng cấp 1: <?php echo number_format(sumCommissions(...$level1Amounts), 2); ?> USD
            </div>
        </section>
        <?php if (!empty($logArr)) { ?>
            <section class="section">
                <h2>LOG</h2>
                <div class="log">
                    <?php foreach ($logArr as $log) echo $log . "<br>"; ?>
                </div>
            </section>
        <?php } ?>
    </div>
</body>

</html>