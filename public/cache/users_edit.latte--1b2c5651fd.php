<?php

use Latte\Runtime as LR;

/** source: users_edit.latte */
final class Template_1b2c5651fd extends Latte\Runtime\Template
{
	public const Source = 'users_edit.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>Edit ';
		echo LR\Filters::escapeHtmlText($city->city) /* line 1 */;
		echo '</h1>

<form method="post" action="">
    <label>
        City Name:
';
		if (isset($session->errors)) /* line 6 */ {
			echo '            <ul>
';
			foreach ($session->errors as $error) /* line 8 */ {
				echo '                    <li style="color: red">';
				echo LR\Filters::escapeHtmlText($error) /* line 9 */;
				echo '</li>
';

			}

			echo '            </ul>
';
		}
		echo '
        <input type="text" name="city" value="';
		echo LR\Filters::escapeHtmlAttr($city->city) /* line 14 */;
		echo '">
    </label>
    <br>


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
