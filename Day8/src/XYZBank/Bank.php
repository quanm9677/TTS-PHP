<?php
namespace XYZBank;

/**
 * Class Bank
 * Lớp quản lý thông tin và chức năng toàn cục của ngân hàng.
 */
class Bank
{
    /**
     * @var int Tổng số tài khoản đã được tạo
     */
    private static int $totalAccounts = 0;

    /**
     * Tăng tổng số tài khoản.
     */
    public static function incrementAccountCount(): void
    {
        self::$totalAccounts++;
    }

    /**
     * Lấy tổng số tài khoản đã tạo.
     *
     * @return int Tổng số tài khoản
     */
    public static function getTotalAccounts(): int
    {
        return self::$totalAccounts;
    }

    /**
     * Lấy tên ngân hàng.
     *
     * @return string Tên ngân hàng
     */
    public static function getBankName(): string
    {
        return 'Ngân hàng XYZ';
    }
}
