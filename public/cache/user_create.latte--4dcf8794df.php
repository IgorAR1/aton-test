<?php

use Latte\Runtime as LR;

/** source: user_create.latte */
final class Template_4dcf8794df extends Latte\Runtime\Template
{
	public const Source = 'user_create.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>Create user</h1>

<form method="post">
    <label>
        First name:
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
		echo '        <input type="text" name="first_name" placeholder="Имя">
    </label>
    <br>

    <label>
        Last name:
        <input type="text" name="last_name" placeholder="Фамилия">
    </label>
    <br>

    <label>
        City:
        <select name="city_id">
';
		foreach ($cities as $city) /* line 26 */ {
			echo '                <option value="';
			echo LR\Filters::escapeHtmlAttr($city->getId()) /* line 27 */;
			echo '">';
			echo LR\Filters::escapeHtmlText($city->getName()) /* line 27 */;
			echo '</option>
';

		}

		echo '        </select>
    </label>
    <br>

    <input type="submit" value="Создать">
</form>
';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['error' => '8', 'city' => '26'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}
