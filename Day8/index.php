<?php
require_once __DIR__ . '/src/XYZBank/Accounts/BankAccount.php';
require_once __DIR__ . '/src/XYZBank/Accounts/InterestBearing.php';
require_once __DIR__ . '/src/XYZBank/Accounts/TransactionLogger.php';
require_once __DIR__ . '/src/XYZBank/Accounts/SavingsAccount.php';
require_once __DIR__ . '/src/XYZBank/Accounts/CheckingAccount.php';
require_once __DIR__ . '/src/XYZBank/Accounts/AccountCollection.php';
require_once __DIR__ . '/src/XYZBank/Bank.php';

use XYZBank\Accounts\SavingsAccount;
use XYZBank\Accounts\CheckingAccount;
use XYZBank\Accounts\AccountCollection;
use XYZBank\Bank;

// Tạo danh sách tài khoản
$collection = new AccountCollection();

// Tài khoản tiết kiệm
$savingAcc = new SavingsAccount("10201122", "Nguyễn Thị A", 20000000);
$collection->addAccount($savingAcc);

// Tài khoản thanh toán
$checking1 = new CheckingAccount("20301123", "Lê Văn B", 8000000);
$checking1->deposit(5000000); // Gửi thêm 5tr
$collection->addAccount($checking1);

$checking2 = new CheckingAccount("20401124", "Trần Minh C", 12000000);
$checking2->withdraw(2000000); // Rút 2tr
$collection->addAccount($checking2);

// Tính lãi suất cho tài khoản tiết kiệm
$annualInterest = $savingAcc->calculateAnnualInterest();

// Bắt đầu phần giao diện HTML
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản ngân hàng</title>
    <link rel="stylesheet" href="styles.css"> <!-- Liên kết đến tệp CSS -->
</head>

<body>
    <div class="container">
        <h1>Quản lý tài khoản ngân hàng</h1>
        <h2>Lãi suất hàng năm cho Nguyễn Thị A: <?= number_format($annualInterest, 0, ',', '.') ?> VNĐ</h2>

        <h3>Danh sách tài khoản</h3>
        <table>
            <thead>
                <tr>
                    <th>Tài khoản</th>
                    <th>Chủ tài khoản</th>
                    <th>Loại</th>
                    <th>Số dư</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($collection as $account): ?>
                    <tr>
                        <td><?= $account->getAccountNumber() ?></td>
                        <td><?= $account->getOwnerName() ?></td>
                        <td><?= $account->getAccountType() ?></td>
                        <td><?= number_format($account->getBalance(), 0, ',', '.') ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Tổng số tài khoản đã tạo: <?= \XYZBank\Bank::getTotalAccounts() ?></h3>
        <h3>Tên ngân hàng: <?= \XYZBank\Bank::getBankName() ?></h3>
    </div>
</body>

</html>