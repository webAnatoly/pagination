<?php


namespace Pagination;


class FilePager extends Pager
{
    protected $filename;
    public function __construct(
        View $view,
        $filename = '.',
        $items_per_page = 10,
        $links_count = 3,
        $get_params = null,
        $counter_param = 'page')
    {
        $this->filename = $filename;
        // Инициализируем переменные через конструктор базового класса
        parent::__construct(
            $view,
            $items_per_page,
            $links_count,
            $get_params,
            $counter_param);
    }

    public function getItemsCount()
    {
        $countline = 0;
        // Открываем файл
        $fd = fopen($this->filename, "r");
        if($fd) {
            // Подсчитываем количество записей в файле
            while(!feof($fd)) {
                fgets($fd, 10000);
                $countline++;
            }
            // Закрываем файл
            fclose($fd);
        }
        return $countline;
    }

    public function getItems()
    {
        // Текущая страница
        $current_page = $this->getCurrentPage();
        // Количество позиций
        $total = $this->getItemsCount();
        // Общее количество страниц
        $total_pages = $this->getPagesCount();
        // Проверяем, попадает ли запрашиваемый номер
        // страницы в интервал от минимального до максимального
        if($current_page <= 0 || $current_page > $total_pages) {
            return 0;
        }
        // Извлекаем позиции текущей страницы
        $arr = [];
        $fd = fopen($this->filename, "r");
        if(!$fd) return 0;
        // Номер, начиная с которого следует
        // выбирать строки файла
        $first = ($current_page - 1) * $this->getItemsPerPage();
        for($i = 0; $i < $total; $i++) {
            $str = fgets($fd, 10000);
            // Пока не достигнут номер $first,
            // досрочно заканчиваем итерацию
            if($i < $first) continue;
            // Если достигнут конец выборки, досрочно покидаем цикл
            if($i > $first + $this->getItemsPerPage() - 1) break;
            // Помещаем строки файла в массив,
            // который будет возвращен методом
            $arr[] = $str;
        }
        fclose($fd);

        return $arr;
    }
}