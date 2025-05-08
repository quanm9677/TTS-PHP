<?php

$employees = [
    ['id' => 101, 'name' => 'Nguyễn Văn A', 'base_salary' => 8850000],
    ['id' => 102, 'name' => 'Trần Thị B', 'base_salary' => 6000000],
    ['id' => 103, 'name' => 'Lê Văn C', 'base_salary' => 6310000],
];

$timesheet = [
    101 => ['2025-03-01', '2025-03-02', '2025-03-04', '2025-03-05'],
    102 => ['2025-03-01', '2025-03-03', '2025-03-04'],
    103 => ['2025-03-02', '2025-03-03', '2025-03-04', '2025-03-05', '2025-03-06'],
];

$PayItems = [
    101 => ['allowance' => 500000, 'deduction' => 200000],
    102 => ['allowance' => 300000, 'deduction' => 100000],
    103 => ['allowance' => 400000, 'deduction' => 150000],
];

function cleanTimesheet($timesheet) {
    return array_map('array_unique', $timesheet);
}

function getWorkingDays($timesheet) {
    return array_map('count', $timesheet);
}

function calculateNetSalaries($employees, $workingDays, $PayItems) {
    return array_column(array_map(function($emp) use ($workingDays, $PayItems) {
        $id = $emp['id'];
        $base = $emp['base_salary'];
        $days = $workingDays[$id] ?? 0;
        $allow = $PayItems[$id]['allowance'] ?? 0;
        $deduct = $PayItems[$id]['deduction'] ?? 0;
        $dailyRate = $base / 22;
        $net = ($dailyRate * $days) + $allow - $deduct;
        $net = round($net);
        return ['id' => $id, 'net' => $net];
    }, $employees), 'net', 'id');
}

function generatePayrollTable($employees, $workingDays, $PayItems, $netSalaries) {
    $payroll = [];
    foreach ($employees as $emp) {
        $id = $emp['id'];
        $payroll[] = [
            'id' => $id,
            'name' => $emp['name'],
            'days' => $workingDays[$id] ?? 0,
            'base' => $emp['base_salary'],
            'allow' => $PayItems[$id]['allowance'] ?? 0,
            'deduct' => $PayItems[$id]['deduction'] ?? 0,
            'net' => $netSalaries[$id] ?? 0,
        ];
    }
    return $payroll;
}

function findMaxMinWorkers($workingDays, $employees) {
    $sorted = $workingDays;
    asort($sorted);
    $minId = array_key_first($sorted);
    $maxId = array_key_last($sorted);

    $getName = function($id) use ($employees) {
        foreach ($employees as $e) {
            if ($e['id'] === $id) return $e['name'];
        }
        return null;
    };

    return [
        'max' => ['id' => $maxId, 'name' => $getName($maxId), 'days' => $workingDays[$maxId]],
        'min' => ['id' => $minId, 'name' => $getName($minId), 'days' => $workingDays[$minId]],
    ];
}

function filterEligibleWorkers($workingDays, $employees) {
    $filtered = array_filter($workingDays, fn($days) => $days >= 4);
    $result = [];
    foreach ($employees as $e) {
        if (isset($filtered[$e['id']])) {
            $result[] = ['name' => $e['name'], 'days' => $filtered[$e['id']]];
        }
    }
    return $result;
}

function checkWorkOnDate($timesheet, $empId, $date) {
    return in_array($date, $timesheet[$empId] ?? []);
}

function checkAdjustmentExists($PayItems, $empId) {
    return array_key_exists($empId, $PayItems);
}

function getTotalSalary($netSalaries) {
    return array_sum($netSalaries);
}

$timesheet = cleanTimesheet($timesheet);
$workingDays = getWorkingDays($timesheet);
$netSalaries = calculateNetSalaries($employees, $workingDays, $PayItems);
$payroll = generatePayrollTable($employees, $workingDays, $PayItems, $netSalaries);
$summary = findMaxMinWorkers($workingDays, $employees);
$eligible = filterEligibleWorkers($workingDays, $employees);
$totalSalary = getTotalSalary($netSalaries);
$check1 = checkWorkOnDate($timesheet, 102, '2025-03-03');
$check2 = checkAdjustmentExists($PayItems, 101);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng lương nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="mb-4">BẢNG LƯƠNG NHÂN VIÊN</h2>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
        <tr>
            <th>Mã NV</th>
            <th>Họ tên</th>
            <th>Ngày công</th>
            <th>Lương CB</th>
            <th>Phụ cấp</th>
            <th>Khấu trừ</th>
            <th>Lương lĩnh</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($payroll as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= $p['days'] ?></td>
                <td><?= number_format($p['base']) ?></td>
                <td><?= number_format($p['allow']) ?></td>
                <td><?= number_format($p['deduct']) ?></td>
                <td class="fw-bold text-success"><?= number_format($p['net'], 0) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-4">
        <h5>Tổng quỹ lương tháng 03/2025: <span class="text-primary"><?= number_format($totalSalary) ?> VND</span></h5>
        <p>Nhân viên làm <b>nhiều nhất</b>: <span class="text-success"><?= $summary['max']['name'] ?> (<?= $summary['max']['days'] ?> ngày công)</span></p>
        <p>Nhân viên làm <b>ít nhất</b>: <span class="text-danger"><?= $summary['min']['name'] ?> (<?= $summary['min']['days'] ?> ngày công)</span></p>
    </div>

    <div class="mt-4">
        <h5>Nhân viên đủ điều kiện xét thưởng (ngày công ≥ 4):</h5>
        <ul>
            <?php foreach ($eligible as $e): ?>
                <li><?= htmlspecialchars($e['name']) ?> (<?= $e['days'] ?> ngày công)</li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="mt-4">
        <h5>Kiểm tra logic:</h5>
        <ul>
            <li>Trần Thị B có đi làm ngày 2025-03-03: <b><?= $check1 ? 'Có' : 'Không' ?></b></li>
            <li>Thông tin phụ cấp của nhân viên 101 tồn tại: <b><?= $check2 ? 'Có' : 'Không' ?></b></li>
        </ul>
    </div>
</div>
</body>
</html>