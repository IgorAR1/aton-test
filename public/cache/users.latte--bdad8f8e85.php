<?php

use Latte\Runtime as LR;

/** source: users.latte */
final class Template_bdad8f8e85 extends Latte\Runtime\Template
{
	public const Source = 'users.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>Список пользователей</h1>
Фильтры:

<form id="userFilterForm" method="get">
    <label>
        <input type="checkbox" data-filter="full_name">
        Имя или фамилия:
        <input type="text" name="filter[full_name]" value="';
		echo LR\Filters::escapeHtmlAttr($filter['full_name'] ?? '') /* line 8 */;
		echo '">
    </label>
    <br>

    <label>
        <input type="checkbox" data-filter="country">
        Название страны:
        <input type="text" name="filter[country]" value="';
		echo LR\Filters::escapeHtmlAttr($filter['country'] ?? '') /* line 15 */;
		echo '">
    </label>
    <br>

    <label>
        <input type="checkbox" data-filter="city">
        Название города:
        <input type="text" name="filter[city]" value="';
		echo LR\Filters::escapeHtmlAttr($filter['city'] ?? '') /* line 22 */;
		echo '">
    </label>
    <br>

    <select name="sort">
        <option value="">Без сортировки</option>
        <option value="id" ';
		if (($sort ?? '') === 'id') /* line 28 */ {
			echo 'selected';
		}
		echo '>По ID</option>
        <option value="country" ';
		if (($sort ?? '') === 'country') /* line 29 */ {
			echo 'selected';
		}
		echo '>По названию страны</option>
        <option value="city" ';
		if (($sort ?? '') === 'city') /* line 30 */ {
			echo 'selected';
		}
		echo '>По названию города</option>
        <option value="first_name" ';
		if (($sort ?? '') === 'name') /* line 31 */ {
			echo 'selected';
		}
		echo '>По фамилии + имени</option>
    </select>

    <select name="order">
        <option value="asc" ';
		if (($order ?? '') === 'asc') /* line 35 */ {
			echo 'selected';
		}
		echo '>По возрастанию</option>
        <option value="desc" ';
		if (($order ?? '') === 'desc') /* line 36 */ {
			echo 'selected';
		}
		echo '>По убыванию</option>
    </select>

    <button type="submit">Filter</button>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>City</th>
        <th>Country</th>
    </tr>
';
		foreach ($users as $user) /* line 50 */ {
			echo '        <tr>
            <td>';
			echo LR\Filters::escapeHtmlText($user->getId()) /* line 52 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($user->getFirstName()) /* line 53 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($user->getLastName()) /* line 54 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($user->getLocation()->city) /* line 55 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($user->getLocation()->country) /* line 56 */;
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
			foreach (array_intersect_key(['user' => '50'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}
