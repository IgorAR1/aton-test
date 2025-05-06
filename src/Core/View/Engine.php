<?php

namespace App\Core\View;

use RuntimeException;

class Engine
{
    protected string $viewsPath;

    public function __construct(string $viewsPath = '/var/www/aton/templates')
    {
        $this->viewsPath = rtrim($viewsPath, '/');
    }

    public function renderToString(string $view, array $args = []): string
    {
        $file = $this->viewsPath . '/' . $view . '.tpl';

        if (!file_exists($file)) {
            throw new RuntimeException("View not found: {$file}");
        }

        $template = file_get_contents($file);

        $template = preg_replace_callback('/\{\%\s*if\s+(.*?)\s*\%\}/', function ($m) {
            return "<?php if ({$m[1]}): ?>";
        }, $template);

        $template = str_replace('{% else %}', '<?php else: ?>', $template);
        $template = str_replace('{% endif %}', '<?php endif; ?>', $template);

        $template = preg_replace_callback('/\{\%\s*foreach\s+(\w+)\s+in\s+(.*?)\s*\%\}/', function ($m) {
            return "<?php foreach (\${$m[2]} as \${$m[1]}): ?>";
        }, $template);

        $template = str_replace('{% endforeach %}', '<?php endforeach; ?>', $template);

        $template = preg_replace_callback('/\{\{\s*(\w+)\.(\w+)\s*\}\}/', function ($m) {
            return "<?= htmlspecialchars(\${$m[1]}['{$m[2]}']) ?>";
        }, $template);

        $template = preg_replace_callback('/\{\{\s*(\w+)\s*\}\}/', function ($m) {
            return "<?= htmlspecialchars(\${$m[1]}) ?>";
        }, $template);

        extract($args, EXTR_SKIP);
        ob_start();
        eval(' ?>' . $template . '<?php ');
        return ob_get_clean();
    }
}