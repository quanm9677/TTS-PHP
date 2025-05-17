<?php
// controllers/BrandController.php

class BrandController
{
    public function getByCategory()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $category = $_GET['category'] ?? '';
        $xmlPath = realpath(__DIR__ . '/../data/brands.xml');
        file_put_contents("debug.log", "Category yêu cầu: " . $category . PHP_EOL, FILE_APPEND);


        if (!$xmlPath || !file_exists($xmlPath)) {
            echo "<option value=''>Không tìm thấy file XML tại $xmlPath</option>";
            return;
        }

        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($xmlPath);   
        if ($xml === false) {
            echo "Lỗi đọc XML:<br>";
            foreach (libxml_get_errors() as $error) {
                echo $error->message . "<br>";
            }
        } else {
            echo "Tải XML thành công!";
        }
        
        $brands = [];

        foreach ($xml->category as $cat) {
            if (strcasecmp(trim((string)$cat['name']), trim($category)) === 0) {
                foreach ($cat->brand as $brand) {
                    $brands[] = (string)$brand;
                }
                break;
            }
        }

        if (empty($brands)) {
            echo "<option value=''>Không có thương hiệu nào</option>";
        } else {
            foreach ($brands as $brand) {
                echo "<option value='" . htmlspecialchars($brand) . "'>" . htmlspecialchars($brand) . "</option>";
            }
        }
    }
}
