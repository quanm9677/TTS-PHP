<?php

namespace XYZBank\Accounts;

/**
 * Class CheckingAccount
 * Đại diện cho tài khoản thanh toán, kế thừa từ BankAccount.
 */
class CheckingAccount extends BankAccount
{
    use TransactionLogger;

    /**
     * Gửi tiền vào tài khoản thanh toán.
     *
     * @param float $amount Số tiền cần gửi
     */
    public function deposit(float $amount): void
    {
        $this->balance += $amount;
        $this->logTransaction('Gửi tiền', $amount, $this->balance);
    }

    /**
     * Rút tiền từ tài khoản thanh toán.
     *
     * @param float $amount Số tiền cần rút
     */
    public function withdraw(float $amount): void
    {
        $this->balance -= $amount;
        $this->logTransaction('Rút tiền', $amount, $this->balance);
    }

    /**
     * Lấy loại tài khoản.
     *
     * @return string Loại tài khoản
     */
    public function getAccountType(): string
    {
        return 'Thanh toán';
    }

    /**
     * Lấy mã số tài khoản.
     *
     * @return string Mã số tài khoản
     */
    public function getAccountNumber(): string
    {
        return $this->accountNumber; // Giả sử $accountNumber là thuộc tính của lớp
    }
}
