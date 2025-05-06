<?php

use Latte\Runtime as LR;

/** source: countries.latte */
final class Template_ea19e92d56 extends Latte\Runtime\Template
{
	public const Source = 'countries.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>Список стран</h1>

<form id="filterForm" method="get">
    <label>
        <input type="checkbox" data-filter="country">
        Название страны:
        <input type="text" name="filter[country]" value="';
		echo LR\Filters::escapeHtmlAttr($filter['country'] ?? '') /* line 7 */;
		echo '">
    </label>
    <br>

    <label>
        <input type="checkbox" data-filter="id">
        ID:
        <input type="text" name="filter[id]" value="';
		echo LR\Filters::escapeHtmlAttr($filter['id'] ?? '') /* line 14 */;
		echo '">
    </label>
    <br>

    <select name="sort">
        <option value="">Без сортировки</option>
        <option value="id" ';
		if (($sort ?? '') === 'id') /* line 20 */ {
			echo 'selected';
		}
		echo '>Сортировать по ID</option>
        <option value="country" ';
		if (($sort ?? '') === 'country') /* line 21 */ {
			echo 'selected';
		}
		echo '>Сортировать по названию страны</option>
    </select>

    <select name="order">
        <option value="asc" ';
		if (($order ?? '') === 'asc') /* line 25 */ {
			echo 'selected';
		}
		echo '>По возрастанию</option>
        <option value="desc" ';
		if (($order ?? '') === 'desc') /* line 26 */ {
			echo 'selected';
		}
		echo '>По убыванию</option>
    </select>

    <button type="submit">Фильтровать</button>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Название</th>
    </tr>
';
		foreach ($countries as $country) /* line 37 */ {
			echo '        <tr>
            <td>';
			echo LR\Filters::escapeHtmlText($country['id']) /* line 39 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($country['country']) /* line 40 */;
			echo '</td>
        </tr>
';

		}

		echo '</table>

<script>
    document.getElementById(\'filterForm\').addEventListener(\'submit\', function (e) {
        const form = e.target;

        const checkboxes = form.querySelectorAll(\'input[type=checkbox][data-filter]\');

        checkboxes.forEach(checkbox => {
            const fieldName = checkbox.dataset.filter;
            const input = form.querySelector(`[name="filter[${fieldName}]"]`);

            if (!checkbox.checked) {
                if (input) input.disabled = true;
                checkbox.disabled = true;
            }
        });
    });
</script>
';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['country' => '37'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}
