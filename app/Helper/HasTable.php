<?php


namespace App\Helper;

use App\Exception\V8Exception;
use App\Helper\View\Footer;
use Illuminate\Support\Collection;
use Monolog\Handler\IFTTTHandler;

define("COLUMN_PROPERTY", "prop");
define("COLUMN_META", "meta");

/**
 * Trait HasTable
 * @package Module\Table
 * @need Jquery Datatable
 */
trait HasTable
{
    private static Collection $items;

    private static function table()
    {
        return isset(self::$items) ? self::$items : self::initialize();
    }

    private static function initialize()
    {
        $last = null;
        $cols = collect(static::getDefaultColumns())->map(function ($col) use (&$last) {
            if (is_null($col['priority'])) {
                $col['priority'] = !is_null($last) ? $last['priority'] + 1 : 1;
            }
            $last = $col;
            return $col;
        });
        return self::$items = $cols;
    }

    public static function addTableColumn($slug, $title, $data, $permission = null, $priority = 0)
    {
        if (!self::checkColumnData($data))
            throw new V8Exception("table.unsupported.slug", "Unsupported {$slug} Column Data");

        self::table()->add(compact("slug", "title", "data", "permission", "priority"));
    }

    public static function getTableColumns()
    {
        return self::table()->toArray();
    }

    private static function checkColumnData($data)
    {
        return $data == COLUMN_PROPERTY or $data == COLUMN_META or is_callable($data);
    }

    private static function getData($column, $model)
    {
        return $column["data"] == COLUMN_PROPERTY ?
            $model->{$column["slug"]} :
            ($column["data"] == COLUMN_META ?
                @$model->metaMap()->get($column["slug"])->value :
                $column["data"]($model));
    }

    public static function renderTable(Collection $records, $id = null)
    {
        $id = $id ? $id : str_replace("\\", "_", static::class);
        Footer::create("table", "<script>var {$id} = $('#{$id}').DataTable({'pageLength': 25})</script>");
        return view("table", ["records" => $records, "header" => self::renderTableHeader(), "body" => self::renderTableBody($records), "id" => $id]);
    }

    public static function deleteTableColumn($slug)
    {
        $table = self::table();
        if (is_array($slug))
            self::$items = $table->whereNotIn('slug', $slug);
        else
            self::$items = $table->where('slug', "!=", $slug);
    }

    private static function renderTableHeader()
    {
        $header = '';
        foreach (self::table()->sortBy("priority") as $column) {
            if (self::condition($column))
                $header .= "<th id='{$column['slug']}'>{$column['title']}</th>";
        }
        return $header;
    }

    public function renderRow($column, $record)
    {
        if (self::condition($column))
            return "<td class='{$column['slug']}'>" . self::getData($column, $record) . "</td>";
        return null;
    }

    private static function renderTableBody(Collection $records)
    {
        $body = "";
        foreach ($records as $record) {
            /**
             * @var HasTable $record
             */
            $body .= "<tr class='t-row' data-row='$record->id'>";
            foreach (self::table()->sortBy("priority") as $column) {
                $body .= $record->renderRow($column, $record);
            }
            $body .= "</tr>";
        }
        return $body;
    }

    protected static function getDefaultColumns(): array
    {
        return [];
    }

    public function removeTableColumn()
    {

    }

    private static function condition($column)
    {
        return app("user")->can(@$column["permission"]);
    }
}