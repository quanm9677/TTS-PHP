<?php
   namespace XYZBank\Accounts;

   /**
    * Class BankAccount
    * Lớp trừu tượng đại diện cho tài khoản ngân hàng.
    */
   abstract class BankAccount {
       /**
        * @var string Mã số tài khoản
        */
       protected string $accountNumber;

       /**
        * @var string Tên chủ tài khoản
        */
       protected string $ownerName;

       /**
        * @var float Số dư tài khoản
        */
       protected float $balance;

       /**
        * BankAccount constructor.
        *
        * @param string $accountNumber Mã số tài khoản
        * @param string $ownerName Tên chủ tài khoản
        * @param float $initialBalance Số dư ban đầu
        */
       public function __construct(string $accountNumber, string $ownerName, float $initialBalance) {
           $this->accountNumber = $accountNumber;
           $this->ownerName = $ownerName;
           $this->balance = $initialBalance;
           \XYZBank\Bank::incrementAccountCount(); // Tăng tổng số tài khoản
       }

       /**
        * Lấy số dư tài khoản.
        *
        * @return float Số dư tài khoản
        */
       public function getBalance(): float {
           return $this->balance;
       }

       /**
        * Lấy tên chủ tài khoản.
        *
        * @return string Tên chủ tài khoản
        */
       public function getOwnerName(): string {
           return $this->ownerName;
       }

       /**
        * Lấy mã số tài khoản.
        *
        * @return string Mã số tài khoản
        */
       public function getAccountNumber(): string {
           return $this->accountNumber; // Giả sử $accountNumber là thuộc tính của lớp
       }

       /**
        * Gửi tiền vào tài khoản.
        *
        * @param float $amount Số tiền cần gửi
        */
       abstract public function deposit(float $amount): void;

       /**
        * Rút tiền từ tài khoản.
        *
        * @param float $amount Số tiền cần rút
        */
       abstract public function withdraw(float $amount): void;

       /**
        * Lấy loại tài khoản.
        *
        * @return string Loại tài khoản
        */
       abstract public function getAccountType(): string;
   }