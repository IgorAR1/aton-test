<?php

use Latte\Runtime as LR;

/** source: countries_edit.latte */
final class Template_1d4456cd5b extends Latte\Runtime\Template
{
	public const Source = 'countries_edit.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>Edit ';
		echo LR\Filters::escapeHtmlText($country->getName()) /* line 1 */;
		echo '</h1>

<form method="post" action="">
    <label>
        Country:
';
		if (session('errors')) /* line 6 */ {
			echo '            <ul>
';
			foreach (session('errors') as $error) /* line 8 */ {
				echo '                    <li style="color: red">';
				echo LR\Filters::escapeHtmlText($error) /* line 9 */;
				echo '</li>
';

			}

			echo '            </ul>
';
		}
		echo '
        <input type="text" name="country" value="';
		echo LR\Filters::escapeHtmlAttr($country->getName()) /* line 14 */;
		echo '">
    </label>

    <input type="submit" value="Edit">
</form>
';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['error' => '8'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}
