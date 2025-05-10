<?php

use Latte\Runtime as LR;

/** source: cities_edit.latte */
final class Template_775442df6d extends Latte\Runtime\Template
{
	public const Source = 'cities_edit.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>Edit ';
		echo LR\Filters::escapeHtmlText($city->getName()) /* line 1 */;
		echo '</h1>

<form method="post" action="">
    <label>
        City Name:
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
        <input type="text" name="city" value="';
		echo LR\Filters::escapeHtmlAttr($city->getName()) /* line 14 */;
		echo '">
    </label>
    <br>
    <label>
        Country:
        <select name="country_id" required>
            <option value="">-- выберите страну--</option>
';
		foreach ($countries as $country) /* line 21 */ {
			echo '                <option value="';
			echo LR\Filters::escapeHtmlAttr($country->getId()) /* line 22 */;
			echo '" ';
			if ($city->getId() == $country->getId()) /* line 22 */ {
				echo 'selected';
			}
			echo '>
                    ';
			echo LR\Filters::escapeHtmlText($country->getName()) /* line 23 */;
			echo '
                </option>
';

		}

		echo '        </select>
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
			foreach (array_intersect_key(['error' => '8', 'country' => '21'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}
