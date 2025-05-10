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
';
		if (session('errors')) /* line 4 */ {
			echo '        <ul>
';
			foreach (session('errors') as $error) /* line 6 */ {
				echo '                <li style="color: red">';
				echo LR\Filters::escapeHtmlText($error) /* line 7 */;
				echo '</li>
';

			}

			echo '        </ul>
';
		}
		echo '
    <label>
        <input type="checkbox" data-filter="country">
        Название страны:
        <input type="text" name="filter[country]" value="';
		echo LR\Filters::escapeHtmlAttr($filter['country'] ?? '') /* line 15 */;
		echo '">
    </label>
    <br>

    <label>
        <input type="checkbox" data-filter="id">
        ID:
        <input type="text" name="filter[id]" value="';
		echo LR\Filters::escapeHtmlAttr($filter['id'] ?? '') /* line 22 */;
		echo '">
    </label>
    <br>

    <select name="sort">
        <option value="">Без сортировки</option>
        <option value="id" ';
		if (($sort ?? '') === 'id') /* line 28 */ {
			echo 'selected';
		}
		echo '>Сортировать по ID</option>
        <option value="country" ';
		if (($sort ?? '') === 'country') /* line 29 */ {
			echo 'selected';
		}
		echo '>Сортировать по названию страны</option>
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
        <th>Название</th>
    </tr>
';
		foreach ($countries as $country) /* line 45 */ {
			echo '        <tr>
            <td>';
			echo LR\Filters::escapeHtmlText($country->getId()) /* line 47 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($country->getName()) /* line 48 */;
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
			foreach (array_intersect_key(['error' => '6', 'country' => '45'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}
