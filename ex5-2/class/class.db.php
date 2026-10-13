<?php
require_once __DIR__ . '/../config.php';

class DB {
    protected $link;

    public function __construct() {
        global $config;

        $this->link = mysqli_connect(
            $config['host'],
            $config['user'],
            $config['pass'],
            $config['data']
        );

        if (!$this->link) {
            throw new RuntimeException('Không thể kết nối cơ sở dữ liệu: ' . mysqli_connect_error());
        }

        if (!mysqli_set_charset($this->link, 'utf8mb4')) {
            throw new RuntimeException('Không thể thiết lập bộ mã UTF-8: ' . mysqli_error($this->link));
        }
    }

    protected function db_prepare($query, $types = '', $values = []) {
        $statement = mysqli_prepare($this->link, $query);
        if (!$statement) {
            throw new RuntimeException('Không thể chuẩn bị truy vấn: ' . mysqli_error($this->link));
        }

        if ($types !== '') {
            $bindValues = [$types];
            foreach ($values as $index => $value) {
                $bindValues[] = &$values[$index];
            }

            if (!call_user_func_array('mysqli_stmt_bind_param', array_merge([$statement], $bindValues))) {
                $error = mysqli_stmt_error($statement);
                mysqli_stmt_close($statement);
                throw new RuntimeException('Không thể gắn tham số truy vấn: ' . $error);
            }
        }

        if (!mysqli_stmt_execute($statement)) {
            $error = mysqli_stmt_error($statement);
            mysqli_stmt_close($statement);
            throw new RuntimeException('Không thể thực hiện truy vấn: ' . $error);
        }

        return $statement;
    }

    protected function db_fetch($result) {
        return mysqli_fetch_assoc($result);
    }
}
?>
