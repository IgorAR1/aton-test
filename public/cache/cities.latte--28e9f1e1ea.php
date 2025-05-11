<?php

use Latte\Runtime as LR;

/** source: cities.latte */
final class Template_28e9f1e1ea extends Latte\Runtime\Template
{
	public const Source = 'cities.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>Список городов</h1>

<form id="cityFilterForm" method="get">
    <label>
        <input type="checkbox" data-filter="country">
        Название страны:
        <input type="text" name="filter[country]" value="';
		echo LR\Filters::escapeHtmlAttr($filter['country'] ?? '') /* line 7 */;
		echo '">
    </label>
    <br>

    <label>
        <input type="checkbox" data-filter="city">
        Название города:
        <input type="text" name="filter[city]" value="';
		echo LR\Filters::escapeHtmlAttr($filter['city'] ?? '') /* line 14 */;
		echo '">
    </label>
    <br>

    <label>
        <input type="checkbox" data-filter="id">
        ID:
        <input type="text" name="filter[id]" value="';
		echo LR\Filters::escapeHtmlAttr($filter['id'] ?? '') /* line 21 */;
		echo '">
    </label>
    <br>

    <select name="sort">
        <option value="">Без сортировки</option>
        <option value="id" ';
		if (($sort ?? '') === 'id') /* line 27 */ {
			echo 'selected';
		}
		echo '>Сортировать по ID</option>
        <option value="country" ';
		if (($sort ?? '') === 'country') /* line 28 */ {
			echo 'selected';
		}
		echo '>Сортировать по названию страны</option>
        <option value="city" ';
		if (($sort ?? '') === 'city') /* line 29 */ {
			echo 'selected';
		}
		echo '>Сортировать по названию города</option>
    </select>

    <select name="order">
        <option value="asc" ';
		if (($order ?? '') === 'asc') /* line 33 */ {
			echo 'selected';
		}
		echo '>По возрастанию</option>
        <option value="desc" ';
		if (($order ?? '') === 'desc') /* line 34 */ {
			echo 'selected';
		}
		echo '>По убыванию</option>
    </select>

    <button type="submit">Фильтровать</button>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Название страны</th>
        <th>Название города</th>
    </tr>
';
		foreach ($cities as $city) /* line 46 */ {
			echo '        <tr>
            <td>';
			echo LR\Filters::escapeHtmlText($city->getId()) /* line 48 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($city->getCountry()->getName()) /* line 49 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($city->getName()) /* line 50 */;
			echo '</td>
        </tr>
';

		}

		echo '</table>

<script>
    document.getElementById(\'filterForm\').addEventListener(\'submit\', function (e) {
        const form = e.target;

        // 1. Отключаем невыбранные фильтры
        const checkboxes = form.querySelectorAll(\'input[type=checkbox][data-filter]\');
        checkboxes.forEach(checkbox => {
            const fieldName = checkbox.dataset.filter;
            const input = form.querySelector(`[name="filter[${fieldName}]"]`);
            const isChecked = checkbox.checked;
            const isEmpty = input && input.value.trim() === \'\';

            if (!isChecked || isEmpty) {
                if (input) input.disabled = true;
                checkbox.disabled = true;
            }
        });

        // 2. Отключаем sort/order если не выбраны
        const sort = form.querySelector(\'[name="sort"]\');
        const order = form.querySelector(\'[name="order"]\');

        if (!sort.value) {
            sort.disabled = true;
            order.disabled = true;

        }

    });
</script>
';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['city' => '46'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}
