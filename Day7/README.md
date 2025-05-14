# Affiliate Management MVP

Mô-đun quản lý cộng tác viên (Affiliate Management) cho hệ thống tiếp thị liên kết, mô phỏng nghiệp vụ cơ bản bằng PHP hướng đối tượng, không sử dụng cơ sở dữ liệu.

## Cấu trúc thư mục
```
Day7
│
├── index.php                       # Điểm khởi đầu của chương trình, nơi chạy logic demo
│
├── classes/                        # Thư mục chứa các lớp (OOP)
│   ├── AffiliatePartner.php        # Lớp cơ bản CTV thường
│   ├── PremiumAffiliatePartner.php # Lớp CTV cao cấp (kế thừa từ AffiliatePartner)
│   └── AffiliateManager.php        # Lớp quản lý danh sách CTV
│
└── README.md                       # Mô tả dự án, hướng dẫn chạy
```

## Hướng dẫn chạy demo
1. Đảm bảo máy có PHP 7.4+.
2. Mở terminal, di chuyển vào thư mục `affiliate-management`.
3. Chạy lệnh:
   ```
   php index.php
   ```
4. Kết quả sẽ hiển thị danh sách cộng tác viên, hoa hồng từng người, tổng hoa hồng hệ thống cần chi trả và log khi các đối tượng bị hủy.

## Mở rộng (gợi ý)
- Thêm bộ lọc cộng tác viên đang hoạt động
- Ghi log lịch sử hoa hồng theo từng đơn hàng vào tệp JSON
- Giao diện nhập liệu đơn giản qua form HTML
