<?php

namespace XYZBank\Accounts;

/**
 * Class SavingsAccount
 * Đại diện cho tài khoản tiết kiệm, kế thừa từ BankAccount và implement InterestBearing.
 */
class SavingsAccount extends BankAccount implements InterestBearing
{
    use TransactionLogger;

    const INTEREST_RATE = 0.05; // Lãi suất 5%/năm

    /**
     * Gửi tiền vào tài khoản tiết kiệm.
     *
     * @param float $amount Số tiền cần gửi
     */
    public function deposit(float $amount): void
    {
        $this->balance += $amount;
        $this->logTransaction('Gửi', $amount, $this->balance);
    }

    /**
     * Rút tiền từ tài khoản tiết kiệm.
     *
     * @param float $amount Số tiền cần rút
     * @throws \Exception Nếu số dư không đủ
     */
    public function withdraw(float $amount): void
    {
        if ($this->balance - $amount < 1000000) {
            throw new \Exception("Số dư không đủ để rút tiền.");
        }
        $this->balance -= $amount;
        $this->logTransaction('Rút', $amount, $this->balance);
    }

    /**
     * Lấy loại tài khoản.
     *
     * @return string Loại tài khoản
     */
    public function getAccountType(): string
    {
        return 'Tiết kiệm';
    }

    /**
     * Tính lãi suất hàng năm.
     *
     * @return float Lãi suất hàng năm
     */
    public function calculateAnnualInterest(): float
    {
        return $this->balance * self::INTEREST_RATE;
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
