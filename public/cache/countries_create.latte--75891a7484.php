<?php

use Latte\Runtime as LR;

/** source: countries_create.latte */
final class Template_75891a7484 extends Latte\Runtime\Template
{
	public const Source = 'countries_create.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>Create country</h1>

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
        <input type="text" name="country" placeholder="Country">
    </label>

    <input type="submit" value="Создать">
</form>
';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['error' => '9'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}
