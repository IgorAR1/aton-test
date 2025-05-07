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
		echo LR\Filters::escapeHtmlAttr($filter['country'] ?? '') /* line 22 */;
		echo '">
    </label>
    <br>

    <label>
        <input type="checkbox" data-filter="city">
        Название города:
        <input type="text" name="filter[city]" value="';
		echo LR\Filters::escapeHtmlAttr($filter['city'] ?? '') /* line 29 */;
		echo '">
    </label>
    <br>

    <select name="sort">
        <option value="">Без сортировки</option>
        <option value="id" ';
		if (($sort ?? '') === 'id') /* line 35 */ {
			echo 'selected';
		}
		echo '>По ID</option>
        <option value="country" ';
		if (($sort ?? '') === 'country') /* line 36 */ {
			echo 'selected';
		}
		echo '>По названию страны</option>
        <option value="city" ';
		if (($sort ?? '') === 'city') /* line 37 */ {
			echo 'selected';
		}
		echo '>По названию города</option>
        <option value="name" ';
		if (($sort ?? '') === 'name') /* line 38 */ {
			echo 'selected';
		}
		echo '>По фамилии + имени</option>
    </select>

    <select name="order">
        <option value="asc" ';
		if (($order ?? '') === 'asc') /* line 42 */ {
			echo 'selected';
		}
		echo '>По возрастанию</option>
        <option value="desc" ';
		if (($order ?? '') === 'desc') /* line 43 */ {
			echo 'selected';
		}
		echo '>По убыванию</option>
    </select>

    <button type="submit">Фильтровать</button>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Название страны</th>
        <th>Название города</th>
    </tr>
';
		foreach ($users as $user) /* line 57 */ {
			echo '        <tr>
            <td>';
			echo LR\Filters::escapeHtmlText($user['id']) /* line 59 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($user['last_name']) /* line 60 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($user['first_name']) /* line 61 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($user['country']) /* line 62 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($user['city']) /* line 63 */;
			echo '</td>
        </tr>
';

		}

		echo '</table>

<script>
    document.getElementById(\'userFilterForm\').addEventListener(\'submit\', function (e) {
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
			foreach (array_intersect_key(['user' => '57'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}
