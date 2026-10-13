<?php
require_once __DIR__ . '/class.db.php';

class DB_TheLoai extends DB {
    public function get_theloai($id = -1) {
        if ((int)$id === -1) {
            $result = mysqli_query($this->link, 'SELECT idTL, TenTL, ThuTu, AnHien FROM theloai ORDER BY ThuTu, idTL');
            if (!$result) {
                throw new RuntimeException('Không thể lấy danh sách thể loại: ' . mysqli_error($this->link));
            }

            $theloai = [];
            while ($row = $this->db_fetch($result)) {
                $theloai[] = $row;
            }
            mysqli_free_result($result);
            return $theloai;
        }

        $id = (int)$id;
        if ($id <= 0) {
            return [];
        }

        $statement = $this->db_prepare(
            'SELECT idTL, TenTL, ThuTu, AnHien FROM theloai WHERE idTL = ?',
            'i',
            [$id]
        );
        $result = mysqli_stmt_get_result($statement);
        if (!$result) {
            $error = mysqli_stmt_error($statement);
            mysqli_stmt_close($statement);
            throw new RuntimeException('Không thể lấy thể loại: ' . $error);
        }

        $theloai = [];
        while ($row = $this->db_fetch($result)) {
            $theloai[] = $row;
        }
        mysqli_free_result($result);
        mysqli_stmt_close($statement);
        return $theloai;
    }

    public function them_theloai($name, $sort = 0, $show = 1) {
        $name = trim($name);
        $nameLength = preg_match_all('/./us', $name);
        $sort = filter_var($sort, FILTER_VALIDATE_INT);
        $show = filter_var($show, FILTER_VALIDATE_INT);
        if ($name === '' || $nameLength === false || $nameLength > 100 || $sort === false
            || $sort < 0 || $sort > 255 || !in_array($show, [0, 1], true)) {
            return false;
        }

        $statement = $this->db_prepare(
            'INSERT INTO theloai (TenTL, ThuTu, AnHien) VALUES (?, ?, ?)',
            'sii',
            [$name, $sort, $show]
        );
        mysqli_stmt_close($statement);
        return true;
    }

    public function sua_theloai($id, $name, $sort, $show) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $name = trim($name);
        $nameLength = preg_match_all('/./us', $name);
        $sort = filter_var($sort, FILTER_VALIDATE_INT);
        $show = filter_var($show, FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0 || $name === '' || $nameLength === false
            || $nameLength > 100 || $sort === false || $sort < 0 || $sort > 255
            || !in_array($show, [0, 1], true)) {
            return false;
        }

        $statement = $this->db_prepare(
            'UPDATE theloai SET TenTL = ?, ThuTu = ?, AnHien = ? WHERE idTL = ?',
            'siii',
            [$name, $sort, $show, $id]
        );
        mysqli_stmt_close($statement);
        return true;
    }

    public function xoa_theloai($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            return false;
        }

        $statement = $this->db_prepare('DELETE FROM theloai WHERE idTL = ?', 'i', [$id]);
        mysqli_stmt_close($statement);
        return true;
    }
}
?>
