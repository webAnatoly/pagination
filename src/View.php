<?php
/**
 * WebPager - постраничная навигация
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @package    WebPager
 * @subpackage WebPager\View
 */

namespace Pagination;

/**
 * Абстрактный класс представления постраничной навигации
 * @abstract
 */
abstract class View
{
    /**
     * @var Pager объект постраничной навигации
     */
    protected $pager;

    /**
     * Формирует ссылку на страницу
     *
     * @param string $title название ссылки
     * @param int $current_page номер текущей страницы
     * @return string
     */
    public function link($title, $current_page = 1)
    {
        return "<a href='{$this->pager->getCurrentPagePath()}?".
               "{$this->pager->getCounterParam()}={$current_page}".
                "{$this->pager->getParameters()}'>{$title}</a>";
    }

    /**
     * Формирует строку постраничной навигации
     *
     * @abstract
     * @param Pager $pager объект постраничной навигации
     * @return string
     */
    abstract public function render(Pager $pager);
}