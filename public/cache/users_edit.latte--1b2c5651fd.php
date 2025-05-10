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

		echo '<h1>Редактировать пользователя ';
		echo LR\Filters::escapeHtmlText($user->getFullName()) /* line 1 */;
		echo '</h1>

<form method="post" action="">

';
		if (session('errors')) /* line 5 */ {
			echo '        <ul>
';
			foreach (session('errors') as $error) /* line 7 */ {
				echo '                <li style="color: red">';
				echo LR\Filters::escapeHtmlText($error) /* line 8 */;
				echo '</li>
';

			}

			echo '        </ul>
';
		}
		echo '
    <p><strong>ID:</strong> ';
		echo LR\Filters::escapeHtmlText($user->getId()) /* line 13 */;
		echo '</p>

    <label>
        Город:
        <select name="city_id" required>
            <option value="">-- выберите город --</option>
';
		foreach ($cities as $city) /* line 19 */ {
			echo '                <option value="';
			echo LR\Filters::escapeHtmlAttr($city->getId()) /* line 20 */;
			echo '" ';
			if ($user->getId() == $city->getId()) /* line 20 */ {
				echo 'selected';
			}
			echo '>
                    ';
			echo LR\Filters::escapeHtmlText($city->getName()) /* line 21 */;
			echo '
                </option>
';

		}

		echo '        </select>
    </label>
    <br>

    <label>
        Имя:
        <input type="text" name="first_name" required value="';
		echo LR\Filters::escapeHtmlAttr($user->getFirstName()) /* line 30 */;
		echo '">
    </label>
    <br>

    <label>
        Фамилия:
        <input type="text" name="last_name" value="';
		echo LR\Filters::escapeHtmlAttr($user->getLastName()) /* line 36 */;
		echo '">
    </label>
    <br>

    <input type="submit" value="Сохранить">
</form>
';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['error' => '7', 'city' => '19'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}
