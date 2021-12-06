<?php


namespace App\Helper\View;


use App\Helper\Renderable;

class Notice extends Renderable
{
    public function __construct($items = [])
    {
        $items = $_SESSION['notices'] ?? [];
        parent::__construct($items);
    }

    public static function create($color, $content = "", $css = [], $permission = null, $icon = null, $routes = null, $priority = 0, $closable = true)
    {
        return prop("notices")->add(compact("color", "content", "routes", "permission", "icon", "priority", "css", "closable"));
    }

    public function render($object): ?string
    {
        return view("components.notice", compact("object"));
    }

    public function prioritySort(): Renderable
    {
        return $this;
    }

    public function can($object): bool
    {
        return $this->user()->can($object["permission"]);
    }
}