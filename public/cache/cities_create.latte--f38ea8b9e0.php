<?php

use Latte\Runtime as LR;

/** source: cities_create.latte */
final class Template_f38ea8b9e0 extends Latte\Runtime\Template
{
	public const Source = 'cities_create.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>Create city</h1>

<form method="post">
    <label>
        Country:

';
		if (session('errors')) /* line 7 */ {
			echo '            <ul>
';
			foreach (session('errors') as $error) /* line 9 */ {
				echo '                    <li style="color: red">';
				echo LR\Filters::escapeHtmlText($error) /* line 10 */;
				echo '</li>
';

			}

			echo '            </ul>
';
		}
		echo '
        <input type="text" name="city" placeholder="City">

        <select name="country_id">
';
		foreach ($countries as $country) /* line 18 */ {
			echo '                <option value="';
			echo LR\Filters::escapeHtmlAttr($country->getId()) /* line 19 */;
			echo '">';
			echo LR\Filters::escapeHtmlText($country->getName()) /* line 19 */;
			echo '</option>
';

		}

		echo '        </select>
    </label>

    <input type="submit" value="Создать">
</form>
';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['error' => '9', 'country' => '18'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}
