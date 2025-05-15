<?php
namespace XYZBank\Accounts;

use IteratorAggregate;
use ArrayIterator;

/**
 * Class AccountCollection
 * Quản lý danh sách các tài khoản ngân hàng.
 */
class AccountCollection implements IteratorAggregate
{
    /**
     * @var array Danh sách các tài khoản
     */
    private array $accounts = [];

    /**
     * Thêm tài khoản mới vào danh sách.
     *
     * @param BankAccount $account Tài khoản ngân hàng
     */
    public function addAccount(BankAccount $account): void
    {
        $this->accounts[] = $account;
    }

    /**
     * Lấy iterator để duyệt qua danh sách tài khoản.
     *
     * @return \Traversable
     */
    public function getIterator(): \Traversable
    {
        return new ArrayIterator($this->accounts);
    }

    /**
     * Lọc các tài khoản có số dư ≥ 10.000.000 VNĐ.
     *
     * @return array Danh sách tài khoản có số dư cao
     */
    public function filterHighBalanceAccounts(): array
    {
        return array_filter($this->accounts, fn($acc) => $acc->getBalance() >= 10000000);
    }
}
