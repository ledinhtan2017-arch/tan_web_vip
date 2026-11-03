<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

final class Dao
{
    private const TABLES = [
        'giaovien' => 'Danh sách giáo viên',
        'sinhvien' => 'Danh sách sinh viên',
        'hocphan' => 'Danh sách học phần',
    ];

    private const COLUMNS = [
        'giaovien' => ['magv', 'hoten', 'diachi', 'email'],
        'sinhvien' => ['masv', 'hoten', 'diachi', 'lop'],
        'hocphan' => ['mahp', 'tenhp', 'sotinchi'],
    ];

    public function __construct(private PDO $connection)
    {
    }

    public function table(string $table): string
    {
        if (!isset(self::TABLES[$table])) {
            throw new InvalidArgumentException('Bảng dữ liệu không hợp lệ.');
        }

        $columns = self::COLUMNS[$table];
        $select = implode(', ', array_map(
            static fn (string $column): string => "`{$column}`",
            $columns
        ));
        $rows = $this->connection->query("SELECT {$select} FROM `{$table}`")->fetchAll();
        $html = '<h2>' . e(self::TABLES[$table]) . '</h2><table><thead><tr>';

        foreach ($columns as $column) {
            $html .= '<th>' . e((string) $column) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($rows as $row) {
            $html .= '<tr>';
            foreach ($columns as $column) {
                $html .= '<td>' . e((string) ($row[$column] ?? '')) . '</td>';
            }
            $html .= '</tr>';
        }

        if (!$rows) {
            $html .= '<tr><td colspan="' . count($columns) . '">Chưa có dữ liệu.</td></tr>';
        }

        return $html . '</tbody></table>';
    }
}
