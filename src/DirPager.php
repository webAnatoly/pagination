<?php


namespace Pagination;


class DirPager extends Pager
{
    protected $dirname;
    public function __construct(
        View $view,
        $dir_name = '.',
        $items_per_page = 10,
        $links_count = 3,
        $get_params = null,
        $counter_param = 'page')
    {
        // Удаляем последний символ /, если он имеется
        $this->dirname = ltrim($dir_name, "/");
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
        // Открываем каталог
        if(($dir = opendir($this->dirname)) !== false) {
            while(($file = readdir($dir)) !== false) {
                // Если текущая позиция является файлом, подсчитываем ее
                if(is_file($this->dirname."/".$file)) {
                    $countline++;
                }
            }
            // Закрываем каталог
            closedir($dir);
        }
        return $countline;
    }

    public function getItems()
    {
        // Текущая страница
        $current_page = $this->getCurrentPage();
        // Общее количество страниц
        $total_pages = $this->getPagesCount();
        // Проверяем, попадает ли запрашиваемый номер
        // страницы в интервал от минимального до максимального
        if($current_page <= 0 || $current_page > $total_pages) {
            return 0;
        }
        // Извлекаем позиции текущей страницы
        $arr = [];
        // Номер, начиная с которого следует
        // выбирать строки файла
        $first = ($current_page - 1) * $this->getItemsPerPage();
        // Открываем каталог
        if(($dir = opendir($this->dirname)) === false) {
            return 0;
        }
        $i = -1;
        while(($file = readdir($dir)) !== false)
        {
            // Если текущая позиция является файлом
            if(is_file($this->dirname."/".$file)) {
                // Увеличиваем счетчик
                $i++;
                // Пока не достигнут номер $first, досрочно заканчиваем итерацию
                if($i < $first) continue;
                // Если достигнут конец выборки, досрочно покидаем цикл
                if($i > $first + $this->getItemsPerPage() - 1) break;
                // Помещаем пути к файлам в массив, который будет возвращен методом
                $arr[] = $this->dirname."/".$file;
            }
        }
        // Закрываем каталог
        closedir($dir);

        return $arr;
    }
}